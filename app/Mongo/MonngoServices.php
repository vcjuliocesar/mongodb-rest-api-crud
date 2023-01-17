<?php

namespace App\Mongo;

use App\Libraries\MongoDB;

class MonngoServices
{
    private $driver;

    public function __construct()
    {
        $this->driver = new MongoDB();
    }

    public function jsonSchema(string $collectionName, array $schema)
    {
        if (empty($collectionName) || $collectionName === null) {
            throw new \Exception('collectionName is empty');
        }

        if (empty($schema)) {
            throw new \Exception('schema is empty');
        }

        if ($this->driver->collectionExists($collectionName)) {
            return $this->driver->ModifyCollection($collectionName, $schema);
        }

        return $this->driver->CreateCollection($collectionName, $schema);
    }
}
