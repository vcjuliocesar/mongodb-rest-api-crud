<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\MongoDB;

class ClientModel
{
    private $db;
    private $conn;
    private $collection;

    public function __construct()
    {
        $this->db = new MongoDB();
        $this->conn = $this->db->getConn();
        $this->collection = $this->conn->Clients;
    }

    public function all()
    {
        try {
            $query = $this->collection->find();

            return $query;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            throw new \RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function store(array $data)
    {
        try {
            $insert = $this->collection->insertOne($data);

            if ($insert->getInsertedCount() == 1) {
                return true;
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            throw new \RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function findBy(array $filter)
    {
        try {
            $query = $this->collection->findOne($filter);

            return $query;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            throw new \RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function destroy(array $filter)
    {
        try {
            $result = $this->collection->deleteOne($filter);

            if ($result->getDeletedCount() == 1) {
                return true;
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            throw new \RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }
}
