<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = Image::select('id','name','file','enable')->paging($request->perpage);

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
        $validated = $request->validate([
            'name'=>'required|max:100',
            'file'=>'required|image|max:2048',
            'enable'=>'nullable|boolean'
        ]);

        $validated['file'] = $request->file->store('public/images');

        return response()->json(Image::create($validated), 201);
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
            'file'=>'nullable|image|max:2048',
            'enable'=>'nullable|boolean'
        ]);
        $image = Image::find($id);
        
        if($request->hasFile('file')){
            Storage::delete($image->file);
            $validated['file'] =  $request->file->store('public/images');
        }else{
            $validated['file'] = $image->file;
        }

        $image->fill($validated);
        $image->save();

        return response()->json($image);
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
            $image = Image::find($id);
            Storage::delete($image->file);
            $image->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>'FAIL', 
                'message'=>$th->getMessage()
            ], 500);
        }

        return response()->noContent();
    }
}
