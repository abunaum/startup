<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Libraries\Itemlibrary;

class Halaman extends BaseController
{
    public $getitem;
    public function __construct()
    {
        $this->getitem = new Itemlibrary;
    }
    public function index()
    {
        $cari = $this->request->getVar('search');
        $produk = $this->produk;
        $produk->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produk->join('users', 'users.id = produk.owner', 'LEFT');
        $produk->select('produk.*');
        $produk->select('toko.username');
        $produk->select('users.status_toko');
        $produk->select('toko.status');
        $produk->where('status_toko', 4);
        $produk->where('toko.status', 1);

        $item = $this->getitem->getsub();
        // print('<pre>');
        // print_r($item);
        // print('<pre>');
        // die();
        if ($cari) {
            $produk = $this->produk->search($cari);
        } else {
            $produk = $produk;
        }
        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item,
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager
        ];
        return view('halaman/beranda', $data);
    }

    public function produk($id = 0)
    {
        $item = $this->getitem->getsub();
        $produk = $this->produk;
        $produk->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $produk->join('users', 'users.id = produk.owner', 'LEFT');
        $produk->select('produk.*');
        $produk->select('toko.username');
        $produk->select('users.status_toko');
        $produk->select('toko.status');
        $produk->where('status_toko', 4);
        $produk->where('toko.status', 1);
        $produk = $produk->kategori($id);

        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item,
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager
        ];
        return view('halaman/beranda', $data);
    }
    //--------------------------------------------------------------------

}
