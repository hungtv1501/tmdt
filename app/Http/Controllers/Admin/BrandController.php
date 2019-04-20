<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Http\Requests\StoreBrandPost;
class BrandController extends Controller
{
    public function index(Request $request,Brands $brand){
    	   $data=[];
         $keyword = trim($request->q);
         $lstBr = $brand->getAllDataKeyBrands($keyword);
        $arrBr = ($lstBr) ? $lstBr->toArray() : [];
        $data['brands'] = $arrBr['data'];
        //dd($data['lstPd']);
        $data['link']  = $lstBr;

    	return view('admin.brand.index', $data);
    	    }
   	public function addBrand(){
   		return view('admin.brand.add_view');
   	}
   	public function handleAddBrand(StoreBrandPost $request, Brands $brand){
   		$nameBrand= $request->nameBrand;
   		$address= $request->address;
   		$description= $request->description;
   		// luu vao co so du lieu
   		$dataInsert=[
   				'brand_name'=>$nameBrand,
   				'address' =>$address,
   				'description'=>$description
   		];
   		 if($brand->addDataBrand($dataInsert)){
                $request->session()->flash('addBr','success');
                return redirect()->route('admin.brand');
            } else {
                $request->session()->flash('addBr','Fail');
                return redirect()->route('admin.addBrand');
            }
   	}
   	public function editBrand($id, Brands $brand){
   		$id= is_numeric($id) ? $id :0;
   		$infoBr = $brand -> getInfoDataBrandById($id);
   		if($infoBr){
   			$data=[];
   			$data['infor']= $infoBr;
   			return view('admin.brand.edit_view', $data);
   		}

   	}
   	public function handleEditBrand( StoreBrandPost $request, Brands $brand){
   			$id= $request ->id;
   			$infoBr= $brand-> getInfoDataBrandById($id);
   			if($infoBr){ 
   				$nameBrand= $request ->nameBrand;
   				$address = $request ->address;
   				$status = $request ->status;
   				$description = $request ->description;
   			}
   			$dataUpdate=[
   				'brand_name'=>$nameBrand,
   				'address'=>$address,
   				'status'=>$status,
   				'description'=>$description
   			];
   			$up= $brand-> updateDataBrandById($dataUpdate,$id);
   			if($up){
   				 $request->session()->flash('editbr','update successful');
                    return redirect()->route('admin.brand');
                } else {
                    $request->session()->flash('editcl','Can not update');
                    return redirect()->route('admin.editBrand',['id'=>$id]);
   			}
   	}
    public function deleteBrand(Request $request, Brands $brand){
      if($request->ajax()){
            // dung la ajax gui len thi moi xu ly
            $id = $request->id;
            $del = $brand->deleteBrandById($id);
            if($del){
               echo "OK"; 
            } else {
                echo "FAIL";
            }
        }
    }
}
