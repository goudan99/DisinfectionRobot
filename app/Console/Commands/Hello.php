<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Swoole\Process;
use Swoole\Coroutine;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;

class Hello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这是一个测试';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		//$pool = new Process\Pool(5);
		
		//$pool->set(['enable_coroutine' => true]);
		
		//$pool->on('WorkerStart', function (Process\Pool $pool, $workerId) {
			/** 当前是 Worker 进程 */
			//echo "Worker#{$workerId} is started\n";
			//单个进程必须独占一个连接
			//$this->rabbitMqServer();
			$this->mqttServer();
		//});
		
		//$pool->on('WorkerStop', function (\Swoole\Process\Pool $pool, $workerId) {
			//echo("[Worker #{$workerId}] WorkerStop\n");
		//});
		
		//$pool->start();
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
				
				//echo "\n--------\n";
				//echo $message->body;
				//echo "\n--------\n";

				//$message->ack();

				// Send a message with the string "quit" to cancel the consumer.
				//if ($message->body === 'quit') {
				//	$message->getChannel()->basic_cancel($message->getConsumerTag());
				//}
			});
			
			// Loop as long as the channel has callbacks registered
			while ($channel->is_consuming()) {
				$channel->wait();
			}
		}catch (AMQPConnectionClosedException $exception) {
			var_dump($exception);
		}

	}
	function mqttServer($workerId = 0)
	{
		$server   = 'robot_rabbitmq';
		$port     = 1883;
		$clientId = 'hello';
		$username = 'guest';
		$password = 'guest';

		$connectionSettings  = new \PhpMqtt\Client\ConnectionSettings();

		$mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
		$mqtt->connect($username, $password, $connectionSettings, true);
		$mqtt->publish('mqtt-subscription-helloqos0', 'Hello World!', 0);
		$mqtt->subscribe('mqtt-subscription-helloqos0',  function (string $topic, string $message, bool $retained) {
              echo $message;
         });
		$mqtt->loop(true);
		$mqtt->disconnect();
		
	}
	
	function rabbitMqServer2($workerId = 0)
	{
		try {
			$exchangeName = 'trade';
			$routeKey = '/trade';
			$queueName = 'trade';
			//建立连接
			$conn = new AMQPConnection([
				'host' => '127.0.0.1',
				'port' => 5672,
				'vhost' => '/',
				'login' => 'guest',
				'password' => 'guest',
			]);
			$conn->connect();
			//创建通道
			$channel = new AMQPChannel($conn);
			//创建队列
			$queue = new AMQPQueue($channel);
			$queue->setName($queueName);
			$queue->declareQueue();
			//绑定路有关系监听
			$queue->bind($exchangeName, $routeKey);
			//消费[没有数据就是阻塞状态，有数据才会执行]
			$queue->consume(function ($envelope, $queue) use ($workerId) {
				var_dump($workerId);
				var_dump($envelope->getBody());
				$queue->ack($envelope->getDeliveryTag());//分布式手动应答机制
			});
		} catch (\Exception $exception) {
			var_dump($exception);
		}
	}
}
