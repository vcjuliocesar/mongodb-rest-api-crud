<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Mongo\Dispatcher;
//use App\Schemas\User;


class SchemaValidation extends BaseCommand
{
    protected $group       = 'mongodb';
    protected $name        = 'app:schemas';
    protected $description = 'Run mongodb schemas.';

    public function run(array $params)
    {
        try {
            if (!empty($params)) {
                (new Dispatcher)->dispatch($params[0]);
                CLI::write('Success: ' . CLI::color('run migration ' . $params[0], 'green'));
            } else {
                (new Dispatcher)->dispatch();
                CLI::write('Success: ' . CLI::color('run all migrations', 'green'));
            }
        } catch (\MongoDB\Driver\Exception\CommandException $ex) {
            CLI::write('CommandException: ' . CLI::color($ex->getMessage(), 'yellow'));
        } catch (\Exception $ex) {
            CLI::write('Exception: ' . CLI::color($ex->getMessage(), 'yellow'));
        }
    }
}
