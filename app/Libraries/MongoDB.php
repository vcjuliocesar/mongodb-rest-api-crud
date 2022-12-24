<?php

namespace App\Libraries;

use MongoDB\Client;
use MongoDB\Database;

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

    /**
     * @desc connecting to Mongodb
     * @return void - return connection
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @desc delete database
     * @return array|object - Command result document
     */
    public function tearDown()
    {
        return (new Client(sprintf('mongodb://%s', $this->cdn)))->dropDatabase($this->name);
    }

    /**
     * @desc return database name
     * @return string - database name
     */
    public function getDatabase()
    {
        return $this->name;
    }

    /**
     * @desc create a collection with jsonschema validation
     * @param string - $collectionName - this is the name of the collection
     * @param array - this the schema validation
     * @return array|object - Command result document
     */
    public function CreateCollection(string $collectionName, array $schema)
    {
        return $this->conn->createCollection($collectionName, $schema);
    }

    /**
     * @desc modify a collection with jsonschema validation
     * @param string - $collectionName - this is the name of the collection
     * @param array - this the schema validation
     * @return array|object - Command result document
     */
    public function ModifyCollection(string $collectionName, array $schema)
    {
        return $this->database()->modifyCollection($collectionName, $schema);
    }

    /**
     * @desc return manager
     * @return 
     */
    private function manager()
    {
        return (new Client(sprintf('mongodb://%s', $this->cdn)))->getManager();
    }

    /**
     * @desc return manager
     * @return
     */
    private function database()
    {
        return new Database($this->manager(), $this->name);
    }

    /**
     * @desc validate if collection exists
     * @param string name - collection name
     * @return bool - true or false
     */
    public function collectionExists(string $name): bool
    {
        try {
            $flag = false;
            $collections = [];
            foreach ($this->database()->listCollectionNames() as $collectionName) {
                $collections[] = $collectionName;
            }

            if (in_array($name, $collections)) {
                $flag = true;
            }
            return $flag;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
