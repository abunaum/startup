<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $useTimestamps = true;
    protected $allowedFields = ['jenis', 'nama', 'owner', 'gambar', 'harga', 'keterangan', 'slug', 'stok'];

    public function search($cari)
    {
        $produk = $this->table('produk');
        $produk->where('stok >=', 1);
        $produk->like('slug', $cari);
        return $produk;
    }

    public function kategori($id)
    {
        $produk = $this->table('produk');
        $produk->where('stok >=', 1);
        $produk->where('jenis', $id);
        return $produk;
    }
}
