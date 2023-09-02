<?php

namespace Ecommerce\Payment;

use App\Http\Controllers\Controller;
use Ecommerce\Cart\Models\Order;
use Ecommerce\Category\Models\Category;
use Ecommerce\Product\Models\Product;

class PaymentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('Home.paypal',[
            'categories'=>Category::all(),
            'products'=>Product::all(),
            'orders'=>Order::all(),
        ]);
    }
}
