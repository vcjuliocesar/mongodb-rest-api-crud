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
        $password = 'Admin123@';
        $fake = Factory::create();
        $data = [
            'name'=>$fake->name(),
            'email'=>$fake->email,
            'password'=>$password,
            'confirm-password' => $password
        ];
        
        $result = $this->post('auth/register',$data);
        $result->assertStatus(ResponseInterface::HTTP_CREATED);
        
        $model = model("UserModel");
        $user = $model->findBy(["email" => $data['email']]);
        $model->destroy(["_id" => new \MongoDB\BSON\ObjectId($user->_id)]);
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

    public function testIsNotValidEmailStructure()
    {
        $password = 'Admin123@';
        $fake = Factory::create();
        $data = [
            'name'=>$fake->name(),
            'email'=>"fail-email.com",
            'password'=>$password,
            'confirm-password' => $password
        ];
        $result = $this->post('auth/register',$data);
        $result->assertStatus(ResponseInterface::HTTP_BAD_REQUEST);
    }

    public function testInvalidPassword()
    {
        $password = 'Admin123@';
        $fake = Factory::create();
        $data = [
            'name'=>$fake->name(),
            'email'=>"fail-email.com",
            'password'=>$password,
            'confirm-password' => "Hola"
        ];
        $result = $this->post('auth/register',$data);
        $result->assertStatus(ResponseInterface::HTTP_BAD_REQUEST);
    }
}