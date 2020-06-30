<?php
namespace App\Middleware;

use Psr\Http\Message\MessageInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use App\Services\Auth\AuthInterface;

class Authorization
{
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }


    public function clientAthorization(Request $request, RequestHandler $handler)
    {

        $token = $request->getHeaders()['Authorization'];
        
        $result = $this->auth->authorize($token);


        if(!$result->status || $result->data->userContext->role != 'cliente')
        {

            $response = new Response();

            $response->getBody()->write(json_encode([
                "succeed" => false,
                "message" => 'Unauthorized'
            ]));

            return $response->withStatus(401, 'unauthorized');
        }

        return $handler->handle($request);
    }
    public function userAthorization(Request $request, RequestHandler $handler)
    {
        $path = "userAthorization";
        var_dump($path);     
        die;

        $token = $request->getHeaders()['Authorization'];
        
        $result = $this->auth->authorize($token);

        if(!$result->succeed)
        {

        }
        var_dump($result);
        die;

    }   
}