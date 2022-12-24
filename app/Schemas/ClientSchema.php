<?php

namespace App\Schemas;

use App\Mongo\MonngoServices;

class ClientSchema extends MonngoServices
{

    public function up()
    {
        $schemaValidator = ['validator' => [
            '$jsonSchema' => [
                'bsonType' => 'object',
                'title' => 'Clients',
                'properties' => [
                    'name' => [
                        'bsonType' => 'string',
                        'description' => "'name' must be a string and is required"
                    ],
                    'email' => [
                        'bsonType' => 'string',
                        'description' => "'email' must be a string and is required"
                    ],
                    'retainer_fee' => [
                        'bsonType' => 'int',
                        'description' => "'retainer_fee' must be a int and is required"
                    ],
                    'updated_at' => [
                        'bsonType' => 'date'
                    ],
                    'created_at' => [
                        'bsonType' => 'date'
                    ]

                ],
                'required' => ['name', 'email', 'retainer_fee'],
            ]
        ]];


        $this->jsonSchema("Clients", $schemaValidator);

        return $this;
    }
}
