<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Mongo\MongoSeeder;


class MongoSeeders extends BaseCommand
{
    protected $group       = 'mongodb';
    protected $name        = 'db:mongoseed';
    protected $description = 'Run mongodb seeds.';

    public function run(array $params)
    {
        try {
            (new MongoSeeder())->call($params[0]);
        } catch (\MongoDB\Driver\Exception\CommandException $ex) {
            CLI::write('CommandException: ' . CLI::color($ex->getMessage(), 'yellow'));
        } catch (\Exception $ex) {
            CLI::write('Exception: ' . CLI::color($ex->getMessage(), 'yellow'));
        }
    }
}
