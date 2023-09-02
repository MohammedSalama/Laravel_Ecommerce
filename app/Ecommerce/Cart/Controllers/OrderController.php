<?php

namespace Ecommerce\Cart\Controllers;

use App\Http\Controllers\Controller;
use Ecommerce\Cart\Models\Order;
use Ecommerce\Cart\Notifications\CartNotification;
use Ecommerce\Category\Models\Category;
use Ecommerce\Customer\Models\Customer;
use Ecommerce\Product\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() :View
    {
        $carts=Order::all();
        return view('pages.cart.index',[
            'carts'=>$carts,
            'categories'=>Category::all(),
            'products'=>Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carts=Order::all();
        return view('Home.product-detail',[
            'carts'=>$carts,
            'categories'=>Category::all(),
            'products'=>Product::all(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $products=Order::where('product_id',$product->id)->get();
        $cart=Order::create([
            'customer_id'=>auth('customer')->user()->id,
            'user_id'=>1,
            'category_id'=>$request->category_id,
            'product_id'=>$request->product_id,
            'amount'=>$request->amount,
            'quantity'=>$request->quantity,
            'size'=>$request->size,
            'color'=>$request->color
        ]);
        $users=Customer::where('id','=',auth('customer')->user()->id)->get();
        $create_order=auth('customer')->user()->name;

        Notification::send($users, new CartNotification($cart->id, $create_order,$cart->product_id));

        return redirect()->route('home')->with([
            'success' => 'Add To Cart'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \Ecommerce\Cart\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        return view('pages.cart.show',[
            'order'=>$order,
            'categories'=>Category::all(),
            'products'=>Product::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Ecommerce\Cart\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('pages.cart.edit',[
            'order'=>$order,
            'categories'=>Category::all(),
            'products'=>Product::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Ecommerce\Cart\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order=Order::find($request->id);
        $order->update([
            'amount'=>$request->amount,
            'quantity'=>$request->quantity,
            'size'=>$request->size,
            'color'=>$request->color
        ]);
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Ecommerce\Cart\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order,Request $request)
    {
        Order::destroy($request->id);
        $order->notifications()->delete();
        return redirect()->route('orders.index')->with([
            'success'=>'DELETE'
        ]);
    }
}
