<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\MongoDB;

class UserModel
{
    private $db;
    private $conn;
    private $collection;

    public function __construct()
    {
        $this->db = new MongoDB();
        $this->conn = $this->db->getConn();
        $this->collection = $this->conn->Users;
    }

    public function store(array $data)
    {
        $insert = $this->collection->insertOne($data);

        if($insert->getInsertedCount() == 1) {
            return true;
        }

        return false;
    }
}
