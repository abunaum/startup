<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\WaApiLibrary;

class notifikasi extends BaseController
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
        $toko = $this->toko;
        $cari = $this->request->getVar('search');

        if ($cari) {
            $produk = $produk->search($cari);
        } else {
            $produk = $produk;
        }
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'judul' => "Notifikasi | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->findAll(),
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        if ($user->whatsapp == null) {
            return view('halaman/user/notifikasi_belum', $data);
        } else if ($user->wa_hash != 'valid') {
            $data['wa'] = $user->whatsapp;
            return view('halaman/user/notifikasi_verif', $data);
        } else {
            return view('halaman/user/notifikasi_sudah', $data);
        }
    }

    public function pasangwa()
    {
        if (!$this->validate([
            'wa' => 'required|min_length[10]|max_length[13]'
        ])) {
            session()->setFlashdata('error', 'Gagal menambah nomor whatsapp, Coba lagi.');
            return redirect()->to(base_url('user/notifikasi'))->withInput();
        }

        $nowa = '0' . $this->request->getVar('wa');
        $rand = substr(md5(openssl_random_pseudo_bytes(20)), -32);
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $wa = $nowa;
            $pesan = 'kode anda adalah : ' . $rand;
            $this->walib->sendwasingle($wa, $pesan);
        } else {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('user/notifikasi'));
        }
        $this->users->save([
            'id' => user()->id,
            'whatsapp' => $nowa,
            'wa_hash' => $rand
        ]);
        session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Whatsapp.');
        return redirect()->to(base_url('user/notifikasi'));
    }

    public function waulang()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $wa = $user->whatsapp;
            $pesan = 'kode anda adalah : ' . $user->wa_hash;
            $this->walib->sendwasingle($wa, $pesan);
        } else {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('user/notifikasi'));
        }
        session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Whatsapp.');
        return redirect()->to(base_url('user/notifikasi'));
    }

    public function ubahwa()
    {
        if (!$this->validate([
            'wa' => 'required|min_length[10]|max_length[13]'
        ])) {
            session()->setFlashdata('error', 'Gagal ubah nomor whatsapp, Coba lagi.');
            return redirect()->to(base_url('user/notifikasi'))->withInput();
        }

        $nowa = '0' . $this->request->getVar('wa');
        $rand = substr(md5(openssl_random_pseudo_bytes(20)), -32);
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $wa = $nowa;
            $pesan = 'kode anda adalah : ' . $rand;
            $this->walib->sendwasingle($wa, $pesan);
        } else {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('user/notifikasi'));
        }
        $this->users->save([
            'id' => user()->id,
            'whatsapp' => $nowa,
            'wa_hash' => $rand
        ]);
        session()->setFlashdata('pesan', 'Nomor Whatsapp berhasil di ubah dan Kode berhasil di kirim.');
        return redirect()->to(base_url('user/notifikasi'));
    }

    public function verifwa()
    {
        $kode = $this->request->getVar('kode');
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $kodeuser = $user->wa_hash;
        if ($kode != $kodeuser) {
            session()->setFlashdata('error', 'Kode yang anda masukkan tidak sesuai.');
            return redirect()->to(base_url('user/notifikasi'));
        } else {
            $this->users->save([
                'id' => user()->id,
                'wa_hash' => 'valid'
            ]);
            session()->setFlashdata('pesan', 'Notifikasi Whatsapp sudah aktif.');
            return redirect()->to(base_url('user/notifikasi'));
        }
    }
    //--------------------------------------------------------------------

}
