<?php

namespace App\Controllers\Apipayment;

use App\Controllers\BaseController;
use App\Libraries\PaymentApiLibrary;
use App\Libraries\WaApiLibrary;
use CodeIgniter\API\ResponseTrait;

class Callback extends BaseController
{
    use ResponseTrait;
    public $walib;

    public function __construct()
    {
        $this->walib = new WaApiLibrary();
        $this->apilib = new PaymentApiLibrary();
    }

    public function callback()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('apipayment');
        $builder->where('id', 1);
        $apidb = $builder->get()->getFirstRow();
        $apiprivatekey = $apidb->apiprivatekey;
        // ambil data JSON
        $json = file_get_contents('php://input');

        // ambil callback signature
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

        // generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, $apiprivatekey);
        // validasi signature
        if ($callbackSignature !== $signature) {
            exit('Invalid Signature'); // signature tidak valid, hentikan proses
        }

        $data = json_decode($json);
        $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];

        if ($event == 'payment_status') {
            if ($data->status == 'PAID') {
                $db = \Config\Database::connect();
                $buildertransaksi = $db->table('transaksi_saldo');
                $buildertransaksi->where('order_number', $data->merchant_ref);
                $buildertransaksi->where('status', 'pending');
                $transaksi = $buildertransaksi->get()->getFirstRow();

                if (!$transaksi) {
                    return redirect()->to(base_url());
                }

                $this->transaksi_saldo->save([
                    'id' => $transaksi->id,
                    'status' => $data->status
                ]);
                $owner = $transaksi->owner;
                $builderuser = $db->table('users');
                $builderuser->where('username', $owner);
                $user = $builderuser->get()->getFirstRow();
                $this->users->save([
                    'id' => $user->id,
                    'balance' => $user->balance + $transaksi->nominal,
                ]);
                if ($user->telecode == 'valid') {
                    $chatId = $user->teleid;
                    $pesan = $user->username . '\nAnda berhasil isi saldo Rp. ' . number_format($transaksi->nominal) . '\nTotal saldo anda sekarang : Rp. ' . number_format($user->balance + $transaksi->nominal);
                    $this->telelib->kirimpesan($chatId, $pesan);
                }
            }
        }
        echo json_encode(['success' => true]); // berikan respon yang sesuai
    }

    public function cekpay($referensi)
    {
        $db = \Config\Database::connect();
        $buildertransaksi = $db->table('transaksi_saldo');
        $buildertransaksi->where('reference', $referensi);
        $transaksi = $buildertransaksi->get()->getFirstRow();
        $data = $transaksi;

        return $this->respond($data);
    }

    //--------------------------------------------------------------------
}
