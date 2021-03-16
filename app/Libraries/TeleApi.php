<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class TeleApi extends BaseController
{
    public function kirimpesan($chatId, $pesan)
    {
        $token = '1626928610:AAE_LM4EFPn4i1qmyIvEnPewYQyCpqIWLbc';
        $alamat = "https://api.telegram.org/bot$token";
        $url = "$alamat/sendMessage?chat_id=$chatId&text=$pesan&parse_mode=HTML";
        file_get_contents($url);
    }
}
