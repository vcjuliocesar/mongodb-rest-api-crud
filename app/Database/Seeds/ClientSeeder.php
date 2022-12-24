<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Mongo\MongoSeeder;
use Faker\Factory;

class ClientSeeder extends MongoSeeder
{
    public function run()
    {
        $builder = $this->db->Clients;

        for ($i = 0; $i < 10; $i++) {
            $builder->insertOne($this->generateClient());
        }
    }

    private function generateClient(): array
    {
        $faker = Factory::create();
        return [
            'name' => $faker->name(),
            'email' => $faker->email,
            'retainer_fee' => random_int(100000, 100000000)
        ];
    }
}
