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
        // 'productquantity'
    ];

    protected $validationRules    = [
        'productcode'     => 'is_unique[session.productcode]',
    ];

    protected $validationMessages = [
        'productcode'        => [
            'is_unique' => 'Sorry. That productcode has already been taken. Please choose another.',
        ],
    ];

    public function get_all_data()
    {
        $builder = $this->db->table('session');
            $this->table = 'session';
            $this->primaryKey = 'product_id';
            $this->allowedFields = [ 'product_id','productname', 'productprice','productcode',];
            $this->column_order = array('sl','productcode', 'productname', 'productprice');
            $this->order = array('product_id' => 'desc'); //asc //desc

            $builder->select('*');
            $builder->limit($_POST["length"], $_POST["start"]);
            $query=$builder->get()->getResult();

        if ($_POST['search']['value']) {    
            $search = $_POST['search']['value'];
            $query = "productname LIKE '%$search%'";
        } else {
            $query = "product_id !=''";
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
                ->orderBy('product_id', 'desc')

                ->limit($_POST["length"], $_POST["start"])
                ->get();
               
            return $query->getResult();
        }
    }

    public function countAll()
    {
        $builder = $this->db->table('session');
        $query = $builder->countAllResults();
        return $query;
    }
    public function countFiltered()
    {
        if ($_POST['search']['value']) {
            $search = $_POST['search']['value'];
            $query = "AND (productname LIKE '%$search%')";
        } else {
            $query = "";
        }
        $db = \Config\Database::connect();
        $query2 = "SELECT COUNT(product_id) as rowcount FROM session WHERE product_id !='' $query";
        
        $query2 = $db->query($query2)->getRow();
        return $query2->rowcount;
    }
}

    