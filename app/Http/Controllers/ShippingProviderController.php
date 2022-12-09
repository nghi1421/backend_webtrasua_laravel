<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreShippingProvider;
use App\Http\Requests\UpdateShippingProvider;


use App\Models\ShippingProvider;

class ShippingProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => "success",
            'data' => ShippingProvider::get(),
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShippingProvider $request)
    {
        $new_shippingprovider = ShippingProvider::create($request->all());

        if($new_shippingprovider == null){
            return response()->json([
                'status' => 'error',
                'msg' => 'Thêm thông tin đối tác vận chuyển thất bại'
            ],422);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Thêm thông tin đối tác vận chuyển thành công',
            'newShippingProvider' => $new_shippingprovider,
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
        $shipping_provider = ShippingProvider::find($id);
        if($shipping_provider == null){
            return response()->json([
                'status' => 'fail',
                'msg' => 'Đối tác vận chuyển không tồn tại.',
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'data' => $shipping_provider,
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
    public function update(UpdateShippingProvider $request, $id)
    {
        $shipping_provider = ShippingProvider::find($id);
        if($shipping_provider == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Đối tác vận chuyển không tồn tại."
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'msg' => "Sửa thông tin thành công",
            'shippingProvider' => $shipping_provider->update($request->all()),
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping_provider = ShippingProvider::find($id);
        if($shipping_provider == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Đối tác vận chuyển không tồn tại."
            ],422);
        }
        
        if($shipping_provider->orders()->get() != '[]'){
            return response()->json([
                'status' => 'error',
                'msg' => "Xóa thất bại."
            ],422);
        }

        try {
            $shipping_provider->delete();
            return response()->json([
                'status' => 'success',
                'msg' => "Xóa thành công."
            ]);

        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => "Xóa thất bại."
            ],422);
        }

    }
}
