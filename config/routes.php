<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Controllers\PetController;
use App\Controllers\AppointmentController;


use App\Middleware\Authorization;

return function ($app) {

    $app->group('/users', function (RouteCollectorProxy $group) {

        $group->get('[/]', UserController::class . ':getAll');
        $group->post('/signup', UserController::class . ':postSignUp');
        $group->post('/signin', UserController::class . ':postSignIn');
    });

    $app->group('/pets', function (RouteCollectorProxy $group) {


        $group->get('[/]', PetController::class . ':getAll')->add(Authorization::class . ":userAthorization");
        $group->post('/add', PetController::class . ':postPet')->add(Authorization::class . ":clientAthorization");

    });

    $app->group('/appointments', function (RouteCollectorProxy $group) {


        $group->post('/new', AppointmentController::class . ':postAppointment')->add(Authorization::class . ":clientAthorization");

    });
};