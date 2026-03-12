<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'invoice',
        'id_user',
        'id_siswa',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'total_harga',
        'uang_bayar',
        'uang_kembali',
        'metode_pembayaran',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    public function getTransactionsWithUser()
    {
        return $this->select('transactions.*, users.nama')
                    ->join('users', 'users.id = transactions.id_user')
                    ->findAll();
    }

    public function filterByDate($start, $end)
    {
        return $this->where('created_at >=', $start)
                    ->where('created_at <=', $end)
                    ->findAll();
    }
}