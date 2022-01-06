<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_InOut_Model extends Model
{
    protected $table      = 'product_inout';
    protected $primaryKey = 'product_inout_id';
    protected $allowedFields = [
        'product_id',
        'invoice_id',
        'product_inout_price',
        'product_inout_date',
        'product_inout_quantity_in',
        'product_finalprice',
    ];

    public function get_all_data()
    {
        $builder = $this->db->table('product_inout');
            $this->table = 'product_inout';
            $this->primaryKey = 'product_inout_id';
            $this->allowedFields = [ 
                'product_id',
                'invoice_id',
                'product_inout_price', 
                'product_inout_date',
                'product_inout_quantity_in',
                'product_finalprice'
            ];
            $this->column_order = array(
                'sl',
                'product_id',
                'invoice_id',
                'product_inout_price', 
                'product_inout_date',
                'product_inout_quantity_in',
                'product_inout_quantity_out'
            );
            $this->order = array('product_id' => 'desc'); //asc //desc

            $builder->select('*');

            $builder->join('session', 'session.product_id = product_inout.product_id', "left"); // added left join here
            $builder->join('invoice', 'invoice.invoice_id = product_inout.invoice_id', "left"); // added left join here

            $builder->limit($_POST["length"], $_POST["start"]);
            $query=$builder->get()->getResult();

        if ($_POST['search']['value']) {    
            $search = $_POST['search']['value'];
            $query = "product_inout_date LIKE '%$search%'" ;
        } else {
            $query = "product_inout_id !=''";
        }
        
        if (isset($_POST["order"])) {
            $result_order = $this->column_order[$_POST['order']['0']['column']];
            $result_dir = $_POST['order']['0']['dir'];
        } else if ($this->order) {
            $order = $this->order;
            $result_order = Key($order);
            $result_dir = $order[Key($order)];
        }
        if ($_POST["length"] != -1) {
            $query = $builder->where($query)
                ->orderBy($result_order, $result_dir)
                ->orderBy('product_inout_id', 'desc')
                ->limit($_POST["length"], $_POST["start"])
                ->get();
               
            return $query->getResult();
        }
    }

    public function countAll()
    {
        $builder = $this->db->table('product_inout');
        $query = $builder->countAllResults();
        return $query;
    }
    public function countFiltered()
    {
        if ($_POST['search']['value']) {
            $search = $_POST['search']['value'];
            $query = "AND (product_inout_price LIKE '%$search%')";
        } else {
            $query = "";
        }
        $db = \Config\Database::connect();
        $query2 = "SELECT COUNT(product_id) as rowcount FROM product_inout WHERE product_inout_id !='' $query";
        
        $query2 = $db->query($query2)->getRow();
        return $query2->rowcount;
    }

    // protected $validationRules    = [
    //     'productcode'     => 'is_unique[product_inout.productcode]',
    // ];

    // protected $validationMessages = [
    //     'productcode'        => [
    //         'is_unique' => 'Sorry. That productcode has already been taken. Please choose another.',
    //     ],
    // ];
}