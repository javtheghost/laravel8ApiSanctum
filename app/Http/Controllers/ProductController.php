<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //join con 2 tablas
        $products = Product::select(
            'products.*',
            //trame  de la tabla con su nombre y ponlo como propiedad provider
            'providers.name as provider',
            'categories.name as category'

        )
            ->join('providers', 'providers.id', '=', 'products.provider_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->paginate(10);


        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'description' => 'required|string|min:1|max:100',
            'price' => 'required',
            'stock' => 'required',
            'provider_id' => 'required|numeric',
            'category_id' => 'required|numeric',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
        //creando objeto
        $product = new Product($request->input());
        $product->save();
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully!'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(['status' => true, 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'description' => 'required|string|min:1|max:100',
            'price' => 'required|numeric|between:-9999999999.99,9999999999.99',
            'stock' => 'required|numeric',
            'provider_id' => 'required|numeric',
            'category_id' => 'required|numeric',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        //creando objeto
        $product->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => '!Category deleted successfully!'
        ]);
    }

    public function ProductByCategory()
    {
        $products = Product::select(DB::raw(
            'count(products.id) as count, categories.name'
        ))
            ->join('providers', 'providers.id', '=', 'pruduct.provider_id')
            ->join('categories', 'cartegories.id', '=', 'pruduct.category_id')
            ->groupBy('categories.name', 'providers.name')->get();


        return response()->json($products);
    }

    public function all()
    {
        $products = Product::select(
            'products.*',
            'providers.name as provider',
            'categories.name as category',
        )
        ->join('providers', 'providers.id', '=', 'products.povider_id')
        ->join('categories', 'cateogries.id', '=', 'products.category_id')
        ->get();
        return response()->json($products);
    }
}
