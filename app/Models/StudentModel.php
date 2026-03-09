<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_siswa',
        'no_hp',
        'alamat',
        'id_kursus',
        'id_kategori',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;
}