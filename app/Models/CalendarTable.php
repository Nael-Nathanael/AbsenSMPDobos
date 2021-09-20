<?php

namespace App\Models;

use CodeIgniter\Model;

class CalendarTable extends Model
{
    protected $table = 'calendar_table';

    protected $returnType = 'array';

    protected $allowedFields = ['date'];
}