<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Http\Requests\StoreCatPost;

class CategoriesController extends Controller
{
    public function index(Request $request, Categories $cat)
    {
        $keyword = trim($request->q);

    	$data = [];
    	// $data['cat'] = $cat->getAllDataCategories();
        // dd($data['cat']);
        $data['message'] = $request->session()->get('mesCat');
        // $lstCat = $cat->getAllDataCategories();

        $listCat = $cat->getAllDataForKeyWord($keyword);
        // dd($listCat);
        $arrCat = ($listCat) ? $listCat->toArray() : [];
        // dd($arrCat);
        $data['cat'] = $arrCat['data'];
        $data['link'] = $listCat;

    	// dd($data['cat']);
    	return view('admin.categories.index', $data);
    }
    public function addCat(Request $request, Categories $cat)
    {
        $data['cat'] = $cat->getAllDataCategories();

        $data['message'] = $request->session()->get('mesCat');
    	return view('admin.categories.add_view',$data);
    }

    public function handleAddCat(StoreCatPost $request ,Categories $cat)
    {
        // dd($request->all());
    	$nameCat = $request->nameCat;
        $cat_parent = $request->cat_parent;

        $dataInsert = [
            'name' => $nameCat,
            'parent_id' => $cat_parent,
        ];
        if ($cat->addData($dataInsert)) {
            $request->session()->flash('mesCat','Success');
            return redirect()->route('admin.categories');
        }
        else {
            $request->session()->flash('mesCat','Fail');
            return redirect()->route('admin.addCat');
        }
    }

    public function editCat($id, Categories $cat, Request $request)
    {
        $id = is_numeric($id) ? $id : 0;

        $infoCat = $cat->getInfoDataCatById($id);
        // dd($infoCat);
        if ($infoCat) {
            $data = [];
            $data['cat'] = $infoCat;
            $data['allCat'] = $cat->getAllDataCategories();

            $data['mes'] = $request->session()->get('mesCat');
            // dd($data['cat']);
            return view('admin.categories.edit_view',$data);
        }
        else {
            abort(404);
        }
    }

    public function handleEditCat(StoreCatPost $request, Categories $cat)
    {
        $id = $request->id;
        // dd($id);
        $nameCat = $request->nameCat;
        $cat_parent = $request->cat_parent;
        $status = $request->status;

        $dataUpdate = [
            'name' => $nameCat,
            'parent_id' => $cat_parent,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $up = $cat->updateDataById($dataUpdate, $id);
        // dd($up);
        if ($up) {
            $request->session()->flash('mesCat','Update Successful');
            return redirect()->route('admin.categories');
        }
        else {
            $request->session()->flash('mesCat','Can not Update');
            return redirect()->route('admin.editCat', ['id'=>$id]);
        }
    }

    public function deleteCat(Request $request, Categories $cat)
    {
        $check = 1;
        if ($request->ajax()) {
            $id = $request->id;
            $info = $cat->getAllDataCategories();
            foreach ($info as $key => $value) {
                if($id == $value['parent_id']) {
                    $check = 0;
                }
            }
            if ($check === 1) {
                $del = $cat->deleteCatById($id);
                if ($del) {
                    echo "OK";                
                }
                else {
                    echo "FAIL";
                }
            }
            else {
                echo "ERR";
            }
        }
    }
}
