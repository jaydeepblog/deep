<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $allowedFields = ['username', 'email', 'password', 'pfp_url'];

    function getUser($username) {
        return $this->where(['username' => $username])->first();
    }
    
    function setUser($username, $password, $email) {
        return $this->save([
            'username' => $username,
            'password' => $password,
            'email' => $email,
        ]);
    }

    function setUserGoogle($email, $google_id, $pfp_url) {
        return $this->save([
            'email' => $email,
            'google_id' => $google_id,
            'pfp_url' => $pfp_url,
        ]);
    }
}