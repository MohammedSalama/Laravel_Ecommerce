<?php

namespace Ecommerce\Customer\Controllers;

use App\Http\Controllers\Controller;
use Ecommerce\Customer\Models\Customer;
use Ecommerce\Customer\Requests\StoreCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('pages.customer.index',['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        Customer::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'password' => Hash::make($request->password),
            ]);
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer=Customer::find($id);

        return view('pages.customer.edit',[
            'customer'=>$customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomerRequest $request, Customer $customer)
    {
        $customer=Customer::find($request->id);
        $customer->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer,Request $request)
    {
        $customer = Customer::find($request->id);

        if ($customer) {
            $customer->delete();
            return redirect()->back()->with('success', 'تم حذف العميل بنجاح.');
        } else {
            return redirect()->back()->with('error', 'خطأ في حذف العميل.');
        }
    }
}
