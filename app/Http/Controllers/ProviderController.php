<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\ProviderCollection;
use App\Models\Provider;
use App\Http\Requests\StoreProvider;
use App\Http\Requests\UpdateProvider;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProviderCollection(Provider::paginate(5));
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
    public function store(StoreProvider $request)
    {
        $new_provider = Provider::create($request->all());

        if($new_provider == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Them that bai'
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'newProvider' => $new_provider
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
        $provider = Provider::find($id);
        if($provider == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Khong tim thay'
            ], 422);
        }
        
        return response()->json([
            'status' => 'success',
            'provider' => $provider
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
    public function update(UpdateProvider $request, $id)
    {
        $provider = Provider::find($id);
        if($provider == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Khong tim thay'
            ], 422);
        }
        
        if($provider->update($request->all())){
            return response()->json([
                'status' => 'success',
                'msg' => 'Cap nhat thong tin thanh cong'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Cap nhat that bai'
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
        $provider = Provider::find($id);
        if($provider == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Khong tim thay'
            ], 422);
        }
        
        if($provider->importVouchers()->get() != '[]'){
            return response()->json([
                'status' => 'error',
                'msg' => 'Xóa thất bại'
            ],422);
        }

        if($provider->delete()){
            return response()->json([
                'status' => 'success',
                'msg' => 'Xóa thành công'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Xóa thất bại'
            ],422);
        }

    }

    public function getAllProviders(){
        return new ProviderCollection(Provider::all());
    }
}
