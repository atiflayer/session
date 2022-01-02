<?php

namespace App\Controllers;
use App\Models\SessionModel;
use App\Models\Product_InOut_Model;

class ProductInOut extends BaseController
{
    public function product_in_form($product_id)
    {
		$model = new SessionModel();
		$data['post']=$model->find($product_id);
        $data['products']=$model->find($product_id);

        

		return view('product_in_form', $data);
    }




    public function getProducts(){

        $request = service('request');
        $postData = $request->getPost();
  
        $response = array();
  
        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();
        $data = array();
  
        if(isset($postData['search'])){
  
           $search = $postData['search'];
  
           // Fetch record
           $products = new SessionModel();
           $productlist = $products->select('product_id,productname,productprice,productcode')
                  ->like('productcode',$search)
                  ->orderBy('productname')
                  ->findAll();
           foreach($productlist as $product){
               $data[] = array(
                  "productcode" => $product['productcode'],
                  "product_id" => $product['product_id'],
                  "productname" => $product['productname'],
                  "productprice" => $product['productprice'],
               );
           }
        }
    }

    public function product_out_form($product_id)
    {
		$model = new SessionModel();
		$data['post']=$model->find($product_id);

		return view('product_out_form', $data);
    }

    public function product_inout_form()
    {
		$model = new SessionModel();
		$data['products']=$model->findAll();

		return view('product_inout_form',$data);
    }

    //add to cart / session

    public function postData()
    {
        $session = session();
        if(isset($session->productdata)){
            $oldarray = $session->productdata;
            $data = [
                'product_inout_date' => $this->request->getPost('product_inout_date'),
                'product_inout_quantity_in' => $this->request->getPost('product_inout_quantity_in'),
                'product_inout_quantity_out' => $this->request->getPost('product_inout_quantity_out')
            ];

            //check for unique productcode

            foreach($oldarray as $row){
                if($data['productcode']==$row['productcode']){
                    return redirect()->to(base_url('/'))->with('status', 'Product Already Exists');
                }
            }
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);

        }else{
            $oldarray = [];
            $data = [
                'product_inout_date' => $this->request->getPost('product_inout_date'),
                'product_inout_quantity_in' => $this->request->getPost('product_inout_quantity_in'),
                'product_inout_quantity_out' => $this->request->getPost('product_inout_quantity_out'),
            ];
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);
         }
         $result=$session->productdata;
         return redirect()->to('/');
    }

     public function postsubmit()
     {
        $session = session();
        $model = new Product_InOut_Model();
        // $result=$session->productdata;

        $input = $this->request->getPost();

        // foreach($result as $row){
            $data = [
                'product_id' => $input['product_id'],
                'product_inout_price'=>$input['product_inout_price'],
                'product_inout_date'=>$input['product_inout_date'],
                'product_inout_quantity_in'=>$input['product_inout_quantity_in'],
                // 'product_inout_quantity_out'=input['product_inout_quantity_out'],
            ];
            if ($model->save($data) === false) {
                $session->setFlashdata('errors', $model->errors());
            }else{
                $session->setFlashdata('status','Product Purchased Successfully');
            }
        // }
        // $session->remove('productdata');
		return redirect()->to('/');
    }

    public function get_inout_data()
	{
		$value = new Product_InOut_Model();
		$get_data = $value->get_all_data();	

        // echo '<pre>';
        // print_r($get_data);
        // exit;

        $i = $_POST['start'];

		foreach ($get_data as $val) {
			$data[] = array(
				++$i,
                // $val->product_id,
                // $val->productcode,
                // $val->productname,
                // $val->productprice,
                $val->product_inout_price,
                $val->product_inout_date,
                $val->product_inout_quantity_in,
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $value->countAll(),
			"recordsFiltered" => $value->countFiltered(),
			"data" => isset($data) ? $data : [],
		);
		echo json_encode($output);
	}

    public function product_inout_dtable()
    {
        return view('product_inout_dtable');
    }

	public function edit($product_id) 
	{	
		$model = new SessionModel();
		$data['post']=$model->find($product_id);

		return view('edit', $data);
	}

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

		if ($model->save($data) === false){
            $session->setFlashdata('errors', $model->errors()); 
        }else{
            $session->setFlashdata('status','Product In/Out Successfull');
        }
		return redirect()->to('product_inout_dtable');
	}

    public function delete($product_id)
	{	
        $session = session();
		$model = new SessionModel();
        // $model->delete($product_id);

        if ($model->delete($product_id) === false){
            $session->setFlashdata('errors', $model->errors());
        }else{
            $session->setFlashdata('status','Data Deleted Successfully');
        }
		return redirect()->to('product_list_dtable');
	}
}