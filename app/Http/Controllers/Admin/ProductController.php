<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Brands;
use App\Http\Requests\StoreProductPost;
use App\Models\Products;

class ProductController extends Controller
{
    public function index(Request $request, Products $product, Categories $cat, Colors $color, Sizes $size, Brands $brand)
    {
        $keyword = trim($request->q);
        // dd($keyword);
        $data  = [];
        $data['message'] = $request->session()->get('addProduct');
        $data['mes'] = $request->session()->get('editPd');
        // $data['products'] = $product->getAllData();
        $data['cat'] = $cat->getAllDataCategories();
        $data['color'] = $color->getAllDataColors();
        $data['size'] = $size->getAllDataSizes();
        $data['brand'] = $brand->getAllDataBrands();

        $lstPd = $product->getAllData($keyword);
        $arrProduct = ($lstPd) ? $lstPd->toArray() : [];
        $data['products'] = $arrProduct['data'];
        $data['link'] = $lstPd;
        // dd($products);
        // dd($data['brand']);
        foreach ($data['products'] as $key => $item) {
            $data['products'][$key]['categories_id'] = json_decode($item['categories_id'],true);
            $data['products'][$key]['colors_id'] = json_decode($item['colors_id'],true);
            $data['products'][$key]['sizes_id'] = json_decode($item['sizes_id'],true);
            $data['products'][$key]['image_product'] = json_decode($item['image_product'],true);
        }
        // dd($data['products']);
        foreach ($data['products'] as $key => $item) {
            foreach ($data['cat'] as $k => $val) {
                if (in_array($val['id'], $item['categories_id'])) {
                    $data['products'][$key]['categories_id']['name_cat'][] = $val['name'];
                }
            }
        }
        foreach ($data['products'] as $key => $item) {
            foreach ($data['color'] as $k => $val) {
                if (in_array($val['id'], $item['colors_id'])) {
                    $data['products'][$key]['colors_id']['name_color'][] = $val['name_color'];
                }
            }
        }
        foreach ($data['products'] as $key => $item) {
            foreach ($data['size'] as $k => $val) {
                if (in_array($val['id'], $item['sizes_id'])) {
                    $data['products'][$key]['sizes_id']['name_size'][] = $val['letter_size'];
                }
            }
        }

        // dd($data['products']);
    	return view('admin.product.index',$data);
    }

    public function addProduct(Categories $cat, Colors $color, Sizes $size, Brands $brand, Request $request)
    {
    	// lay du lieu tu bang categories sang view
    	$data = [];
    	$data['cat'] = $cat->getAllDataCategories();
    	$data['color'] = $color->getAllDataColors();
    	$data['size'] = $size->getAllDataSizes();
    	$data['brand'] = $brand->getAllDataBrands();
    	// dd($data_size);

        $data['message'] = $request->session()->get('addProduct');

    	return view('admin.product.add_view', $data);
    }

    public function handleAddProduct(StoreProductPost $request, Products $product)
    {
    	// dd($request->all());
        $nameProduct = $request->nameProduct;
        $categories = $request->categories;
        $colors = $request->color;
        $sizes = $request->size;
        $brand = $request->brand;
        $price = $request->price;
        $qty = $request->qty;
        $sale = $request->sale;
        $description = $request->des;
        // $arrNameFile2 = [];
        // thuc hien upload file
        // kiem tra xem nguoi dung co chon file hay ko
        if ($request->hasFile('image')) {
            // lay thong tin cua file
            $files = $request->file('image');
            // dd($files);
            $extension = ['jpg','png','jpeg','gif'];
            foreach ($files as $key => $value) {
                // lay ra dc ten file và đường dẫn lưu file trên máy người dùng
                $nameFile = $value->getClientOriginalName();
                // echo $nameFile;
                // echo "<br>";
                // lay ra duoi file (phan mo rong cua file)
                $exFile = $value->getClientOriginalExtension();
                // echo $exFile;
                // echo "<br>";
                if (in_array($exFile, $extension)) { // kiem tra duoi anh co hop le hay ko thi cho upload
                    // public_path() di vao thu muc public sau co vao file upload/images
                    $value->move(public_path().'/upload/images',$nameFile);
                    $arrNameFile[] = $nameFile;
                }
            }
        }
        // dd($arrNameFile);
        // tien hanh luu thong tin vao db
        // $arrNameFile = ($arrNameFile) ? $arrNameFile2 : $arrNameFile;
        if ($arrNameFile) {
            // luu vao db
            $dataInsert = [
                'name_product' => $nameProduct,
                'categories_id' => json_encode($categories),
                'colors_id' => json_encode($colors),
                'sizes_id' => json_encode($sizes),
                'brands_id' => $brand,
                'price' => $price,
                'qty' => $qty,
                'description' => $description,
                'image_product' => json_encode($arrNameFile),
                'sale_off' => $sale,
                'status' => 1,
                'view_product' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ];
            if ($product->addData($dataInsert)) {
                $request->session()->flash('addProduct','Success');
                return redirect()->route('admin.products');
            }
            else {
                $request->session()->flash('addProduct','Fail');
                return redirect()->route('admin.addProduct');
            }
        }
        else {
            $request->session()->flash('addProduct','Can not upload image');
            return redirect()->route('admin.addProduct');
        }
    }
    public function deleteProduct(Request $request, Products $product) {
        if ($request->ajax()) {
            // dung la ajax gui len moi xu ly
            $id = $request->id;
            // echo $id;
            $del = $product->deleteProductById($id);
            if ($del) {
                echo "OK";                
            }
            else {
                echo "FAIL";
            }
        }
    }

    public function editProduct($id, Request $request, Products $product, Categories $cat, Colors $color, Sizes $size, Brands $brand)
    {
        $id = is_numeric($id) ? $id : 0;
        // lay thong tin chi tiet cua san pham
        $info = $product->getInfoDataProductById($id);
        // dd($info);
        if ($info) {
            $data = [];
            $data['cat'] = $cat->getAllDataCategories();
            $data['color'] = $color->getAllDataColors();
            $data['size'] = $size->getAllDataSizes();
            $data['brand'] = $brand->getAllDataBrands();
            $data['info'] = $info;
            // dd($info);

            $data['mes'] = $request->session()->get('editPd');


            $data['infoCat'] = json_decode($info['categories_id'], true);
            $data['infoColor'] = json_decode($info['colors_id'], true);
            $data['infoSize'] = json_decode($info['sizes_id'], true);
            $data['infoImages'] = json_decode($info['image_product'], true);
            return view('admin.product.edit-view',$data);
        }
        else {
            abort(404);
        }
    }

    public function handleEditProduct(StoreProductPost $request, Products $product)
    {
        // dd($request->all());
        $id = $request->id;
        $info = $product->getInfoDataProductById($id);
        // dd($info);
        if ($info) {
            $nameProduct = $request->nameProduct;
            $categories = $request->categories;
            $colors = $request->color;
            $sizes = $request->size;
            $brand = $request->brand;
            $price = $request->price;
            $qty = $request->qty;
            $sale = $request->sale;
            $description = $request->des;
            $arrNameFile = json_decode($info['image_product'], true); // nhung anh goc ban dau trong DB
            $arrNameFile2 = [];
            if ($request->hasFile('image')) {
                // lay thong tin cua file
                $files = $request->file('image');
                // dd($files);
                $extension = ['jpg','png','jpeg','gif'];
                foreach ($files as $key => $value) {
                    // lay ra dc ten file và đường dẫn lưu file trên máy người dùng
                    $nameFile = $value->getClientOriginalName();
                    // echo $nameFile;
                    // echo "<br>";
                    // lay ra duoi file (phan mo rong cua file)
                    $exFile = $value->getClientOriginalExtension();
                    // echo $exFile;
                    // echo "<br>";
                    if (in_array($exFile, $extension)) { // kiem tra duoi anh co hop le hay ko thi cho upload
                        // public_path() di vao thu muc public sau co vao file upload/images
                        $value->move(public_path().'/upload/images',$nameFile);
                        $arrNameFile2[] = $nameFile;
                    }
                }
            }

            $arrNameFile = ($arrNameFile2) ? $arrNameFile2 : $arrNameFile;

            if ($arrNameFile) {
                $dataUpdate = [
                    'name_product' => $nameProduct,
                    'categories_id' => json_encode($categories),
                    'colors_id' => json_encode($colors),
                    'sizes_id' => json_encode($sizes),
                    'brands_id' => $brand,
                    'price' => $price,
                    'qty' => $qty,
                    'description' => $description,
                    'image_product' => json_encode($arrNameFile),
                    'sale_off' => $sale,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $up = $product->updateDataById($dataUpdate, $id);
                if ($up) {
                    $request->session()->flash('editPd','Update Successful');
                    return redirect()->route('admin.products');
                }
                else {
                    $request->session()->flash('editPd','Can not Update');
                    return redirect()->route('admin.editProduct', ['id'=>$id]);
                }
            }
            else {
                $request->session()->flash('editPd','Can not upload image');
                return redirect()->route('admin.editProduct', ['id'=>$id]);
            }   
        }
        else {
            abort(404);
        }
    }
}
