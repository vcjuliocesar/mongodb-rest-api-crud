<?php

namespace Tests\Support\Models;

use Faker\Factory;
use App\Entities\User;
use CodeIgniter\Test\CIUnitTestCase;

class UserModelTest extends CIUnitTestCase
{
    public function testStore()
    {
        $faker = Factory::create();
        $data = [
            "name" => $faker->name(),
            "email" => $faker->email(),
            "password" => $faker->password()
        ];

        $model = model("UserModel");
        $result = $model->store($data);

        $this->assertTrue($result);

        $user = $model->findBy(["email" => $data['email']]);
        $model->destroy(["_id" => new \MongoDB\BSON\ObjectId($user->_id)]);

        $this->assertNull($model->findBy(['_id' => new \MongoDB\BSON\ObjectId($user->_id)]));
    }

    public function testUserSchemaValidationFail()
    {
        $model = model("UserModel");

        $faker = Factory::create();

        $data = [
            "name" => 1234,
            "email" => $faker->email(),
            "password" => $faker->password()
        ];

        $this->expectException(\RuntimeException::class);

        $result = $model->store($data);

        $this->assertFalse($result);
    }

    public function testUserEntity()
    {
        $faker = Factory::create();
        $data = [
            "name" => $faker->name(),
            "email" => $faker->email(),
            "password" => $faker->password()
        ];
        $user = new User($data);
        $model = model("UserModel");
        $result = $model->store($user->getAttributes());

        $this->assertTrue($result);

        // $user = $model->findBy(["email" => $data['email']]);
        // $model->destroy(["_id" => new \MongoDB\BSON\ObjectId($user->_id)]);

        // $this->assertNull($model->findBy(['_id' => new \MongoDB\BSON\ObjectId($user->_id)]));
    }
}
