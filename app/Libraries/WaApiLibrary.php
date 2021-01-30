<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class WaApiLibrary extends BaseController
{
    public $ipwa, $portwa;
    public function __construct()
    {
        $this->ipwa = '34.237.136.254';
        $this->portwa = '8000';
    }
    public function cekkoneksi()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, $this->ipwa);
        curl_setopt($ch, CURLOPT_PORT, $this->portwa);
        $hasil = curl_exec($ch);
        curl_close($ch);
        if (!$hasil) {
            $date = date('d F Y h:i:s a');
            $bottele = '1681155458:AAEYgeX1RsRyjEpn3LdFXq095OEduGwDO9k';
            $idtele = '799163200';
            $pesan = "Server Api Whatsapp mati pada $date";
            $API = "https://api.telegram.org/bot" . $bottele . "/sendmessage?chat_id=" . $idtele . "&text=$pesan";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_URL, $API);
            curl_exec($ch);
            curl_close($ch);
            $result = 'error';
        } else {
            $result = 'ready';
        }
        return $result;
    }
    public function sendwasingle($wa, $pesan)
    {
        $this->waapi = 'http://' . $this->ipwa . ':' . $this->portwa . '/send-message';
        $post_data = 'sender=primary&number=' . $wa . '&message=' . $pesan;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->waapi);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
