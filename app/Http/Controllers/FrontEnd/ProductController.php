<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Colors;
use App\Models\Sizes;

class ProductController extends BaseController
{
    public function index(Categories $cat, Products $pd)
    {
    	// load categories
    	$data = [];
    	$data['cat'] = $this->getAllDataCatForUser($cat);

    	$listPd = $pd->getDataPdForUser();
    	$arrPd = $listPd ? $listPd->toArray() : [];
    	$data['listPd'] = $arrPd['data'] ?? [];
    	$data['link'] = $listPd;
    	// dd($arrPd);

    	foreach ($data['listPd'] as $key => $value) {
    		$data['listPd'][$key]['image_product'] = json_decode($value['image_product'],true);
    	}

    	// dd($data['listPd']);
    	return view('frontend.product.index',$data);
    }

    public function detailPd($id, Request $request, Products $pd, Sizes $size, Colors $color, Categories $cat)
    {
    	// lay thong tin san pham
    	$infoPd = $pd->getInfoDataProductById($id);
    	// dd($info);
    	if ($infoPd) {
    		$arrColor = json_decode($infoPd['colors_id'], true);
    		$arrSize = json_decode($infoPd['sizes_id'], true);
    		$arrImage = json_decode($infoPd['image_product'], true);

    		$infoColor = $color->getInfoColorByArrId($arrColor);
    		$infoSize = $size->getInfoSizeById($arrSize);
    		// dd($infoColor, $infoSize);

    		$data = [];
    		$data['info'] = $infoPd;
    		$data['image'] = $arrImage;
    		// dd($data['']);
    		$data['color'] = $infoColor;
    		$data['size'] = $infoSize;
    		$data['cat'] = $this->getAllDataCatForUser($cat);
    		// dd($data['color']);

    		return view('frontend.product.detail',$data);
    	}
    	else {
    		abort(404);
    	}
    }

    public function showCategori($id, Categories $cat, Products $pd)
    {
        $check = true;
        $data = [];
        $data['cat'] = $this->getAllDataCatForUser($cat);
        // $listPd = $pd->getDataPdForUser();
        $pdList = $pd->getFullData();
        // dd($pdList);
        // $arrPd = $listPd ? $listPd->toArray() : [];
        $pdArr = $pdList ? $pdList->toArray() :[];
        // dd($pdArr);
        $data['listPd'] = $pdArr ?? [];
        // $data['link'] = $listPd;
        // dd($arrPd);

        $data['infoPd'] = $pdArr;
        // dd($infoPd);
        $data['pdCat'] = [];
        foreach ($data['infoPd'] as $key => $value) {
            $arr = [];
            $data['infoPd'][$key]['categories_id'] = json_decode($value['categories_id'], true);
            $arr['cat'] = $data['infoPd'][$key]['categories_id'];
            if (in_array($id, $arr['cat'])) {
               $data['pdCat'][] = $value;
            }
        }
        foreach ($data['pdCat'] as $key => $value) {
            $data['pdCat'][$key]['image_product'] = json_decode($value['image_product'],true);
        }
        // dd($data['pdCat']);
        if (!$data['pdCat']) {
            $data['empty'] = "Danh mục không có sản phẩm phù hợp";
        }
        // dd($data['pdCat']);
        return view('frontend.product.show_pg_cat',$data);
    }
}
