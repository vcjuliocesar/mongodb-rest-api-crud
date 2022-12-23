<?php

namespace App\Schemas;

use App\Mongo\MonngoServices;

class UserSchema extends MonngoServices
{

    public function up()
    {
        $schemaValidator = ['validator' => [
            '$jsonSchema' => [
                'bsonType' => 'object',
                'title' => 'Users',
                'properties' => [
                    'name' => [
                        'bsonType' => 'string',
                        'description' => "'name' must be a string and is required"
                    ],
                    'email' => [
                        'bsonType' => 'string',
                        'description' => "'email' must be a string and is required"
                    ],
                    'password' => [
                        'bsonType' => 'string',
                        'description' => "'password' must be a string and is required"
                    ],
                    'updated_at' => [
                        'bsonType' => 'string'
                    ],
                    'created_at' => [
                        'bsonType' => 'string'
                    ]

                ],
                'required' => ['name', 'email', 'password'],
            ]
        ]];

        $this->setCollectionName('Users');

        $this->setFields($schemaValidator);

        $this->forge();
    }
}
