<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $products = Product::get(); 

       if($products->isEmpty()){
        return response()->json([
            'message' => 'No products found',
            'data' => []
        ]);
       }

       return response()->json([
        'message' => 'Products retrieved successfully',
        'data' => $products
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product= [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ];

        if($request->hasFile('product_image')){
            $path = $request->file('product_image')->store('public/product_images');
            $product['product_image'] = $path;
        }

        $products = Product::create($product);
        $products->product_image = $products->product_image_url;
        return response()->json([
            'message' => 'Product created successfully',
            'data' => $products
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->product_image = $product->product_image_url;

        return response()->json([
            'message' => 'Product retrieved successfully',
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
{

    $productUpdate = [
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
    ];

    if ($request->hasFile('product_image')) {
        $path = $request->file('product_image')->store('public/product_images');

        $productUpdate['product_image'] = $path;
    }


    $product->update($productUpdate);

    $product->product_image = $product->product_image_url;

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $product
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->product_image){
            Storage::delete($product->product_image);
        }
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'data' => null
        ]);
    }
}
