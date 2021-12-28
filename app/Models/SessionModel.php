<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{
    protected $table      = 'session';
    protected $primaryKey = 'product_id';
    protected $allowedFields = [
        'productname', 
        'productprice',
        'productcode'
    ];
}
