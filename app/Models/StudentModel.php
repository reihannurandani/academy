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
        'alamat'
    ];

    protected $useTimestamps = false;
}
