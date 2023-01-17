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
                    '_id'=>[
                        'bsonType' => 'objectId'
                    ],
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
                    'confirm-password' => [
                        'bsonType' => 'string',
                        'description' => "'confirm-password' must be a string and is required"
                    ],
                    'updated_at' => [
                        'bsonType' => 'date'
                    ],
                    'created_at' => [
                        'bsonType' => 'date'
                    ]

                ],
                'required' => ['name', 'email', 'password'],
                "additionalProperties" => false
            ]
        ]];

        $this->jsonSchema("Users", $schemaValidator);

        return $this;
    }
}
