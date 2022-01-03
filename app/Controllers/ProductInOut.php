<?php

namespace App\Controllers;
use App\Models\SessionModel;
use App\Models\Product_InOut_Model;

class ProductInOut extends BaseController
{
    public function product_inout_form()
    {
		$model = new SessionModel();
		$result['products']=$model->findAll();

        $session = session();
        if(isset($session->productdata)){
            $result['data']=$session->productdata;
        }else{
            $result['data']=[];
        }
		return view('product_inout_form', $result);
    }

    //add to cart / session

    public function postData(){   
        $session = session();
        $input = $this->request->getPost();


        if(isset($session->productdata)){
            $oldarray = $session->productdata;
            $data = [
                'productcode' => $input['productcode'],
                'product_id' => $input['product_id'],
                'productname' => $input['productname'],
                'productprice' => $input['productprice'],
                'product_inout_quantity_in' => $input['product_inout_quantity_in'],
                'product_finalprice'=> $input['productprice']*$input['product_inout_quantity_in'],
                // 'product_inout_date' => $input['product_inout_date'],
            ];

            //check for unique productcode

            // foreach($oldarray as $row){
            //     if($data['productcode']==$row['productcode']){
            //         return redirect()->to(base_url('/'))->with('status', 'Product Already Exists');
            //     }
            // }

            //check for same record -> update record

            foreach($oldarray as $row){
                if($data['productcode'] == $row['productcode']){
                    $row['product_inout_quantity_in'] += $data['product_inout_quantity_in'];

                    
                    // echo '<pre>';
                    // print_r($oldarray[0]);
                    // exit;
                    

                    // array_push($oldarray, $row);
                    // $session->set('productdata', $oldarray);


                    return redirect()->to('/');
                }
            }
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);



            
        }else{
            $oldarray = [];
            $data = [
                'productcode' => $input['productcode'],
                'product_id' => $input['product_id'],
                'productname' => $input['productname'],
                'productprice' => $input['productprice'],
                'product_inout_quantity_in' => $input['product_inout_quantity_in'],
                'product_finalprice'=> $input['productprice']*$input['product_inout_quantity_in'],
            ];
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);
         }
         $result=$session->productdata;
         return redirect()->to('/');
    }

    //SUBMIT TO DATABASE

     public function postsubmit()
     {
        $session = session();
        $model = new Product_InOut_Model();
        $result = $session->productdata;

        foreach($result as $row){
            $data = [
                'product_id' => $row['product_id'],
                'product_inout_price' => $row['productprice'],
                'product_inout_quantity_in' => $row['product_inout_quantity_in'],
                'product_finalprice' => $row['product_finalprice']
                // 'product_inout_date'=>$row['product_inout_date'],
            ];
            if ($model->save($data) === false) {
                $session->setFlashdata('errors', $model->errors());
            }else{
                $session->setFlashdata('status','Product Purchased Successfully');
            }
        }
        $session->remove('productdata');
		return redirect()->to('/');
    }



    

    // FOR DATA TABLE FETCH

    public function get_inout_data()
	{
		$value = new Product_InOut_Model();
		$get_data = $value->get_all_data();	

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

		if ($model->save($data) === false){
            $session->setFlashdata('errors', $model->errors()); 
        }else{
            $session->setFlashdata('status','Product In/Out Successfull');
        }
		return redirect()->to('product_inout_dtable');
	}

    public function edit($product_id) 
	{	
		$model = new SessionModel();
		$data['post']=$model->find($product_id);

		return view('edit', $data);
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

    public function product_in_form($product_id)
    {
		$model = new SessionModel();
		$data['post']=$model->find($product_id);
        $data['products']=$model->find($product_id);

		return view('product_in_form', $data);
    }

    public function product_out_form($product_id)
    {
		$model = new SessionModel();
		$data['post']=$model->find($product_id);

		return view('product_out_form', $data);
    }

    //FOR AJAX JQUERY UI AUTOCOMPLETE

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
}