<?php

namespace App\Controllers\Toko;

use App\Controllers\BaseController;
use App\Libraries\WaApiLibrary;

class Fitur extends BaseController
{
    public $walib;
    public function __construct()
    {
        $this->walib = new WaApiLibrary;
    }

    public function index()
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

        $data = [
            'judul' => "Toko | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/toko', $data);
    }

    public function buat_toko()
    {
        if (!$this->validate([
            'username' => 'required|alpha_numeric_punct|min_length[3]|is_unique[toko.username]',
            'selogan' => 'required',
            'metode' => 'required',
            'logo' => [
                'rules' => 'uploaded[logo]|max_size[logo,1024]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar toko masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('error', 'Gagal membuat toko , Coba lagi');
            return redirect()->to(base_url('toko'))->withInput();
        }
        $logo = $this->request->getFile('logo');
        // pindah lokasi logo
        $logo->move('img/toko');
        $namalogo = $logo->getName();
        $toko = $this->toko;
        $toko->save([
            'username_user' => user()->username,
            'username' => $this->request->getVar('username'),
            'logo' => $namalogo,
            'selogan' => $this->request->getVar('selogan'),
            'metode' => $this->request->getVar('metode')
        ]);

        $this->users->save([
            'id' => user()->id,
            'status_toko' => 1
        ]);

        session()->setFlashdata('pesan', 'Toko berhasil di buat');
        return redirect()->to(base_url('toko'));
    }

    public function aktivasi()
    {
        if (!$this->validate([
            'nama' => 'required|alpha_space|min_length[3]',
            'rekening' => 'required|numeric|min_length[4]|max_length[16]',
            'kartu' => [
                'rules' => 'uploaded[kartu]|max_size[kartu,1024]|is_image[kartu]|mime_in[kartu,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto KTP / Kartu Pelajar masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ],
            'selfi' => [
                'rules' => 'uploaded[selfi]|max_size[selfi,1024]|is_image[selfi]|mime_in[selfi,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto selfi bersama kartu masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('error', 'Gagal aktivasi toko , Coba lagi');
            return redirect()->to(base_url('toko'))->withInput();
        }
        $db = \Config\Database::connect();
        $tokodb = $db->table('toko');
        $tokodb->where('username_user', user()->username);
        $tokodb = $tokodb->get()->getFirstRow();
        $kartu = $this->request->getFile('kartu');
        $selfi = $this->request->getFile('selfi');
        $kartu->move(ROOTPATH . 'img/toko/aktivasi');
        $selfi->move(ROOTPATH . 'img/toko/aktivasi');
        $namakartu = $kartu->getName();
        $namaselfi = $selfi->getName();
        $toko = $this->toko;
        $toko->save([
            'id' => $tokodb->id,
            'nama_rek' => $this->request->getVar('nama'),
            'no_rek' => $this->request->getVar('rekening'),
            'kartu' => $namakartu,
            'selfi' => $namaselfi
        ]);

        $this->users->save([
            'id' => user()->id,
            'status_toko' => 2
        ]);
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $admin = $this->role->admin()->findAll();
            foreach ($admin as $admin) {
                $id_admin = $admin['user_id'];
                $db = \Config\Database::connect();
                $builder = $db->table('users');
                $builder->where('id', $id_admin);
                $builder->where('wa_hash', 'valid');
                $adm = $builder->get()->getFirstRow();
                $wa = $adm->whatsapp;
                $pesan = $wa . '&message=username : ' . user()->username . '%0A Toko : ' . $tokodb->username . '%0A mengajukan aktivasi toko';
                $this->walib->sendwasingle($wa, $pesan);
            }
        }
        session()->setFlashdata('pesan', 'Toko berhasil meminta aktivasi');
        return redirect()->to(base_url('toko'));
    }

    //--------------------------------------------------------------------

}
