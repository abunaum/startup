<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Toko extends BaseController
{
    public function pengajuan()
    {
        $user = new $this->users;
        $user = $user->where('status_toko', 2);
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
        $user = new $this->users;
        $user = $user->where('status_toko', 2);
        $toko = new $this->toko;
        $toko = $toko->where('id', $id);
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
        $user = $user->where('username', $toko->username_user)->get()->getFirstRow();
        if ($user->whatsapp != null) {
            $post_data = 'sender=primary&number=' . $user->whatsapp . '&message=Maaf aktivasi toko anda di tolak karena data yang dikirim tidak valid atau kurang jelas. Silahkan aktivasi ulang%0A' . base_url('toko');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->waapi);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            if (!$result) {
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
        $user = $user->where('username', $toko->username_user)->get()->getFirstRow();

        if ($user->whatsapp != null) {
            $post_data = 'sender=primary&number=' . $user->whatsapp . '&message=Mantap, Toko anda telah di aktivasi, sekarang anda bisa berjualan di ' . base_url();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->waapi);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            if (!$result) {
                session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
                return redirect()->to(base_url('admin/toko/detail/' . $toko->id));
            }
        }
        $usergass = new $this->users;
        $usergass->save([
            'id' => $user->id,
            'status_toko' => 4
        ]);
        session()->setFlashdata('pesan', 'Toko berhasil ACC');
        return redirect()->to(base_url('admin/toko/pengajuan'));
    }
    //--------------------------------------------------------------------

}
