<?php

namespace Test\App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use Faker\Factory;
use Exception;
use Error;

class AuthControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testRegisterUser()
    {
        $fake = Factory::create();
        $data = [
            'name'=>$fake->name(),
            'email'=>$fake->email(),
            'password'=>'Admin123@'
        ];
        $result = $this->post('auth/register',$data);
        $result->assertStatus(ResponseInterface::HTTP_CREATED);
    }

    public function testRegisterUserFail()
    {
        $data = [
            'name'=>"",
            'email'=>"",
            'password'=>""
        ];
        $result = $this->post('auth/register',$data);
        $result->assertStatus(ResponseInterface::HTTP_BAD_REQUEST);
    }
}
