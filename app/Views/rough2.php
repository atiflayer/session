
            // $product_id = $this->request->getPost('product_id');
            // $db      = \Config\Database::connect();
            // $builder = $db->table('session');
            // $builder->select('*')->where('product_id',$product_id);
            // $query = $builder->get()->getRow(); 

            //check for unique productcode

// foreach($oldarray as $row){
//     if($data['productcode']==$row['productcode']){
//         return redirect()->to(base_url('/'))->with('status', 'Product Already Exists');
//     }
// }

//check for same record -> update record

//Using For Loop

// for($j=0; $j<count($oldarray); $j++){
//     if($oldarray[$j]['productcode'] == $data['productcode']){
//         $oldarray[$j]['product_inout_quantity_in'] += $data['product_inout_quantity_in'];
//         $oldarray[$j]['product_finalprice'] = $oldarray[$j]['product_inout_quantity_in']*$oldarray[$j]['productprice'];


//         $session->set('productdata', $oldarray);
//         return redirect()->to('/');
//     }
// }