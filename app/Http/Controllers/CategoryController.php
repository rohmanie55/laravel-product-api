<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = Category::select('id','name','enable');

        if($request->perpage){
            $datas->paging($request->perpage);
        }
        return response()->json([
            'total'=>$datas->count(),
            'data'=>$datas->get()
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
        $validated = $request->validate([
            'name'=>'required|max:100',
            'enable'=>'nullable|boolean'
        ]);

        return response()->json(Category::create($validated), 201);
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
        $validated = $request->validate([
            'name'=>'required|max:100',
            'enable'=>'nullable|boolean'
        ]);
        $category = Category::find($id);
        $category->fill($validated);
        $category->save();

        return response()->json($category);
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
            Category::find($id)->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>'FAIL', 
                'message'=>$th->getMessage()
            ], 500);
        }

        return response()->noContent();
    }
}
