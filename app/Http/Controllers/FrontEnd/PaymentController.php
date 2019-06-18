<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Categories;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\PaymentOrderPost as Pay;
use App\Models\Payment;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
use Mail;
use App\Mail\TMDT;

class PaymentController extends BaseController
{
    public function payment(Categories $cat)
	{
		$data = [];
		$data['cat'] = $this->getAllDataCatForUser($cat);
		$data['cart'] = Cart::content();
		return view('frontend.payment.index',$data);
	}

	public function payOrder(Pay $request, Payment $payment)
	{
		$fullname = $request->username;
		$email = $request->email;
		$sdt = $request->sdt;
		$address = $request->address;
		$note = $request->note;

		$infoPd = Cart::content()->toArray();
		$dataInsert = [
			'fullname' => $fullname,
			'email' => $email,
			'phone' => $sdt,
			'address' => $address,
			'note' => $note,
			'infoPd' => json_encode($infoPd),
			'status' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => null, 
		];

		if ($infoPd) {
			$insert = $payment->insertOrder($dataInsert);
			if ($insert) {
				// xoa gio hang di
				$this->sendMail($email);
				Cart::destroy();
				return redirect()->route('fr.payment',['state' => 'success']);
			}
			else {
				return redirect()->route('fr.payment',['state' => 'error']);
			}
		}
		else {
			return redirect()->route('fr.payment',['state' => 'fail']);
		}
	}

	public function sendMail($email)
	{
		Mail::to($email)->send(new TMDT);
	}

	public function transportationMethod(Categories $cat)
	{
		$data = [];
		$data['cat'] = $this->getAllDataCatForUser($cat);
		return view('frontend.payment.transportation_method',$data);
	}
}
