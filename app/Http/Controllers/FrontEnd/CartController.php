<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Products;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Categories;


class CartController extends BaseController
{
	public function addCart(Request $request, Products $pd)
	{
		if ($request->ajax()) {
			$id = $request->id;
			$qty = $request->qty;
			$color = $request->color;
			$size = $request->size;

			$infoPd = $pd->getInfoDataProductById($id);
			if ($infoPd && is_numeric($qty) && $color && $size) {
				// add san pham vao gio hang
				Cart::add([
					'id' => $id,
					'name' => $infoPd['name_product'],
					'qty' => $qty,
					'price' => $infoPd['price'],
					'options' => [
						'images' => json_decode($infoPd['image_product'],true),
						'color' => $color,
						'size' => $size,
					],
				]);
				echo "OK";
			}
			else {
				echo "FAIL";
			}
		}
	}

	public function showCart(Categories $cat)
	{
		$data = [];
		$data['cat'] = $this->getAllDataCatForUser($cat);
		// lay thong tin gio hang show ra ngoai layout view
		$data['cart'] = Cart::content();
		// dd($data['cart']);
		return view('frontend.cart.show_cart',$data);
	}

	public function deleteCart(Request $request)
	{
		$id = $request->id;
		Cart::remove($id);
		echo "OK";
	}

	public function updateCart(Request $request)
	{
		$id = $request->id;
		$qty = $request->qty;
		Cart::update($id, $qty);
		echo "OK";
	}
}
