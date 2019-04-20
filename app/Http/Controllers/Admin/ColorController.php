<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Colors;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreColorPost;

class ColorController extends Controller
{
    public function index(Request $request, Colors $color){

    	 $data=[];
         $keyword = trim($request->q);
         $lstCl = $color->getAllDataKeyColors($keyword);
        $arrCl = ($lstCl) ? $lstCl->toArray() : [];
        $data['colors'] = $arrCl['data'];
        //dd($data['lstPd']);
        $data['link']  = $lstCl;

    	 // $data['colors']= $color->getAllDataColors();
    	return view('admin.color.index',$data);
    }
    public function addColor(){
    	return view('admin.color.add_view');
    }
    public function editColor($id , Colors $cl){
        $id = is_numeric($id) ? $id : 0;
        // if (is_numeric($id)) {
        //     $id = $id;
        //     # code...
        // }
        // else {
        //     $id = 0;
        // }
        // lay thong tin san pham theo id
        $infoCl = $cl->getInfoDataColorById($id);
        if($infoCl){
            $data=[];
            $data['infor']= $infoCl;
            // dd($infoCl);
            return view('admin.color.edit_view',$data);
        }
    	
    }
    public function handleAddColor(StoreColorPost $request,Colors $cl){
    	$nameColor= $request->nameColor;
    	$description = $request->description;
        $dataInsert = [
        	'name_color'=> $nameColor,
        	'status'=> 1,
        	'description'=> $description,
        	'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
             ];
        if($cl->addDataColor($dataInsert)){
            $request->session()->flash('addCl','success');
            return redirect()->route('admin.color');
        } else {
            $request->session()->flash('addCl','Fail');
            return redirect()->route('admin.addColor');
        }
    }
    public function handlEditColor(StoreColorPost $request, Colors $cl){
        $id = $request->id;
        $infocl = $cl->getInfoDataColorById($id);
        if($infocl){
            $nameColor = $request->nameColor;
            $status= $request->status;
            $description = $request->description;

    }
        $dataUpdate = [
            'name_color' => $nameColor,
            'status' =>$status,
            'description' => $description
                ];
        $up = $cl->updateDataColorById($dataUpdate, $id);
                if($up){
                    $request->session()->flash('editcl','update successful');
                    return redirect()->route('admin.color');
                } else {
                    $request->session()->flash('editcl','Can not update');
                    return redirect()->route('admin.editColor',['id'=>$id]);
                }

}
 public function deleteColor(Request $request, Colors $cl)
    {
        if($request->ajax()){
            // dung la ajax gui len thi moi xu ly
            $id = $request->id;
            $del = $cl->deleteColorById($id);
            if($del){
               echo "OK"; 
            } else {
                echo "FAIL";
            }
        }
    }
}