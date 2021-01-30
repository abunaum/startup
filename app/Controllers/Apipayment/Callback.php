<?php

namespace App\Controllers\Apipayment;

use App\Controllers\BaseController;
use App\Libraries\WaApiLibrary;
use App\Models\TransaksiSaldoModel;

class Callback extends BaseController
{
    public $walib;
    public function __construct()
    {
        $this->walib = new WaApiLibrary;
    }

    public function callback()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('apipayment');
        $builder->where('id', 1);
        $apidb = $builder->get()->getFirstRow();
        $apiprivatekey = $apidb->apiprivatekey;
        // ambil data JSON
        $json = file_get_contents("php://input");

        // ambil callback signature
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

        // generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, $apiprivatekey);
        // validasi signature
        if ($callbackSignature !== $signature) {
            exit("Invalid Signature"); // signature tidak valid, hentikan proses
        }

        $data = json_decode($json);
        $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];

        if ($event == 'payment_status') {
            if ($data->status == 'PAID') {
                $db = \Config\Database::connect();
                $buildertransaksi = $db->table('transaksi_saldo');
                $buildertransaksi->where('order_number', $data->merchant_ref);
                $transaksi = $buildertransaksi->get()->getFirstRow();

                $this->transaksi_saldo->save([
                    'id' => $transaksi->id,
                    'status' => 'lunas'
                ]);
                $owner = $transaksi->owner;
                $builderuser = $db->table('users');
                $builderuser->where('username', $owner);
                $user = $builderuser->get()->getFirstRow();
                $this->users->save([
                    'id' => $user->id,
                    'balance' => $user->balance + $transaksi->nominal
                ]);
                if ($user->wa_hash == 'valid') {
                    $koneksiwa = $this->walib->cekkoneksi();
                    if ($koneksiwa != 'error') {
                        $wa = $user->whatsapp;
                        $pesan = $user->username . ' %0AAnda berhasil isi saldo Rp. ' . number_format($transaksi->nominal) . ' %0ATotal saldo anda sekarang : Rp. ' . number_format($user->balance + $transaksi->nominal);
                        $this->walib->sendwasingle($wa, $pesan);
                    }
                }
            }
        }

        echo json_encode(['success' => true]); // berikan respon yang sesuai

    }

    //--------------------------------------------------------------------

}
