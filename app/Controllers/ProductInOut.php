<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\Product_InOut_Model;
use App\Models\SessionModel;

class ProductInOut extends BaseController
{
    public function product_inout_form()
    {
        $model = new SessionModel();
        $result['products'] = $model->findAll();

        $session = session();
        if (isset($session->productdata)) {
            $result['data'] = $session->productdata;
        } else {
            $result['data'] = [];
        }
        return view('product_inout_form', $result);
    }

    //Add to Cart / Session

    public function postData()
    {
        $session = session();
        $input = $this->request->getPost();

        if (isset($session->productdata)) {
            $oldarray = $session->productdata;
            $data = [
                'productcode' => $input['productcode'],
                'product_id' => $input['product_id'],
                'productname' => $input['productname'],

                'productprice' => $input['productprice'],
                'product_inout_quantity_in' => $input['product_inout_quantity_in'],
                'product_finalprice' => $input['productprice'] * $input['product_inout_quantity_in'],
                'product_inout_date' => $input['product_inout_date'],
            ];

            // Using Foreach to Increase Quantity and CALC Price

            foreach ($oldarray as $key => $value) {
                if ($oldarray[$key]['productcode'] == $data['productcode']) {
                    $oldarray[$key]['product_inout_quantity_in'] += $data['product_inout_quantity_in'];
                    $oldarray[$key]['product_finalprice'] = $oldarray[$key]['product_inout_quantity_in'] * $oldarray[$key]['productprice'];

                    $session->set('productdata', $oldarray);
                    return redirect()->to('/');
                }
            }
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);
        } else {
            $oldarray = [];
            $data = [
                'productcode' => $input['productcode'],
                'product_id' => $input['product_id'],
                'productname' => $input['productname'],

                'productprice' => $input['productprice'],
                'product_inout_quantity_in' => $input['product_inout_quantity_in'],
                'product_finalprice' => $input['productprice'] * $input['product_inout_quantity_in'],
            ];
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);
        }
        $result = $session->productdata;

        //SESSION CALC TOTAL PRICE (CHECK VIEW LOGIC)

        //  foreach($result as $key => $value){

        //     $result['totalprice'] = $result[$key]['product_finalprice'] ;
        //     $result['totalprice'] += $data['product_finalprice'];

        //     $session->set('productdata', $result);

        //     // echo '<pre>';
        //     // print_r($result[totalprice]);
        //     // exit;
        //  }

        return redirect()->to('/');
    }

    //SUBMIT TO DATABASE (BOTH PRODUCTINOUT AND INVOICE)

    public function postsubmit()
    {
        $session = session();
        $model = new Product_InOut_Model();
        $invoice = new InvoiceModel();

        $result = $session->productdata;

        // $db = \Config\Database::connect();
        // $builder = $db->table('invoice');
        // $builder->select('MAX(invoice_id) as max_id');
        // $query = $builder->get()->getResult();  

        $input = $this->request->getPost();

        $data = [
            'invoice_customerName' => $input['invoice_customerName'],
            'invoice_customerPhone' => $input['invoice_customerPhone'],
            'invoice_customerAddress' => $input['invoice_customerAddress'],
            // 'invoice_total' => $result['totalprice'],
        ];
        $save_invoice_data = $invoice->save($data);

        if ($save_invoice_data === false) {
            $session->setFlashdata('errors', $invoice->errors());
        } else {
            $parent_id = $invoice->insertID;
            $session->setFlashdata('status', 'Product In/Out and Invoice Successfully');
        }

        foreach ($result as $row) {
            $data = [
                'product_id' => $row['product_id'],
                'invoice_id' => $parent_id,
                'product_inout_price' => $row['productprice'],
                'product_inout_quantity_in' => $row['product_inout_quantity_in'],
                'product_finalprice' => $row['product_finalprice'],
                'product_inout_date'=>$row['product_inout_date'],
            ];
            $insert_session_data = $model->save($data);

            if ($insert_session_data === false) {
                $session->setFlashdata('errors', $model->errors());
            } else {
                $session->setFlashdata('status', 'Product Purchased Successfully');
            }
        }
        $session->remove('productdata');

        return redirect()->to('/');
    }

    // FOR DATA TABLE FETCH

    public function get_inout_data()
    {
        $inout = new Product_InOut_Model();
        $get_data = $inout->get_all_data();

        $i = $_POST['start'];

        foreach ($get_data as $val) {
            $data[] = [
                ++$i,
                $val->product_id,
                $val->invoice_id,
                $val->product_inout_price,
                $val->product_inout_date,
                $val->product_inout_quantity_in,
                $val->product_finalprice,
            ];
        }
        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $inout->countAll(),
            'recordsFiltered' => $inout->countFiltered(),
            'data' => isset($data) ? $data : [],
        ];
        echo json_encode($output);
    }

    public function product_inout_dtable()
    {
        return view('product_inout_dtable');
    }

    public function get_invoice_data()
    {
        $inout = new Product_InOut_Model();
        $get_data = $inout->get_all_data();

        $i = $_POST['start'];

        foreach ($get_data as $val) {
            $data[] = [
                ++$i,
                $val->product_id,
                $val->invoice_id,
                $val->product_inout_price,
                $val->product_inout_date,
                $val->product_inout_quantity_in,
                $val->product_finalprice,
            ];
        }
        $output = [
            'draw' => $_POST['draw'],
            'recordsTotal' => $inout->countAll(),
            'recordsFiltered' => $inout->countFiltered(),
            'data' => isset($data) ? $data : [],
        ];
        echo json_encode($output);
    }

    public function invoice()
    {
        return view('invoice');
    }




    //REDUCNDANT FOR NOW

    //FOR DATA TABLE FETCH 2

    public function product_inout()
    {
        // $session = session();
        $model = new Product_InOut_Model();

        // $result=$session->productdata;
        // $data = $model->find($product_id);
        // $input = $this->request->getPost();

        $input = $this->request->getRawInput();

        $data = [
            'product_id' => $input['product_id'],
            'product_inout_date' => $input['product_inout_date'],
            'product_inout_quantity_in' => $input['product_inout_quantity_in'],
            'product_inout_quantity_out' => $input['product_inout_quantity_out'],
        ];

        if ($model->save($data) === false) {
            $session->setFlashdata('errors', $model->errors());
        } else {
            $session->setFlashdata('status', 'Product In/Out Successfull');
        }
        return redirect()->to('product_inout_dtable');
    }

    public function edit($product_id)
    {
        $model = new SessionModel();
        $data['post'] = $model->find($product_id);

        return view('edit', $data);
    }

    public function delete($product_id)
    {
        $session = session();
        $model = new SessionModel();
        // $model->delete($product_id);

        if ($model->delete($product_id) === false) {
            $session->setFlashdata('errors', $model->errors());
        } else {
            $session->setFlashdata('status', 'Data Deleted Successfully');
        }
        return redirect()->to('product_list_dtable');
    }

    public function product_in_form($product_id)
    {
        $model = new SessionModel();
        $data['post'] = $model->find($product_id);
        $data['products'] = $model->find($product_id);

        return view('product_in_form', $data);
    }

    public function product_out_form($product_id)
    {
        $model = new SessionModel();
        $data['post'] = $model->find($product_id);

        return view('product_out_form', $data);
    }

    //FOR AJAX JQUERY UI AUTOCOMPLETE

    public function getProducts()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = [];

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();
        $data = [];

        if (isset($postData['search'])) {
            $search = $postData['search'];

            // Fetch record
            $products = new SessionModel();
            $productlist = $products
                ->select('product_id,productname,productprice,productcode')
                ->like('productcode', $search)
                ->orderBy('productname')
                ->findAll();
            foreach ($productlist as $product) {
                $data[] = [
                    'productcode' => $product['productcode'],
                    'product_id' => $product['product_id'],
                    'productname' => $product['productname'],
                    'productprice' => $product['productprice'],
                ];
            }
        }
    }
}
