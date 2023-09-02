<?php

namespace Ecommerce\Product\Controllers;

use App\Http\Controllers\Controller;
use Ecommerce\Base\Traits\AttachFilesTrait;
use Ecommerce\Category\Models\Category;
use Ecommerce\Customer\Models\Customer;
use Ecommerce\Product\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AttachFilesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $products = Product::paginate(5);
        return view('pages.product.index', [
            'products' => $products,
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.product.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->file('image')->getClientOriginalName(),
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'category_id' => $request->category_id
        ]);
        $this->uploadFile($request, 'image', 'upload_attachments');

        session()->flash('success', 'The Product Add success');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \Ecommerce\Product\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        return view('Home.product-detail', [
            'product' => $product,
            'categories' => $categories,
            'products' => Product::all(),
//            'carts'=>Order::all(),
            'customer' => Customer::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Ecommerce\Product\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('pages.product.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Ecommerce\Product\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::find($request->id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
        ]);
        if ($request->hasFile('image')) {
            $this->deleteFile($product->image);

            $this->uploadFile($request, 'image', 'upload_attachments');
            $image_new = $request->file('image')->getClientOriginalName();
            $product->image = $product->image !== $image_new ? $image_new : $product->image;
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Ecommerce\Product\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->deleteFile($request->file_name);
        $product = Product::find($request->id);
        $product->destroy($request->id);
        return redirect()->back()->with([
            'success' => 'Product DELETE'
        ]);
    }
}
