<?php

namespace App\Mongo;

use App\Libraries\MongoDB;

use MongoDB\Database;

class MonngoServices
{

    private $collectionName = '';
    private $driver;
    private $manager;
    private $conn;
    private $database;
    private $fields;


    public function __construct()
    {
        $this->driver = new MongoDB();
        $this->manager = $this->driver->Manager();
        $this->conn = $this->driver->getConn();
        $this->database = new Database($this->manager, $this->driver->getDatabase());
    }

    public function forge()
    {
        if (empty($this->collectionName) || $this->collectionName === null) {
            throw new \Exception('collectionName is empty');
        }

        if (empty($this->fields)) {
            throw new \Exception('fields are empty');
        }

        if ($this->collectionExists($this->collectionName)) {
            $this->schema = $this->database->modifyCollection($this->collectionName, $this->fields);
        } else {
            $this->schema = $this->conn->createCollection($this->collectionName, $this->fields);
        }

        return $this->schema;
    }

    public function setFields(array $fields)
    {
        if (empty($fields)) {
            throw new \Exception('fields are empty');
        }

        $this->fields = $fields;
    }

    protected function setCollectionName(string $collection)
    {
        $this->collectionName = $collection;
    }

    protected function getCollectionName()
    {
        return $this->collectionName;
    }

    private function collectionExists(string $name)
    {
        try {
            $flag = false;
            $collections = [];
            foreach ($this->database->listCollectionNames() as $collectionName) {
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
