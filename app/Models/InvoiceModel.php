<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table      = 'invoice';
    protected $primaryKey = 'invoice_id';
    protected $allowedFields = [
        'invoice_customerName',
        'invoice_customerPhone',
        'invoice_customerAddress',
        'invoice_total',
    ];

    public function get_all_data()
    {
        $builder = $this->db->table('invoice');
            $this->table = 'invoice';
            $this->primaryKey = 'invoice_id';
            $this->allowedFields = [ 
                'invoice_customerName',
                'invoice_customerPhone', 
                'invoice_customerAddress',
                'invoice_total',];
            $this->column_order = array(
                'invoice_customerName',
                'invoice_customerPhone', 
                'invoice_customerAddress', 
                'invoice_total');
            $this->order = array('product_id' => 'desc'); //asc //desc

            $builder->select('*');

            $builder->join('product_inout', 'product_inout.invoice_id = invoice.invoice_id', "left"); // added left join here

            $builder->limit($_POST["length"], $_POST["start"]);
            $query=$builder->get()->getResult();
    }
}
