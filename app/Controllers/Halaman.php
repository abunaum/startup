<?php

namespace App\Controllers;

use App\Libraries\Itemlibrary;

class Halaman extends BaseController
{
    public $getitem;
    protected $request;

    public function __construct()
    {
        $this->getitem = new Itemlibrary();
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
        $produk->where('stok >=', 1);

        $item = $this->getitem->getsub();
        if ($cari) {
            $produk = $this->produk->search($cari);
        } else {
            $produk = $produk;
        }
        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item,
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager,
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
        $produk = $produk->kategori($id);

        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item,
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager,
        ];

        return view('halaman/beranda', $data);
    }

    public function produkdetail($id = 0)
    {
        $item = $this->getitem->getsub();
        $produk = $this->produk;
        $produk = (object)$produk->detail($id)->first();
        $produktoko = $this->produk->produktoko($produk->owner)->findAll();
        // dd($produktoko);

        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'produk' => $produk,
            'validation' => \Config\Services::validation(),
            'produktoko' => $produktoko
        ];

        return view('halaman/produkdetail', $data);
    }

    //--------------------------------------------------------------------
}
