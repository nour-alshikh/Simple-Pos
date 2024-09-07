<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        // dd($request->search);
        $products = Product::when($request->search, function ($query) use ($request) {

            $query->where('name', 'like', "%{$request->search}%");
        })->when($request->category_id, function ($que) use ($request) {
            $que->where('category_id', $request->category_id);
        })->orderBy("created_at", "desc")->paginate(10);

        return view("dashboard.products.index", compact('categories', "products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("dashboard.products.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'category_id' => 'required',
            'image' => 'image|nullable',
            'purchase_price' => 'required',
            'sell_price' => 'required',
            'stock' => 'required',
        ]);

        $request_data = $request->all();

        if ($request->image) {
            // create new image instance
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->image); // 800 x 600

            // scale down to fixed width
            $image->scaleDown(width: 200)->save(public_path('uploads/product_images/' . $request->image->hashName())); // 300 x 200
            $request_data['image'] = $request->image->hashName();
        }


        $product = Product::create($request_data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view("dashboard.products.edit", compact("categories", 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => 'required',
            'category_id' => 'required',
            'image' => 'image|nullable',
            'purchase_price' => 'required',
            'sell_price' => 'required',
            'stock' => 'required',
        ]);

        $request_data = $request->all();

        if ($request->image) {
            if ($product->image != "default.png") {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }
            // create new image instance
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->image); // 800 x 600

            // scale down to fixed width
            $image->scaleDown(width: 200)->save(public_path('uploads/product_images/' . $request->image->hashName())); // 300 x 200
            $request_data['image'] = $request->image->hashName();
        }


        $product = $product->update($request_data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image != "default.png") {
            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
        }

        $product->delete();

        return redirect()->back();
    }
}
