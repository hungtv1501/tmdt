<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Payment;

class TMDT extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Payment $pay)
    {
        $infoPd = Cart::content()->toArray();
        $data = [];
        $data['infoPd'] = $infoPd;
        // $listOrder = $pay->getAllDataOrder();
        // $data['infoUser'] = $listOrder;
        // dd($dataInsert);
        return $this->view('mail.content',$data);
    }
}
