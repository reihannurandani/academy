<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table = 'transaction_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_transaksi',
        'id_produk',
        'harga',
        'qty',
        'subtotal'
    ];

    protected $useTimestamps = false;

    public function getDetailWithProduct($id_transaksi)
    {
        return $this->select('transaction_details.*, products.nama_produk')
                    ->join('products', 'products.id = transaction_details.id_produk')
                    ->where('id_transaksi', $id_transaksi)
                    ->findAll();
    }
}
