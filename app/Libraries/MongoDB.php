<?php

namespace App\Libraries;

use MongoDB\Client;

class MongoDB
{
    private $conn;
    private $host;
    private $port;
    private $user;
    private $password;
    private $name;
    private $enviroment;
    private $cdn = 'localhost';

    public function __construct()
    {
        $this->host = getenv('mongo.local.hostname');
        $this->port = getenv('mongo.local.port');
        $this->user = getenv('mongo.local.user');
        $this->password = getenv('mongo.local.password');
        $this->name = getenv('mongo.local.name');
        $this->enviroment = getenv('CI_ENVIRONMENT');


        try {

            if ($this->enviroment !== 'development') {
                $this->host = getenv('mongo.default.hostname');
                $this->port = getenv('mongo.default.port');
                $this->user = getenv('mongo.default.user');
                $this->password = getenv('mongo.default.password');
                $this->name = getenv('mongo.default.name');

                $this->cdn = sprintf(
                    '%s:%s@%s:%s',
                    $this->user,
                    $this->password,
                    $this->host,
                    $this->port
                );
            }

            $this->conn = (new Client(sprintf('mongodb://%s', $this->cdn)))->{$this->name};
        } catch (\Exception $ex) {
            die('Couldn\'t connect to mongodb: ' . $ex->getMessage() . ' error: ' . 500);
        }
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function tearDown()
    {
        return (new Client(sprintf('mongodb://%s', $this->cdn)))->dropDatabase($this->name);
    }

    public function manager()
    {
        return (new Client(sprintf('mongodb://%s', $this->cdn)))->getManager();
    }

    public function getDatabase()
    {
        return $this->name;
    }
}
