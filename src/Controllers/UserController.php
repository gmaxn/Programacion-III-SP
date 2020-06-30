<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use App\Models\Role;

use Respect\Validation\Validator as v;
use App\Validation\ValidatorInterface;
use App\Services\Auth\AuthInterface;


class UserController 
{
    protected $validator;
    protected $auth;

    public function __construct(ValidatorInterface $validator, AuthInterface $auth)
    {
        $this->validator = $validator;
        $this->auth = $auth;
    }

    public function getAll(Request $request, Response $response, $args) {

        $result = json_encode(User::all());

        $response->getBody()->write($result);

        return $response;
    }

    public function postSignUp(Request $request, Response $response, $args) {

        // validate fields
        $validation = $this->validator->validate($request, [
            'email' => v::email()->emailAvailable(),
            'password' => v::noWhitespace()->notEmpty(),
            'role' => v::roleAvailable()
        ]);

        if($validation->failed())
        {
            $response->getBody()->write($validation->getValidationErrors());
            return $response;
        }

        $user = new User();
        $user->email = $request->getParsedBody()['email'];
        $user->password = password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT);
        $role = Role::where('Name', '=', 'veterinario')->firstOrFail();
        $user->roleId = $role->id;
        $user->save();

        $response->getBody()
                 ->write(json_encode([
                            "suceed" => true,
                            "data" => $user
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