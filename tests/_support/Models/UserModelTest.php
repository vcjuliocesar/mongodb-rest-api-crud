<?php

namespace Tests\Support\Models;

use Faker\Factory;
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
        $this->assertEquals($result, true);
    }
}
