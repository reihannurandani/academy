<?php

namespace App\Models;

use CodeIgniter\Model;

class LogActivityModel extends Model
{
    protected $table = 'log_activity';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_user',
        'activity'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    protected $updatedField  = '';
}
