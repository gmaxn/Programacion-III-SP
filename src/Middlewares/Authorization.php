<?php
namespace App\Middleware;

use Psr\Http\Message\MessageInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use App\Models\Role;
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
    public function adminAthorization(Request $request, RequestHandler $handler)
    {
        
        $token = $request->getHeaders()['token'];
        
        $result = $this->auth->authorize($token);

        var_dump($result);die;
        
        Role::where('id', '=', $result->data->userContext->tipo_id);

        if(!$result->status || $result->data->userContext->tipo_id != 1)
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
}