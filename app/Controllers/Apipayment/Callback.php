<?php

namespace App\Controllers\Apipayment;

use App\Controllers\BaseController;
use App\Libraries\PaymentApiLibrary;
use App\Libraries\TeleApiLibrary;
use CodeIgniter\API\ResponseTrait;

class Callback extends BaseController
{
    use ResponseTrait;
    public $telelib;

    public function __construct()
    {
        $this->telelib = new TeleApiLibrary();
        $this->apilib = new PaymentApiLibrary();
    }

    public function callback()
    {
        $api = $this->apipayment->where('id', 1)->first();
        $apiprivatekey = $api['apiprivatekey'];
        $json = file_get_contents('php://input');
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

        $signature = hash_hmac('sha256', $json, $apiprivatekey);
        if ($callbackSignature !== $signature) {
            return $this->setResponseFormat('json')->respond(
                [
                    'error' => true,
                    'pesan' => 'Invalid Signature',
                    'signature' => $signature,
                    'data' => json_decode($json, true)
                ]
            );
        }

        $data = json_decode($json);
        $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];
        $admin = $this->role->admin()->findAll();
        if ($event == 'payment_status') {
            if ($data->status == 'PAID') {

                $merchantRef = $data->merchant_ref;
                if (strpos($merchantRef, 'INV-') !== false) {
                    $invoice = $this->invoice->where('kode', $merchantRef)->where('status !=', 'PAID')->withDeleted()->first();
                    if (!$invoice) {
                        foreach ($admin as $adm) {
                            $id_admin = $adm['user_id'];
                            $db = \Config\Database::connect();
                            $builder = $db->table('users');
                            $builder->where('id', $id_admin);
                            $builder->where('telecode', 'valid');
                            $adm = $builder->get()->getFirstRow();
                            $chatId = $adm->teleid;
                            $pesan = 'Ada yang ngebug nih \nKode : ' . $merchantRef . '\nNominal: ' . $data->amount_received;
                            $this->telelib->kirimpesan($chatId, $pesan);
                        }
                        return redirect()->to(base_url());
                    }
                    $this->invoice->save([
                        'id' => $invoice['id'],
                        'status' => 'PAID'
                    ]);
                    $keranjang = $this->keranjang->where('invoice', $merchantRef)->withDeleted()->findAll();
                    foreach ($keranjang as $kr) {
                        $this->keranjang->save([
                            'id' => $kr['id'],
                            'status' => 2
                        ]);
                        $owner = $kr['buyer'];

                        $produk = $this->produk->where('id', $kr['produk'])->first();
                        $db = \Config\Database::connect();
                        $builder = $db->table('users');
                        $builder->where('id', $owner);
                        $user = $builder->get()->getFirstRow();
                        if ($user->telecode == 'valid') {
                            $chatId = $user->teleid;
                            $pesan = $user->username . '\nTerimakasih \nPembayaran \nInvoice : ' . $merchantRef . ' \nProduk :' . $produk['nama'] . ' \nHarga : ' . number_format($produk['harga']) . '\nJumlah pesanan : ' . $kr['jumlah'] . '\nTelah lunas';
                            $this->telelib->kirimpesan($chatId, $pesan);
                        }
                    }
                } else {
                    $transaksi = $this->transaksi_saldo->where('order_number', $merchantRef);
                    $transaksi = $transaksi->where('status !=', 'PAID')->withDeleted()->first();

                    if (!$transaksi) {
                        foreach ($admin as $adm) {
                            $id_admin = $adm['user_id'];
                            $db = \Config\Database::connect();
                            $builder = $db->table('users');
                            $builder->where('id', $id_admin);
                            $builder->where('telecode', 'valid');
                            $adm = $builder->get()->getFirstRow();
                            $chatId = $adm->teleid;
                            $pesan = 'Ada yang ngebug nih \nKode : ' . $merchantRef . '\nNominal: ' . $data->amount_received;
                            $this->telelib->kirimpesan($chatId, $pesan);
                        }
                        return redirect()->to(base_url());
                    }
                    $this->transaksi_saldo->save([
                        'id' => $transaksi['id'],
                        'status' => $data->status
                    ]);
                    $owner = $transaksi['owner'];
                    $db = \Config\Database::connect();
                    $builder = $db->table('users');
                    $builder->where('id', $owner);
                    $user = $builder->get()->getFirstRow();
                    $this->users->save([
                        'id' => $user['id'],
                        'balance' => $user['balance'] + $transaksi['nominal'],
                    ]);
                    if ($user->telecode == 'valid') {
                        $chatId = $user->teleid;
                        $pesan = $user->username . '\nAnda berhasil isi saldo Rp. ' . number_format($transaksi['nominal']) . '\nTotal saldo anda sekarang : Rp. ' . number_format($user->balance + $transaksi['nominal']);
                        $this->telelib->kirimpesan($chatId, $pesan);
                    }
                }
            } else {
            }
        }
        return $this->setResponseFormat('json')->respond(
            [
                'success' => true,
                'pesan' => 'Pembayaran Sukses',
                'data' => json_decode($json, true)
            ]
        );
    }

    //--------------------------------------------------------------------
}
