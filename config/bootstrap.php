<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;
use Config\DbConfiguration;
use Respect\Validation\Factory;

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules')
        ->withExceptionNamespace('App\\Validation\\Exceptions')
);


// Set Environment Variables
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();


// Create Container using PHP-DI
$container = new Container();


// Register Services
$services = require __DIR__ . '/services.php';
$services($container);


// Set container to create App with on AppFactory
AppFactory::setContainer($container);


$app = AppFactory::create();
$app->setBasePath('/Programacion-III-SP/public');


// Register Routes
$routes = require __DIR__ . '/routes.php';
$routes($app);


// Add Middlewares
$middlewares = require __DIR__ . '/middlewares.php';
$middlewares($app);


// Initialize DbContext
$dbContext = new DbConfiguration();


return $app;