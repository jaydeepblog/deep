<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{

    private function setSession($username)
    {
        return $this->session->set([
            'username'   => $username,
            'logged_in'  => true,
        ]);
    }

    public function newUser()
    {
        helper('form');
        return view('user\new_user');
    }

    public function createUser()
    {
        helper('form');

        $data = $this->request->getPost(['username', 'email', 'password']);

        if(! $this->validateData($data, [
            'username' => 'required|max_length[16]|min_length[3]',
            'email' => 'required|max_length[255]|min_length[5]',
            'password' => 'required|max_length[20]|min_length[8]',
        ])) {
            return $this->newUser();
        }

        $post = $this->validator->getValidated();
        $hashedPassword = password_hash($post['password'], PASSWORD_DEFAULT);

        $model = model(UserModel::class);
        $returnValue = $model->setUser($post['username'], $post['email'], $hashedPassword);
        $this->setSession($post['username']);

        return redirect()->to('/board');

    }

    public function existingUser()
    {
        helper('form');
        return view('user\existing_user');
    }

    public function verifyUser()
    {
        helper('form');
        $data = $this->request->getPost(['username', 'password']);
        $model = model(UserModel::class);
        $user = $model->getUser($data['username']);

        if(password_verify($data['password'], $user['password'])) {
            $this->setSession($user['username']);
            return redirect()->to('/board');
        }

        return redirect()->back()->with('error', 'Invalid Credentials');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

}