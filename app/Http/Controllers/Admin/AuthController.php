<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Constant\Code;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Response;
use Exception;
use Throwable;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class AuthController extends AccessTokenController
{
	
    public function logout(ServerRequestInterface $req)
    { 
        return [
          'code' => Code::SUCCESS,
          'msg' => "success",
          'data' => [],
          'timestamp' => time()
        ];
	}
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(ServerRequestInterface $req)
    { 
		$param = (array) $req->getParsedBody();	
		$param['grant_type']="password";
		$param['client_id']=config("shop")["auth"]["client"];
		$param['client_secret']=config("shop")["auth"]["secret"];
		$request=$req->withParsedBody($param);
		$requestParameters1 = (array) $request->getParsedBody();

        return $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }	
	
    /**
     * Convert a PSR7 response to a Illuminate Response.
     *
     * @param \Psr\Http\Message\ResponseInterface $psrResponse
     * @return \Illuminate\Http\Response
     */
    public function convertResponse($psrResponse)
    {
		$data['code']=Code::SUCCESS;
		$data['data']=json_decode($psrResponse->getBody());;
		$data['error']="";
		$data['msg']="success";
		$data['timestamp']=time();
        return new Response(
            json_encode($data),
            $psrResponse->getStatusCode(),
            $psrResponse->getHeaders()
        );
    }
    protected function withErrorHandling($callback)
    {
        try {
            return $callback();
        } catch (OAuthServerException $e) {
			$data['code']=Code::FAIL;
			$data['data']=[];
			$data['error']="帐号密或密码错误";
			$data['msg']="帐号密或密码错误";
			$data['timestamp']=time();
			return $data;
        } catch (Exception $e) {
            $this->exceptionHandler()->report($e);

            return new Response($this->configuration()->get('app.debug') ? $e->getMessage() : 'Error.', 500);
        } catch (Throwable $e) {
            $this->exceptionHandler()->report(new FatalThrowableError($e));

            return new Response($this->configuration()->get('app.debug') ? $e->getMessage() : 'Error.', 500);
        }
    }
}
