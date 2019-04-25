<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sizes;
use App\Http\Requests\StoreSizePost;


class SizeController extends Controller
{
    public function index(Request $request,Sizes $size){
         $data=[];
         $keyword = trim($request->q);
         $lstSz = $size->getAllDataKeySize($keyword);
        $arrSz = ($lstSz) ? $lstSz->toArray() : [];
        $data['sizes'] = $arrSz['data'];
        //dd($data['lstPd']);
        $data['link']  = $lstSz;

    	// $data=[];
    	// $data['sizes']= $size-> getAllDataSizes();
    	return view('admin.size.index',$data);
    }

    public function addSize(){
    	return view('admin.size.add_view');
    }
    public function handleAddSize(StoreSizePost $request, Sizes $size){
    	$letterSize= $request->letterSize;
    	$numberSize= $request->numberSize;
    	$description= $request->description;
    	$dataInsert=[
    		'letter_size'=> $letterSize,
    		'number_size'=> $numberSize,
    		'status'=> 1,
    		'description'=> $description
    	];
    	if($size->addDataSize($dataInsert)){
            // $request->session()->flash('addSz','success');
            return redirect()->route('admin.size');
        } else {
            // $request->session()->flash('addSz','Fail');
            return redirect()->route('admin.addSize');
        }


    }
    
    public function editSize($id , Sizes $size){
        $id = is_numeric($id) ? $id : 0;
        // if (is_numeric($id)) {
        //     $id = $id;
        //     # code...
        // }
        // else {
        //     $id = 0;
        // }
        // lay thong tin san pham theo id
        $infoSz = $size->getInfoDataSizeById($id);
        if($infoSz){
            $data=[];
            $data['infor']= $infoSz;
            // dd($infoCl);
            return view('admin.size.edit_view',$data);
        }
    }
    public function handleEditSize(StoreSizePost $request, Sizes $size){
    	$id= $request ->id;
    	$infoSz= $size-> getInfoDataSizeById($id);
    	if($infoSz){
    	$letterSize= $request->letterSize;
    	$numberSize= $request->numberSize;
    	$status= $request->status;
    	$description= $request->description;
		}
    	$dataUpdate=[
   				'letter_size'=>$letterSize,
   				'number_size' =>$numberSize,
   				'status'=>$status,
   				'description'=>$description
   		];
   		 $up= $size-> updateDataSizeById($dataUpdate,$id);
   			if($up){
   				 $request->session()->flash('editSz','Cập nhật kích cỡ thành công');
                    return redirect()->route('admin.size');
                } else {
                    $request->session()->flash('editSz','Không thể cập nhật kích cỡ');
                    return redirect()->route('admin.editSize',['id'=>$id]);
   			}
    }
     public function deleteSize(Request $request, Sizes $size){
      if($request->ajax()){
            // dung la ajax gui len thi moi xu ly
            $id = $request->id;
            $del = $size->deleteSizeById($id);
            if($del){
               echo "OK"; 
            } else {
                echo "FAIL";
            }
        }
    }
    
}
