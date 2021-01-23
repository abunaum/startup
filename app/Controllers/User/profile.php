<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class profile extends BaseController
{
    public function index()
    {
        $produk = $this->produk;
        $item = $this->item;
        $toko = $this->toko;
        $cari = $this->request->getVar('search');

        if ($cari) {
            $produk = $produk->search($cari);
        } else {
            $produk = $produk;
        }
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'khusus' => "profile",
            'judul' => "Profile | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->findAll(),
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/profile', $data);
    }
    //--------------------------------------------------------------------

}
