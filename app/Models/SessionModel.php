<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{
    protected $table      = 'session';
    protected $primaryKey = 'product_id';
    protected $allowedFields = [
        'product_id',
        'productname',
        'productprice',
        'productcode',
        'productquantity'
    ];

    protected $validationRules    = [
        'productcode'     => 'is_unique[session.productcode]',
    ];

    protected $validationMessages = [
        'productcode'        => [
            'is_unique' => 'Sorry. That productcode has already been taken. Please choose another.',
        ],
    ];
}
