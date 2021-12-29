<?php

namespace App\Controllers;
use App\Models\SessionModel;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        if(isset($session->productdata)){
            $result['data']=$session->productdata;
        }else{
            $result['data']=[];
        }
        return view('index', $result);
    }

    //add to cart / session

    public function postData()
    {
        $session = session();
        if(isset($session->productdata)){
            $oldarray = $session->productdata;
            $data = [
                'productname' => $this->request->getPost('productname'),
                'productquantity' => $this->request->getPost('productquantity'),

                'productprice' => $this->request->getPost('productprice'),
                'productcode' => $this->request->getPost('productcode')
            ];

            //check for unique productcode

            foreach($oldarray as $row){
                if($data['productcode']==$row['productcode']){
                    return redirect()->to(base_url('/'))->with('status', 'Product Already Exists');
                }
            }

            // if productname repeats, add quantity
            
            // foreach($oldarray as $row){

            //     if($data['productname']==$row['productname']){
            //         $row['productquantity'] += $data['productquantity'];
            //     }
            // }

            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);

        }else{
            $oldarray = [];
            $data = [
                'productname' => $this->request->getPost('productname'),
                'productquantity' => $this->request->getPost('productquantity'),
                'productprice' => $this->request->getPost('productprice'),
                'productcode' => $this->request->getPost('productcode'),
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
        $model = new SessionModel();
        $result=$session->productdata;

        foreach($result as $row){
            $data = [
                'productname'=>$row['productname'],
                'productcode'=>$row['productcode'],
                'productprice'=>$row['productprice']
                // 'productquantity'=>$row['productquantity'],
            ];
            if ($model->save($data) === false) {
                $session->setFlashdata('errors', $model->errors());
            }else{
                $session->setFlashdata('status','Data Added Successfully');
            }
        }
        $session->remove('productdata');
		return redirect()->to('/');
    }

    public function get_data()
	{
		$value = new SessionModel();
		$get_data = $value->get_all_data();	

        $i = $_POST['start'];

		foreach ($get_data as $val) {
			$data[] = array(
				++$i,
                $val->productcode,
                $val->productname,
                $val->productprice,
                $val->product_id,
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

    public function product_list_dtable()
    {
        return view('product_list_dtable');
    }

	public function edit($product_id) 
	{	
		$model = new SessionModel();
		$data['post']=$model->find($product_id);

		return view('edit', $data);
	}

	public function update($product_id)
	{
		$model = new SessionModel();

		$data = $model->find($product_id);
        // $input = $this->request->getRawInput();

		$data = [   
			'productname' => $this->request->getPost('productname'),
            'productprice' => $this->request->getPost('productprice'),
            'productcode' => $this->request->getPost('productcode'),
		];

		$model->update($product_id, $data);

		return redirect()->to('product_list_dtable');
	}

    public function delete($product_id)
	{	
		$model = new SessionModel();
        $model->delete($product_id);
		
		return redirect()->to('product_list_dtable');
	}
}