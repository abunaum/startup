<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\TeleApiLibrary;
use App\Libraries\Itemlibrary;

class order extends BaseController
{
    public function produk($id = 0)
    {
        $pesan = $this->request->getVar('pesan');
        $jumlah = $this->request->getVar('jumlah');
        if (!$this->validate([
            'jumlah' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal membuat order , Coba lagi');

            return redirect()->to(base_url("produk/detail/$id"))->withInput();
        }
        $produk = $this->produk;
        $produk = (object)$produk->detail($id)->first();
        $order = [
            'order'  => [
                'id_produk' => $id,
                'pesan' => $pesan,
                'jumlah' => $jumlah
            ]
        ];

        session()->set($order);
        return redirect()->to(base_url('user/order/produk'));
    }

    public function order()
    {
        $order = session('order');
        $orderid = $order['id_produk'];
        $pesan = $order['pesan'];
        $jumlah = $order['jumlah'];
        session()->remove('order');
        $produk = $this->produk->detail($orderid)->first();
        if ($produk['owner'] == user()->id) {
            session()->setFlashdata('error', 'Dilarang membeli produk sendiri !!!');
            return redirect()->to(base_url("produk/detail/$orderid"));
        } else {
            echo 'mantap';
        }
    }
}
