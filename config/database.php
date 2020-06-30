<?php
namespace Config;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


class DbConfiguration {

    public function __construct()
    {
        $capsule = new Capsule();
        
        $capsule->addConnection([
            'driver' => $_ENV['DRIVER'],
            'host' => $_ENV['HOST'],
            'database' => $_ENV['DATABASE'],
            'username' => $_ENV['USERNAME'],
            'password' => $_ENV['PASSWORD'],
            'charset' => $_ENV['CHARSET'],
            'collation' => $_ENV['COLLATION'],
            'prefix' => $_ENV['PREFIX']
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}