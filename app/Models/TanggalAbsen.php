<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class TanggalAbsen extends Model
{
    protected $table = 'tanggal_absen';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tanggal'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}