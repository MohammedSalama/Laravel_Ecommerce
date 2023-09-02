<?php

namespace Ecommerce\Payment;

use App\Http\Controllers\Controller;
use Ecommerce\Cart\Models\Order;
use Ecommerce\Customer\Models\Customer;
use Illuminate\Support\Facades\Request;
use Stripe\Charge;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totel=Order::count();
        return view('Home.payment.stripe',[
            'products'=>Product::all(),
            'orders'=>Order::all(),
            'totel'=>$totel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $customer =Customer::create([
            'email'=>auth('customer')->user()->email,
            'name'=>auth()->user()->name,
            // 'source' => $request->stripeToken
        ]);

        Charge::create([
            'amount'=>$request->amount,
            'description'=>'this payment Stripe',
            'customer'=>$customer->id,
            'shipping'=>[
                // 'address'=>Costumer_address::all(),
                // 'name'=>auth('costomer')->user()->id,
            ]
        ]);

        return redirect()->back()->with([
            'success'=>'Payment successful!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
