<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class notifikasi extends BaseController
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
        $post_data = 'sender=primary&number=' . $nowa . '&message=kode anda adalah : ' . $rand;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->waapi);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (!$result) {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('user/notifikasi'));
        } else {
            $this->users->save([
                'id' => user()->id,
                'whatsapp' => $nowa,
                'wa_hash' => $rand
            ]);
            session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Whatsapp.');
            return redirect()->to(base_url('user/notifikasi'));
        }
    }

    public function waulang()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $post_data = 'sender=primary&number=' . $user->whatsapp . '&message=kode anda adalah : ' . $user->wa_hash;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->waapi);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (!$result) {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('user/notifikasi'));
        } else {
            session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Whatsapp.');
            return redirect()->to(base_url('user/notifikasi'));
        }
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
        $post_data = 'sender=primary&number=' . $nowa . '&message=kode anda adalah : ' . $rand;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->waapi);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (!$result) {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('user/notifikasi'));
        } else {
            $this->users->save([
                'id' => user()->id,
                'whatsapp' => $nowa,
                'wa_hash' => $rand
            ]);
            session()->setFlashdata('pesan', 'Nomor Whatsapp berhasil di ubah dan Kode berhasil di kirim.');
            return redirect()->to(base_url('user/notifikasi'));
        }
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
