<?php

namespace App\Controllers\Penjual;

use App\Controllers\BaseController;

class Toko extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => "Toko | $this->namaweb"
        ];
        return view('penjual/index', $data);
    }

    //--------------------------------------------------------------------

}
