<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $user = new \Myth\Auth\Models\UserModel();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin User | $this->namaweb",
            'user' => $user->paginate(10),
            'pager' => $user->pager,
        ];
        return view('admin/user', $data);
    }

    public function detail($id = 0)
    {
        $user = new \Myth\Auth\Models\UserModel();
        $user = $user->where('id', $id);
        $user = $user->get()->getFirstRow();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Detail User| $this->namaweb",
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        echo $user->fullname;
    }
    //--------------------------------------------------------------------

}
