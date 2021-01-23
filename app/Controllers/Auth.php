<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        $data = [
            'judul' => "Login | $this->namaweb"
        ];
        return view('auth/login', $data);
    }
    public function register()
    {
        $data = [
            'judul' => "Register | $this->namaweb"
        ];
        return view('auth/register', $data);
    }

    //--------------------------------------------------------------------

}
