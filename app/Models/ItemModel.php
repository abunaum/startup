<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'status', 'sub'];
}
