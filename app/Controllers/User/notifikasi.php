<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\TeleApiLibrary;
use App\Libraries\Itemlibrary;

class notifikasi extends BaseController
{
    public $telelib;
    public function __construct()
    {
        $this->telelib = new TeleApiLibrary;
        $this->getitem = new Itemlibrary;
    }

    public function index()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'judul' => "Notifikasi | $this->namaweb",
            'item' => $item,
            'toko' => $toko,
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        if ($user->teleid == '') {
            return view('halaman/user/notifikasi_belum', $data);
        } else if ($user->telecode != 'valid') {
            $data['tele'] = $user->teleid;
            return view('halaman/user/notifikasi_verif', $data);
        } else {
            return view('halaman/user/notifikasi_sudah', $data);
        }
    }

    public function pasangtele()
    {
        if (!$this->validate([
            'teleid' => 'required|is_natural_no_zero',
        ])) {
            session()->setFlashdata('error', 'Gagal memverifikasi telegram, Coba lagi.');
            return redirect()->to(base_url('user/notifikasi'))->withInput();
        }

        $chatid = $this->request->getVar('teleid');
        $karakter = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($karakter), 0, 8);
        $pesan = "Kode anda adalah : $code";
        $this->telelib->kirimpesan($chatid, $pesan);
        $this->users->save([
            'id' => user()->id,
            'teleid' => $chatid,
            'telecode' => $code
        ]);
        session()->setFlashdata('pesan', 'Kode OTP berhasil dikirim ke Telegram.');
        return redirect()->to(base_url('user/notifikasi'));
    }

    public function teleulang()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $chatid = $user->teleid;
        $code = $user->telecode;
        $pesan = "Kode anda adalah : $code";
        $this->telelib->kirimpesan($chatid, $pesan);
        session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Telegram.');
        return redirect()->to(base_url('user/notifikasi'));
    }

    public function ubahtele()
    {
        if (!$this->validate([
            'teleid' => 'required|is_natural_no_zero',
        ])) {
            session()->setFlashdata('error', 'Gagal memverifikasi telegram, Coba lagi.');
            return redirect()->to(base_url('user/notifikasi'))->withInput();
        }

        $chatid = $this->request->getVar('teleid');
        $karakter = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($karakter), 0, 8);
        $pesan = "Kode anda adalah : $code";
        $this->telelib->kirimpesan($chatid, $pesan);
        $this->users->save([
            'id' => user()->id,
            'teleid' => $chatid,
            'telecode' => $code
        ]);
        session()->setFlashdata('pesan', 'ID berhasil di ubah dankode OTP berhasil dikirim ke Telegram.');
        return redirect()->to(base_url('user/notifikasi'));
    }

    public function veriftele()
    {
        $kode = $this->request->getVar('kode');
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $kodeuser = $user->telecode;
        if ($kode != $kodeuser) {
            session()->setFlashdata('error', 'Kode yang anda masukkan tidak sesuai.');
            return redirect()->to(base_url('user/notifikasi'));
        } else {
            $this->users->save([
                'id' => user()->id,
                'telecode' => 'valid'
            ]);
            session()->setFlashdata('pesan', 'Notifikasi Telegram sudah aktif.');
            return redirect()->to(base_url('user/notifikasi'));
        }
    }
    //--------------------------------------------------------------------

}
