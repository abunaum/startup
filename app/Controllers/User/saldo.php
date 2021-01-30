<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\PaymentApiLibrary;

class saldo extends BaseController
{
    public $apilib;
    public function __construct()
    {
        $this->apilib = new PaymentApiLibrary();
    }
    public function index()
    {
        $item = $this->item;
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'judul' => "Saldo | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->findAll(),
            'user' => $user,
            'paymentapi' => $this->apilib,
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/saldo', $data);
    }
    public function tambah()
    {
        $saldo = (int)$this->request->getVar('saldo');
        $channel = $this->request->getVar('channel');
        if (!$this->validate([
            'saldo' => 'required'
        ])) {
            session()->setFlashdata('error', 'Gagal menambah saldo, Coba lagi.');
            return redirect()->to(base_url('user/saldo'))->withInput();
        }
        if ($saldo < 10000) {
            session()->setFlashdata('error', 'Gagal menambah saldo, Nominal isi saldo kurang dari Rp. 10000');
            return redirect()->to(base_url('user/saldo'))->withInput();
        }
        $fee = $this->apilib->paymentkalkulator($channel, $saldo);
        $totalfee =  $fee['merchant'] + $fee['customer'];
        $rand = rand(111111, 999999);
        $tgl = date('Ymdhis');
        $ordern = "top-$tgl$rand";

        $this->transaksi_saldo->save([
            'owner' => user()->username,
            'jenis' => 'Topup',
            'order_number' => $ordern,
            'nominal' => $saldo,
            'fee' => $totalfee,
            'metode' => $channel,
            'status' => 'pending'
        ]);
        session()->setFlashdata('pesan', 'Mantap, Isi saldo anda telah siap, silahkan selesaikan pembayaran anda');
        return redirect()->to(base_url('user/saldo/topup'));
    }

    public function topup()
    {
        $item = $this->item;
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $transaksi = $this->transaksi_saldo->where('status', 'pending');
        $transaksi = $transaksi->where('owner', user()->username)->get()->getFirstRow();
        if (!$transaksi) {
            return redirect()->to(base_url('user/saldo'));
        }
        $data = [
            'judul' => "Saldo | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->findAll(),
            'user' => $user,
            'transaksi' => $transaksi,
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/saldotopup', $data);
    }
    public function topupproses($id = 0)
    {
        $trx = $this->transaksi_saldo->where('id', $id)->get()->getFirstRow();
        if ($trx->urlpay != '') {
            $urlpay = $trx->urlpay;
        } else {
            $urlpay = $this->apilib->geturlpaytopup($id);
            $this->transaksi_saldo->save([
                'id' => $id,
                'urlpay' => $urlpay
            ]);
        }
        return redirect()->to($urlpay);
    }
    //--------------------------------------------------------------------

}
