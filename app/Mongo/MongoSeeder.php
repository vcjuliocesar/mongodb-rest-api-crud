<?php

namespace App\Mongo;

use App\Libraries\MongoDB;
use CodeIgniter\CLI\CLI;

/**
 * Loads the specified seeder and runs it.
 *
 * @throws InvalidArgumentException
 */
class MongoSeeder
{
    protected $db;
    private $seedPath;

    public function __construct()
    {
        $this->seedPath = APPPATH . 'Database/';
        $this->seedPath = rtrim($this->seedPath, '\\/') . '/Seeds/';

        if (!is_dir($this->seedPath)) {
            throw new \InvalidArgumentException('Unable to locate the seeds directory. Please check Config\Database::filesPath');
        }

        $this->db = (new MongoDB())->getConn();
    }

    public function call(string $class)
    {
        $class = trim($class);

        if ($class === '') {
            throw new \InvalidArgumentException('No seeder was specified.');
        }

        $path = $this->seedPath . str_replace('.php', '', $class) . '.php';
        if (!is_file($path)) {
            throw new \InvalidArgumentException('The specified seeder is not a valid file: ' . $path);
        }
        $class = APP_NAMESPACE . '\Database\Seeds\\' . $class;

        if (!class_exists($class, false)) {
            require_once $path;
        }
        $seeder = new $class();
        $seeder->run();
        unset($seeder);
        if (is_cli()) {
            CLI::write("Seeded: {$class}", 'green');
        }
    }
}
