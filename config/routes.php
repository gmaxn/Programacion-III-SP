<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Controllers\PetController;
use App\Controllers\AppointmentController;
use App\Controllers\MateriaController;



use App\Middleware\Authorization;

return function ($app) {

    $app->post('/usuario', UserController::class . ':postSignUp');
    $app->post('/login', UserController::class . ':postSignIn');

    



    $app->group('/materias', function (RouteCollectorProxy $group) {

        $group->post('[/]', MateriaController::class . ':postMateria')->add(Authorization::class . ":adminAthorization");
        $group->get('/{id}', PetController::class . ':getAll');

    });

    $app->group('/appointments', function (RouteCollectorProxy $group) {


        $group->post('/new', AppointmentController::class . ':postAppointment')->add(Authorization::class . ":clientAthorization");

    });
};