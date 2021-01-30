<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiSaldoModel extends Model
{
    protected $table = 'transaksi_saldo';
    protected $useTimestamps = true;
    protected $allowedFields = ['owner', 'jenis', 'order_number', 'nominal', 'fee', 'metode', 'status', 'urlpay'];
}
