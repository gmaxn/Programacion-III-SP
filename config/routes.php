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

    $app->post('/materias', MateriaController::class . ':postMateria')->add(Authorization::class . ":adminAthorization");



    $app->group('/pets', function (RouteCollectorProxy $group) {


        $group->get('[/]', PetController::class . ':getAll')->add(Authorization::class . ":userAthorization");
        $group->post('/add', PetController::class . ':postPet')->add(Authorization::class . ":clientAthorization");

    });

    $app->group('/appointments', function (RouteCollectorProxy $group) {


        $group->post('/new', AppointmentController::class . ':postAppointment')->add(Authorization::class . ":clientAthorization");

    });
};