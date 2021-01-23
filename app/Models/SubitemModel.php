<?php

namespace App\Models;

use CodeIgniter\Model;

class SubitemModel extends Model
{
    protected $table = 'sub_item';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'status', 'item'];
}
