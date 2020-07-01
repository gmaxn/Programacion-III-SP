<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Users;
use App\Models\Role;
use App\Models\Materias;


use Respect\Validation\Validator as v;
use App\Validation\ValidatorInterface;
use App\Services\Auth\AuthInterface;
use Firebase\JWT\JWT;



class MateriaController 
{
    protected $validator;
    protected $auth;

    public function __construct(ValidatorInterface $validator, AuthInterface $auth)
    {
        $this->validator = $validator;
        $this->auth = $auth;
    }


    public function postMateria(Request $request, Response $response, $args) {
        
/*
        // validate fields
        $validation = $this->validator->validate($request, [
            'materia' => v::vetExists(),
            'cuatrimestre' => v::timeAvailable(),
            'vacantes' => v::timeAvailable(),
            'profesor' => v::timeAvailable(),

        ]);

        if($validation->failed())
        {
            $response->getBody()->write($validation->getValidationErrors());
            return $response;
        }*/

        $materia = new Materias();
        $materia->materia = $request->getParsedBody()['materia'];
        $materia->cuatrimestre = $request->getParsedBody()['cuatrimestre'];
        $materia->vacantes = $request->getParsedBody()['vacantes'];
        $materia->profesor_id = $request->getParsedBody()['profesor'];

        $materia->save();

        $response->getBody()
                 ->write(json_encode([
                            "suceed" => true,
                            "data" => $materia
                        ]));

        return $response;
    }


}