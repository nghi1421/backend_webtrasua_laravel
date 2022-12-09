<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Drink;
use App\Http\Requests\StoreSize;
use App\Http\Requests\UpdateSize;
use Illuminate\Support\Facades\DB; 


class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Size::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSize $request)
    {
        $result = DB::transaction(function () use ($request){
                    $new_size = Size::create($request->all());
                    $drinks = Drink::get();
                    foreach($drinks as $drink){
                        $drink->sizes()->attach($new_size['id']);
                    }

                    return $new_size;
                });
        
        return response()->json([
            'status'=> $new_size != null ? 'success' : 'error',
            'new_size' => $new_size
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $size = Size::find($id);
        if($size == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Size not found',
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'size' => $size,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSize $request, $id)
    {
        $size = Size::find($id);
    
        if($size == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Size not found',
            ],422);
        }
        if($size->update($request->all())){
            return response()->json([
                'status' => 'success',
                'size' => $size,
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Sua that bai',
            ],422);
        }
            

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Size::find($id);
        if($size == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Size not found',
            ],422);
        }

        try {
            $result = DB::transaction(function () use ($size){
                $drinks = Drink::get();
                foreach($drinks as $drink){
                    $drink->sizes()->detach($size['id']);
                }
      
                return $size->delete();
            });
            if($result){
                return response()->json([
                    'status' => 'success',
                    'msg' => "Xóa thành công."
                ]);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'msg' => "Xóa thất bại."
                ],422);
            }
          

        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => "Xóa thất bại."
            ],422);
        }

    }
}
