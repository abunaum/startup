<?php

namespace App\Models;

use CodeIgniter\Model;

class TokoModel extends Model
{
    protected $table = 'toko';
    protected $useTimestamps = true;
    protected $allowedFields = ['username_user', 'username', 'nama', 'logo', 'selogan', 'metode', 'nama_rek', 'no_rek', 'kartu', 'selfi', 'status'];
}
