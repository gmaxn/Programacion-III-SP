<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Pet;


use Respect\Validation\Validator as v;
use App\Validation\ValidatorInterface;
use App\Services\Auth\AuthInterface;
use Firebase\JWT\JWT;



class PetController 
{
    protected $validator;
    protected $auth;

    public function __construct(ValidatorInterface $validator, AuthInterface $auth)
    {
        $this->validator = $validator;
        $this->auth = $auth;
    }

    public function getAll(Request $request, Response $response, $args) {

        $result = json_encode(Pet::all());

        $response->getBody()->write($result);

        return $response;
    }

    public function postPet(Request $request, Response $response, $args) {

        // validate fields
        $validation = $this->validator->validate($request, [
            'name' => v::notEmpty(),
            'age' => v::notEmpty(),
        ]);

        if($validation->failed())
        {
            $response->getBody()->write($validation->getValidationErrors());
            return $response;
        }

        $pet = new Pet();
        $token = $request->getHeaders()['Authorization'];
        $user = JWT::decode($token[0], $_ENV['ACCESS_TOKEN_SECRET'], array('HS256'));

        $pet->name = $request->getParsedBody()['name'];
        $pet->age = $request->getParsedBody()['age'];
        $pet->clientId = $user->userId;
        $pet->save();

        $response->getBody()
                 ->write(json_encode([
                            "suceed" => true,
                            "data" => $pet
                        ]));

        return $response;
    }

    public function postSignIn(Request $request, Response $response, $args) {

        // validate fields
        $validation = $this->validator->validate($request, [
            'email' => v::email(),
            'password' => v::noWhitespace()->notEmpty()
        ]);
            
        if($validation->failed())
        {
            $response->getBody()
                      ->write($validation->getValidationErrors());
            return $response->withStatus(400, 'bad request');
        }
        
        // generate token
        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];

        $result = $this->auth->authenticate($email, $password);

        if(!$result->succeed)
        {
            $response->getBody()
            ->write(json_encode([
                "succeed" => $result->succeed,
                "error" => $result->content
            ]));

            return $response->withStatus(404, 'user not found');;
        }

        if($result->succeed)
        {
            $response->getBody()
            ->write(json_encode([
                "succeed" => $result->succeed,
                "token" => $result->content
            ]));
            
            return $response->withStatus(200);
        }   
    }
}