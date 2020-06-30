<?php
declare(strict_types=1);

use App\Controllers\UserController;
use App\Services\Auth\Auth;
use App\Services\Auth\AuthInterface;
use App\Validation\ValidatorInterface;
use App\Validation\Validator;
use DI\Container;


return function (Container $container) {

    $container->set(AuthInterface::class, \DI\create(Auth::class));
    $container->set(ValidatorInterface::class, \DI\create(Validator::class));
};