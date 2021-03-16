<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class WaApiLibrary extends BaseController
{
    public $ipwa, $portwa;
    public function __construct()
    {
        $this->ipwa = '3.87.188.80';
        $this->portwa = '8989';
    }
    public function cekkoneksi()
    {
        $cekwa = curl_init($this->ipwa);
        curl_setopt($cekwa, CURLOPT_TIMEOUT, 5);
        curl_setopt($cekwa, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($cekwa, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cekwa, CURLOPT_PORT, $this->portwa);
        curl_exec($cekwa);
        $httpcode = curl_getinfo($cekwa, CURLINFO_HTTP_CODE);
        curl_close($cekwa);
        if ($httpcode >= 200 && $httpcode < 300) {
            $result = 'ready';
        } else {
            $date = date('d F Y h:i:s a');
            $bottele = '1681155458:AAEYgeX1RsRyjEpn3LdFXq095OEduGwDO9k';
            $idtele = '799163200';
            $pesan = "Server Api Whatsapp mati pada $date";
            $API = "https://api.telegram.org/bot" . $bottele . "/sendmessage?chat_id=" . $idtele . "&text=$pesan";
            $tele = curl_init();
            curl_setopt($tele, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($tele, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($tele, CURLOPT_URL, $API);
            curl_exec($tele);
            curl_close($tele);
            $result = 'error';
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
