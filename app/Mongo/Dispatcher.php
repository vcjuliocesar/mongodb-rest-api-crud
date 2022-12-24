<?php

namespace App\Mongo;

use App\Schemas\UserSchema;
use App\Schemas\ClientSchema;
use Exception;

class Dispatcher
{
    private $migrations = [];

    private function migrationLists()
    {
        $this->migrations = [
            'users' => (new UserSchema)->up(),
            'clients' => (new ClientSchema)->up(),
        ];

        return $this->migrations;
    }

    public function dispatch($option = 'all')
    {
        $option = trim($option);
        if ($option !== 'all') {
            if (array_key_exists($option, $this->migrationLists())) {
                return $this->migrationLists()[$option];
            }
            throw new Exception("migration $option does not exist");
        }

        return $this->migrationLists();
    }
}
