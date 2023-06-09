<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        if($products->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $products,
            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'No products found',
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else {
            $product = Product::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
        }

        if($product) {
            return response()->json([
                'status'=>200,
                'message'=>'Product created successfully'
            ], 200);
        }else {
            return response()->json([
                'status'=>500,
                'message'=>'Oops, something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                'status'=>200,
                'product'=> $product,
            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'Item not found',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                'status'=>200,
                'product'=> $product,
            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'Item not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else {
            $product = Product::find($id);
        }

        if($product) {
            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
            return response()->json([
                'status'=>200,
                'message'=>'Product updated successfully'
            ], 200);
        }else {
            return response()->json([
                'status'=>404,
                'message'=>'Oops, no item found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Item deleted successfully',
            ], 200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'Item not found',
            ], 404);
        }
    }
}
