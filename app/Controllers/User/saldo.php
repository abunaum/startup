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
        $minimal = 10000;
        if ($saldo < $minimal) {
            session()->setFlashdata('error', 'Gagal menambah saldo, Nominal isi saldo ' . $channel . ' Adalah Rp. ' . number_format($minimal));
            return redirect()->to(base_url('user/saldo'))->withInput();
        }
        $fee = $this->apilib->paymentkalkulator($channel, $saldo);
        $totalfee =  $fee['merchant'] + $fee['customer'];
        $rand = rand(111111, 999999);
        $tgl = date('Ymdhis');
        $order_number = "top-$tgl$rand";
        $nama = 'Topup';
        $totalbayar = $saldo + $totalfee;
        $createpayment = $this->apilib->createpayment($nama, $order_number, $channel, $totalbayar);
        $payment = json_decode($createpayment, true);
        if ($payment['success'] == 1) {
            $this->transaksi_saldo->save([
                'owner' => user()->username,
                'jenis' => 'Topup',
                'order_number' => $order_number,
                'nominal' => $saldo,
                'fee' => $totalfee,
                'metode' => $channel,
                'status' => 'pending',
                'reference' => $payment['data']['reference']
            ]);
            session()->setFlashdata('pesan', 'Mantap, Isi saldo anda telah siap, silahkan selesaikan pembayaran anda');
            return redirect()->to(base_url('user/saldo/topup'));
        } else {
            session()->setFlashdata('error', 'Ooops, Server Error !!');
            return redirect()->to(base_url('user/saldo'));
        }
    }

    public function topup()
    {
        $item = $this->item;
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $transaksi = $this->transaksi_saldo->where('status', 'pending');
        $transaksi = $transaksi->where('owner', user()->username)->findAll();
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
        if (!$trx) {
            return redirect()->to(base_url('user/saldo'));
        }
        $role = $this->role->where('user_id', user()->id)->get()->getFirstRow();
        if ($role->group_id != 1) {
            if ($trx->owner != user()->username) {
                return redirect()->to(base_url('user/saldo'));
            }
        }
        $referensi = $trx->reference;
        $detailpayment = $this->apilib->detailtransaksi($referensi);
        $detailpayment = json_decode($detailpayment, true);
        if ($detailpayment['data']['status'] == 'PAID') {
            session()->setFlashdata('pesan', 'Mantap, Isi saldo berhasil');
            return redirect()->to(base_url('user/saldo/topup'));
        }
        if ($detailpayment['success'] == 1) {
            $data = [
                'judul' => "Transaksi | $this->namaweb",
                'transaksi' => $detailpayment['data']
            ];
            // echo '<pre>' . print_r($detailpayment['data'], true) . '</pre>';
            return view('halaman/user/pay', $data);
        }
    }
    public function transaksihapus($id = 0)
    {
        $this->transaksi_saldo->delete($id);
        session()->setFlashdata('pesan', 'Transaksi Berhasil di hapus');
        return redirect()->to(base_url('user/saldo/topup'));
    }
    //--------------------------------------------------------------------

}
