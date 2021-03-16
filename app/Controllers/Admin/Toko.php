<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\WaApiLibrary;

class Toko extends BaseController
{
    public $walib;
    public function __construct()
    {
        $this->walib = new WaApiLibrary;
    }

    public function pengajuan()
    {
        $user = new $this->users;
        $user->join('toko', 'toko.userid = users.id', 'LEFT');
        $user->where('status_toko', 2);
        $user->select('users.*');
        $user->select('toko.username as usernametoko');
        $user->select('toko.id as idtoko');
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin Toko | $this->namaweb",
            'user' => $user->paginate(10),
            'pager' => $user->pager,
        ];
        return view('admin/pengajuan_toko', $data);
    }

    public function pengajuandetail($id)
    {
        $toko = new $this->toko;
        $toko->join('users', 'users.id = toko.userid', 'LEFT');
        $toko->select('toko.*');
        $toko->select('users.wa_hash');
        $toko->select('users.whatsapp');
        $toko->select('users.username as username_user');
        $toko->where('status_toko', 2);
        $toko->where('toko.id', $id);

        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin Toko | $this->namaweb",
            'toko' => $toko->get()->getFirstRow()
        ];
        return view('admin/detail_pengajuan_toko', $data);
    }

    public function pengajuantolak($id)
    {
        $toko = new $this->toko;
        $toko = $toko->where('id', $id)->get()->getFirstRow();
        $user = new $this->users;
        $user = $user->where('id', $toko->userid)->get()->getFirstRow();
        if ($user->wa_hash == 'valid') {
            $koneksiwa = $this->walib->cekkoneksi();
            if ($koneksiwa != 'error') {
                $wa = $user->whatsapp;
                $pesan = $user->username . ' %0AMaaf aktivasi toko anda di tolak karena data yang dikirim tidak valid atau kurang jelas. Silahkan aktivasi ulang%0A' . base_url('toko');
                $this->walib->sendwasingle($wa, $pesan);
            } else {
                session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
                return redirect()->to(base_url('admin/toko/detail/' . $toko->id));
            }
        }

        $usergass = new $this->users;
        $usergass->save([
            'id' => $user->id,
            'status_toko' => 3
        ]);
        @unlink(ROOTPATH . 'img/toko/aktivasi/' . $toko->kartu);
        @unlink(ROOTPATH . 'img/toko/aktivasi/' . $toko->selfi);
        $tokogass = new $this->toko;
        $tokogass->save([
            'id' => $toko->id,
            'nama_rek' => '',
            'no_rek' => '',
            'kartu' => '',
            'selfi' => '',

        ]);
        session()->setFlashdata('pesan', 'Toko berhasil ditolak');
        return redirect()->to(base_url('admin/toko/pengajuan'));
    }

    public function pengajuanacc($id)
    {
        $toko = new $this->toko;
        $toko = $toko->where('id', $id)->get()->getFirstRow();
        $user = new $this->users;
        $user = $user->where('id', $toko->userid)->get()->getFirstRow();

        if ($user->wa_hash == 'valid') {
            $koneksiwa = $this->walib->cekkoneksi();
            if ($koneksiwa != 'error') {
                $wa = $user->whatsapp;
                $pesan = $user->whatsapp . ' %0AMantap, Toko anda telah di aktivasi, sekarang anda bisa berjualan di ' . base_url();
                $this->walib->sendwasingle($wa, $pesan);
                session()->setFlashdata('pesan', 'Toko berhasil ACC');
            } else {
                session()->setFlashdata('error', 'Toko berhasil ACC, Namun Server Whatsapp bermasalah.');
            }
        }
        $usergass = new $this->users;
        $usergass->save([
            'id' => $user->id,
            'status_toko' => 4
        ]);
        return redirect()->to(base_url('admin/toko/pengajuan'));
    }
    //--------------------------------------------------------------------

}
