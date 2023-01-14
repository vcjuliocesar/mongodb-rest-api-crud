<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Error;

class AuthController extends BaseController
{
    /**
     * Register a new user
     * @return Response
     */
    public function register()
    {
        try {
            $rules = [
                'name' => [
                    'rules' => 'required',
                    'errors' => 'name is required'
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'email is required',
                        'valid_email' => 'email is not valid'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[255]',
                    'errors' => [
                        'required' => 'password is required',
                    ]
                ],
                'confirm-password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'confirm-password is required',
                        'matches' => 'confirm-password does not match the password field'
                    ]
                ],
            ];

            $input = $this->getRequestInput($this->request);

            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            }
            
            $user = new User($input->getPost());
            $model = model('UserModel');
            $model->store($user->getAttributes());
            return $this->getResponse(['response' => 'user has been created'], ResponseInterface::HTTP_CREATED);
        } catch (Exception $ex) {
            return $this->getResponse(["error" => $ex->getMessage()], ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function login()
    {
    }
}
