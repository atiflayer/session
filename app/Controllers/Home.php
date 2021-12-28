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
    //add to cart

    public function postData(){
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

            // echo '<pre>';
            // print_r($oldarray[0]);
            // exit;
            
            // foreach($oldarray as $row){

            //     if($data['productname']==$row['productname']){
            //         $row['productquantity'] += $data['productquantity'];
            //     }
            // }

            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);

            // echo '<pre>';
            // print_r($row['productquantity']);
            // exit;

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
    //submit to database

     public function postsubmit(){
        $session = session();
        $model = new SessionModel();
        $result=$session->productdata;

        foreach($result as $row){
            $data = [
                'productname'=>$row['productname'],
                // 'productquantity'=>$row['productquantity'],
                'productcode'=>$row['productcode'],
                'productprice'=>$row['productprice']
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

    public function fetch()
	{
		$model = new SessionModel();
		$data['model'] = $model->findAll();	

        // $i = $_POST['start'];

		foreach ($fetch as $val) {
			$data[] = array(
				++$i,
                $val->productcode,
                $val->productname,
                $val->productprice,
			);
		}
        
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $value->countAll(),
			"recordsFiltered" => $value->countFiltered(),
			"data" => isset($data) ? $data : [],
		);
		echo json_encode($output);
        
        // return view('productlist', $data);
		// return view('list', $data);
	}
}