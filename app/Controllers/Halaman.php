<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Halaman extends BaseController
{
    public function index()
    {
        $produk = $this->produk;
        $item = $this->item;
        $subitem = $this->subitem;
        $cari = $this->request->getVar('search');

        if ($cari) {
            $produk = $produk->search($cari);
        } else {
            $produk = $produk;
        }

        $data = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager
        ];
        return view('halaman/beranda', $data);
    }

    public function produk($id = 0)
    {
        $item = $this->item;
        $produk = $this->produk;
        $produk = $produk->kategori($id);
        $hasilproduk = $produk->findAll();
        $produkada = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'produk' => $produk->paginate(4),
            'pager' => $produk->pager
        ];
        $produktidakada = [
            'judul' => "Beranda | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll()
        ];
        // dd($hasilproduk);
        if (!$hasilproduk) {
            return view('halaman/tidakadaproduk', $produktidakada);
        } else {
            return view('halaman/beranda', $produkada);
        }
    }
    //--------------------------------------------------------------------

}
