<?php

namespace App\Console\Commands;

use Throwable;

use Illuminate\Support\Arr;
use SwooleTW\Http\Helpers\OS;
use Illuminate\Console\Command;
use SwooleTW\Http\Server\Manager;
use Illuminate\Console\OutputStyle;
use SwooleTW\Http\HotReload\FSEvent;
use SwooleTW\Http\HotReload\FSOutput;
use SwooleTW\Http\HotReload\FSProcess;
use SwooleTW\Http\Server\AccessOutput;
use SwooleTW\Http\Server\PidManager;
use SwooleTW\Http\Middleware\AccessLog;
use SwooleTW\Http\Server\Facades\Server;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\Console\Output\ConsoleOutput;
use SwooleTW\Http\Commands\HttpServerCommand;
use Swoole\Process;
use Swoole\Coroutine;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;

 
 
class Http extends HttpServerCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:http {action : start|stop|restart|reload|infos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用swoole启动http服务';
	
    /**
     * Run swoole_http_server.
     */
    protected function start()
    {
		echo '正在启动';
        if ($this->isRunning()) {
            $this->error('Failed! swoole_http_server process is already running.');

            return;
        }

        $host = Arr::get($this->config, 'server.host');
        $port = Arr::get($this->config, 'server.port');
        $hotReloadEnabled = Arr::get($this->config, 'hot_reload.enabled');
        $accessLogEnabled = Arr::get($this->config, 'server.access_log');

        $this->info('Starting swoole http server...');
        $this->info("Swoole http server started: <http://{$host}:{$port}>");
        if ($this->isDaemon()) {
            $this->info(
                '> (You can run this command to ensure the ' .
                'swoole_http_server process is running: ps aux|grep "swoole")'
            );
        }

        $manager = $this->laravel->make(Manager::class);
        $server = $this->laravel->make(Server::class);

        if ($accessLogEnabled) {
            $this->registerAccessLog();
        }

        if ($hotReloadEnabled) {
			echo 'hotReloadEnabled';
            $manager->addProcess($this->getHotReloadProcess($server));
        }
		
        $manager->addProcess(new Process(function () {
				$this->rabbitMqServer();
			})
		);
		
        $manager->run();
		
    }
	
	function rabbitMqServer($workerId = 0)
	{
	
		$exchange = 'router';
		
		$queue = 'msgs';
			
		$consumerTag = 'consumer';
		try{
			//建立连接
			$conn = new AMQPStreamConnection('robot_rabbitmq',5672,'guest','guest','/');
			
			$channel = $conn->channel();
			
			$channel->queue_declare($queue, false, true, false, false);
			
			$channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

			$channel->queue_bind($queue, $exchange);
			
			$channel->basic_consume($queue, $consumerTag, false, false, false, false, function($message){
				
				foreach (app(Server::class)->connections as $fd) {
					//推送到websocket,//fd 是客户端号
					$this->info(count(app(Server::class)->connections));
					if (app(Server::class)->isEstablished($fd)) {
					  app(Server::class)->push($fd, "消息内容".$message->body);
					  app(Server::class)->push($fd, "fd:".$fd);
					}
					
				}
				$this->info( "\n--------\n");
				$this->info( $message->body);
				$this->info( "\n--------\n");

				$message->ack();

				// Send a message with the string "quit" to cancel the consumer.
				if ($message->body === 'quit') {
					$message->getChannel()->basic_cancel($message->getConsumerTag());
				}
			});
			
			// Loop as long as the channel has callbacks registered
			while ($channel->is_consuming()) {
				$channel->wait();
			}
		}catch (AMQPConnectionClosedException $exception) {
			var_dump($exception);
		}

	}
}
