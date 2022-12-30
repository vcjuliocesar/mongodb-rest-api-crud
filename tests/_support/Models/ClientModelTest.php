<?php

namespace Tests\Support\Models;

use Faker\Factory;
use CodeIgniter\Test\CIUnitTestCase;

class ClientModelTest extends CIUnitTestCase
{
    public function testStore()
    {
        $faker = Factory::create();
        $data = [
            "name" => $faker->name(),
            "email" => $faker->email(),
            "retainer_fee" => random_int(100000, 100000000)
        ];

        $model = model("ClientModel");
        $result = $model->store($data);

        $this->assertTrue($result);

        $user = $model->findBy(["email" => $data['email']]);
        $model->destroy(["_id" => new \MongoDB\BSON\ObjectId($user->_id)]);

        $this->assertNull($model->findBy(['_id' => new \MongoDB\BSON\ObjectId($user->_id)]));
    }

    public function testClientSchemaValidationFail()
    {
        $model = model("ClientModel");

        $faker = Factory::create();

        $data = [
            "name" => 1234,
            "email" => $faker->email(),
            "retainer_fee" => "123"
        ];

        $this->expectException(\RuntimeException::class);

        $result = $model->store($data);

        $this->assertFalse($result);
    }
}
