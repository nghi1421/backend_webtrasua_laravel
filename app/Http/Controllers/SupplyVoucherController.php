<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyVoucher;
use App\Http\Resources\SupplyVoucherResource;
use App\Http\Resources\SupplyVoucherCollection;

class SupplyVoucherController extends Controller
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
            'data' => new SupplyVoucherCollection(SupplyVoucher::paginate(5)),
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplyVoucher = SupplyVoucher::find($id);
        if($supplyVoucher == null){
            return response()->json([
                'status' => 'fail',
                'msg' => "Không tìm thấy"
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'data' => new SupplyVoucherResource($supplyVoucher),
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
