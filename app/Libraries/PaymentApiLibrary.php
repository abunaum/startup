<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class PaymentApiLibrary extends BaseController
{
    public $apilib;
    public function __construct()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('apipayment');
        $builder->where('id', 1);
        $apidb = $builder->get()->getFirstRow();
        $this->apikey = $apidb->apikey;
        $this->apiprivatekey = $apidb->apiprivatekey;
        $this->kodemerchant = $apidb->kodemerchant;
        $this->urlcreatepayment = $apidb->urlcreatepayment;
        $this->urlpaymentchannel = $apidb->urlpaymentchannel;
        $this->urlfeekalkulator = $apidb->urlfeekalkulator;

        $this->callback = 'http://d034a914c3d2.ngrok.io' . $apidb->callback;
    }
    public function getmerchant()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlpaymentchannel,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $datapembayaran = $data['data'];
        curl_close($curl);
        return $datapembayaran;
    }
    public function paymentkalkulator($channel, $saldo)
    {
        $payload = [
            'code'    => $channel,
            'amount'    => $saldo
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlfeekalkulator . http_build_query($payload),
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);

        curl_close($curl);
        return $data['data'][0]['total_fee'];
    }

    public function geturlpaytopup($id)
    {
        $db = \Config\Database::connect();
        $buildertransaksi = $db->table('transaksi_saldo');
        $buildertransaksi->where('id', $id);
        $transaksi = $buildertransaksi->get()->getFirstRow();
        $amount = $transaksi->fee + $transaksi->nominal;

        $builderuser = $db->table('users');
        $builderuser->where('id', user()->id);
        $user = $builderuser->get()->getFirstRow();

        if ($user->wa_hash != 'vaid') {
            $wa = null;
        } else {
            $wa = $user->whatsapp;
        }

        $data = [
            'method'            => $transaksi->metode,
            'merchant_ref'      => $transaksi->order_number,
            'amount'            => $amount,
            'customer_name'     => user()->username,
            'customer_email'    => user()->email,
            'customer_phone'    => $wa,
            'order_items'       => [
                [
                    'sku'       => 'Topup',
                    'name'      => $transaksi->jenis,
                    'price'     => $amount,
                    'quantity'  => 1
                ]
            ],
            'callback_url'      => $this->callback,
            'return_url'        => base_url('user/saldo/topup'),
            'expired_time'      => (time() + (24 * 60 * 60)), // 24 jam
            'signature'         => hash_hmac('sha256', $this->kodemerchant . $transaksi->order_number . $amount, $this->apiprivatekey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => $this->urlcreatepayment,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer " . $this->apikey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response, true);
        $urlpay = $data['data']['checkout_url'];
        return $urlpay;
    }
}
