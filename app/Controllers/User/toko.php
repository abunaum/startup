<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class toko extends BaseController
{
    use ResponseTrait;
    public function produk()
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
        $produkuser = $this->produk->where('owner', user()->id);
        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->get()->getFirstRow(),
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'produk' => $produkuser->paginate(6),
            'pager' => $produkuser->pager
        ];
        if ($user->status_toko == 5) {
            return view('Toko/banned', $data);
        } else {
            return view('Toko/fitur/produk', $data);
        }
    }
    public function tambah()
    {
        $produk = $this->produk;
        $item = $this->item;
        $subitem = $this->subitem;
        $toko = $this->toko;
        $cari = $this->request->getVar('search');

        if ($cari) {
            $produk = $produk->search($cari);
        } else {
            $produk = $produk;
        }
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'type' => 'tambahproduk',
            'judul' => "Tambah Produk | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'subitem' => $subitem->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->get()->getFirstRow(),
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        if ($user->status_toko == 5) {
            return view('Toko/banned', $data);
        } else {
            return view('Toko/fitur/tambah', $data);
        }
    }
    public function tambahproduk()
    {
        $subitem = $this->request->getVar('sub');
        $nama = $this->request->getVar('nama');
        $harga = (int)$this->request->getVar('harga');
        $deskripsi = $this->request->getVar('deskripsi');
        $stok = $this->request->getVar('stok');

        if ($harga < 10000) {
            session()->setFlashdata('error', 'Gagal menambah produk, Harga kurang dari 10000');
            return redirect()->to(base_url('user/toko/tambah'))->withInput();
        }

        $toko = $this->toko->where('username_user', user()->username)->get()->getFirstRow();
        $slug = url_title($toko->username . ' ' . $nama);

        if (!$this->validate([
            'item' => 'required',
            'sub' => 'required',
            'nama' => 'required',
            'harga' => 'required|min_length[5]',
            'deskripsi' => 'required',
            'stok' => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar produk masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('error', 'Gagal menambah produk');
            return redirect()->to(base_url('user/toko/tambah'))->withInput();
        }
        $gambar = $this->request->getFile('gambar');
        // pindah lokasi gambar
        $gambar->move('img/produk');
        $namagambar = $gambar->getName();
        $produk = $this->produk;
        $produk->save([
            'jenis' => $subitem,
            'owner' => user()->id,
            'gambar' => $namagambar,
            'nama' => $nama,
            'harga' => $harga,
            'keterangan' => $deskripsi,
            'slug' => $slug,
            'stok' => $stok
        ]);

        if (is_resource(@fsockopen($this->ipwa, $this->portwa))) {
            fclose(@fsockopen($this->ipwa, $this->portwa));
            $admin = $this->role->admin()->findAll();
            foreach ($admin as $admin) {
                $id_admin = $admin['user_id'];
                $db = \Config\Database::connect();
                $builder = $db->table('users');
                $builder->where('id', $id_admin);
                $builder->where('wa_hash', 'valid');
                $adm = $builder->get()->getFirstRow();
                $wa = $adm->whatsapp;
                $post_data = 'sender=primary&number=' . $wa . '&message=username : ' . user()->username . ' %0AToko : ' . $toko->username . ' %0Amenambah produk :' . $nama . ' %0Aharga : ' . $harga;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->waapi);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
            }
        }

        session()->setFlashdata('pesan', 'Produk berhasil di tambah');
        return redirect()->to(base_url('user/toko/produk'));
    }
    public function cariitem($id)
    {
        $item = $id;
        $carisub = $this->subitem->where('item', $item);
        return $this->respond($carisub->findAll());
    }
    public function produkdetail($id)
    {
        $produk = $this->produk;
        $item = $this->item;
        $toko = $this->toko->where('username_user', user()->username)->get()->getFirstRow();
        $cari = $this->request->getVar('search');
        $idproduk = $id;

        if ($cari) {
            $produk = $produk->search($cari);
        } else {
            $produk = $produk;
        }
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $produkuser = $this->produk->where('owner', user()->id);
        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko,
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'produk' => $produkuser->paginate(6),
            'pager' => $produkuser->pager
        ];
        if ($toko == null) {
            return redirect()->to(base_url('toko'));
        } else if ($toko->username_user != user()->username) {
            return redirect()->to(base_url('toko'));
        } else if ($user->status_toko == 5) {
            return view('Toko/banned', $data);
        } else {
            echo phpinfo();
        }
    }
}
