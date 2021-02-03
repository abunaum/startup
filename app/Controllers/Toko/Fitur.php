<?php

namespace App\Controllers\Toko;

use App\Controllers\BaseController;
use App\Libraries\WaApiLibrary;
use App\Libraries\Itemlibrary;

class Fitur extends BaseController
{
    public $walib;
    public function __construct()
    {
        $this->walib = new WaApiLibrary;
        $this->getitem = new Itemlibrary;
    }

    public function index()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $data = [
            'judul' => "Toko | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/toko', $data);
    }

    public function buat_toko()
    {
        if (!$this->validate([
            'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[toko.username]',
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
        $namalogo = $logo->getRandomName();
        $logo->move('img/toko', $namalogo);
        $this->toko->save([
            'userid' => user()->id,
            'username' => url_title($this->request->getVar('username'), '_'),
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
        $tokodb->where('userid', user()->id);
        $tokodb = $tokodb->get()->getFirstRow();
        $kartu = $this->request->getFile('kartu');
        $selfi = $this->request->getFile('selfi');
        $namakartu = $kartu->getRandomName();
        $namaselfi = $selfi->getRandomName();
        $kartu->move(ROOTPATH . 'img/toko/aktivasi', $namakartu);
        $selfi->move(ROOTPATH . 'img/toko/aktivasi', $namaselfi);
        $this->toko->save([
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
