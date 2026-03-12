<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_kategori',
        'nama_produk',
        'harga_produk',
        'jam_kursus',
        'kuota',
        'status',
        'mentor'        
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.nama_kategori')
                    ->join('categories', 'categories.id = products.id_kategori', 'left')
                    ->findAll();
    }
}
