<?php

namespace Tests\Support\Models;
use App\Libraries\MongoDB;

class ExampleModel
{
    protected $collection;
    protected $db;

    public function __construct()
    {
        $connection = new MongoDB();
        $this->db = $connection->getConn();
        $this->collection = $this->db->factories;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function deleteCollection()
    {
        return $this->db->dropCollection('factories');
    }
}
