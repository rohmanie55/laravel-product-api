<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\ImageProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = Product::select('id','name','description','enable')
                ->with('images','categories')
                ->paging($request->perpage);

        return response()->json($datas);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:150',
            'description'=>'required',
            'enable'=>'nullable|boolean',
            'images'=>'nullable|array',
            'categories'=>'nullable|array'
        ]);

        $product = DB::transaction(function() use($request){
            $product = Product::create($request->only('name','description','enable'));
            $images  = [];
            $categories= [];

            foreach($request->images as $key=>$image_id){
                $images[]=[
                    'product_id'=>$product->id,
                    'image_id'=>$image_id,
                    'created_at'=>now()->toDateTimeString()
                ];
            }
            foreach($request->categories as $key=>$category_id){
                $categories[]=[
                    'product_id'=>$product->id,
                    'category_id'=>$category_id,
                    'created_at'=>now()->toDateTimeString()
                ];
            }

            ImageProduct::insert($images);
            CategoryProduct::insert($categories);
            return $product;
        });

        return response()->json($product, 201);
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
        $request->validate([
            'name'=>'required|max:150',
            'description'=>'required',
            'enable'=>'nullable|boolean',
            'images'=>'nullable|array',
            'categories'=>'nullable|array'
        ]);

        $product = DB::transaction(function() use($request,$id){
            $product = Product::find($id);
            $product->fill($request->only('name','description','enable'));
            $product->save();
            $images  = [];
            $categories= [];

            foreach($request->images as $key=>$image_id){
                $images[]=[
                    'product_id'=>$product->id,
                    'image_id'=>$image_id,
                    'created_at'=>now()->toDateTimeString()
                ];
            }
            foreach($request->categories as $key=>$category_id){
                $categories[]=[
                    'product_id'=>$product->id,
                    'category_id'=>$category_id,
                    'created_at'=>now()->toDateTimeString()
                ];
            }
            $product->images()->delete();
            $product->categories()->delete();

            ImageProduct::insert($images);
            CategoryProduct::insert($categories);
            return $product;
        });

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Product::find($id)->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>'FAIL', 
                'message'=>$th->getMessage()
            ], 500);
        }

        return response()->noContent();
    }
}
