<?php

namespace Ecommerce\Category\Controllers;

use App\Http\Controllers\Controller;
use Ecommerce\Base\Traits\AttachFilesTrait;
use Ecommerce\Category\Models\Category;
use Ecommerce\Category\Requests\StoreCategoryRequest;
use Ecommerce\Product\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use AttachFilesTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('pages.category.index',[
            'categories'=>$categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'name'=>$request->name,
            'image'=>$request->file('image')->getClientOriginalName(),

        ]);
        $this->uploadFile($request,'image','upload_attachments');
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $products=Product::where('category_id',$id)->get();
        return view('Home.product-list',[

            'products'=>$products,
            'categories'=>Category::all(),
//            'showProduct'=>Product::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.category.edit',[
            'category'=>$category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $categories =Category::find($request->id);
        $categories->update([
            'name'=>$request->name
        ]);

        if($request->hasFile('image')){
            $this->deleteFile($category->image);

            $this->uploadFile($request,'image','upload_attachments');
            $image_new = $request->file('image')->getClientOriginalName();
            $categories->image = $categories->image !== $image_new ? $image_new : $categories->image;
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->deleteFile($request->file_name);
        $categories = Category::find($request->id);
        $categories->destroy($request->id);
        return redirect()->back();
    }
}
