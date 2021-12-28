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
                'productprice' => $this->request->getPost('productprice'),
                'productcode' => $this->request->getPost('productcode')
            ];
            //check for unique productcode
            foreach($oldarray as $row){
                if($data['productcode']==$row['productcode']){
                    return redirect()
                            ->to(base_url('/'))
                            ->with('status', 'Data Already Exists');
                }
            }
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);
        }else{
            $oldarray = [];
            $data = [
                'productname' => $this->request->getPost('productname'),
                'productprice' => $this->request->getPost('productprice'),
                'productcode' => $this->request->getPost('productcode'),
            ];
            array_push($oldarray, $data);
            $session->set('productdata', $oldarray);
         }
         $result=$session->productdata;
         return redirect()->to('/');
    }
    //submit
     public function postsubmit(){
        $session = session();
        $model = new SessionModel();
        $result=$session->productdata;

        // echo '<pre>';
        // print_r($result);
        // exit;

        foreach($result as $row){
            $data = [
                'productcode'=>$row['productcode'],
                'productname'=>$row['productname'],
                'productprice'=>$row['productprice']
            ];
        }
        $model->save($data);

        
		return redirect()->to('/');
    }
}
