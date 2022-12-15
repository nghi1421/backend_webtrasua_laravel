<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyVoucher;
use App\Http\Resources\SupplyVoucherResource;
use App\Http\Resources\SupplyVoucherCollection;
use App\Http\Requests\StoreSupplyVoucher;
use App\Http\Requests\UpdateSupplyVoucher;

use Illuminate\Support\Facades\DB; 

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
    public function store(StoreSupplyVoucher $request)
    {
        $newInfo = DB::transaction(function () use ($request) {
            $data = $request->all();
            $new_supply_voucher = SupplyVoucher::create($data);
            foreach($data['supply_details'] as $material){
                $new_supply_voucher->materials()->attach($material['material_id'], ['amount' => $material['amount']]);
            }
            return $new_supply_voucher;
        });

        if($newInfo == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Thêm phiếu cung cấp thất bại.",
            ],422);
        }else{
            return response()->json([
                'status' => 'success',
                'msg' => "Thêm phiếu cung cấp thành công.",
                'newSupplyVoucher' => $newInfo
            ]);
        }
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
    public function update(UpdateSupplyVoucher $request, $id)
    {
        $supply_voucher = SupplyVoucher::find($id);
        if($supply_voucher == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy phiếu cung cấp nguyên liệu.",
            ],422); 
        }

        if($supply_voucher['status'] == 0){
            return response()->json([
                'status' => 'fail',
                'msg' => "Phiếu cung cấp nguyên leieuj đã hủy không thể sửa.",
            ],422);
        }
        elseif($supply_voucher['status'] == 4){
            return response()->json([
                'status' => 'fail',
                'msg' => "Phiếu cung cấp nguyên liệu đã hoàn tất không thể sửa.",
            ],422);
        }
        else{
            $info = DB::transaction(function () use ($request, $supply_voucher) {
                $data = $request->all();
                $supply_detail = [];
                $supply_voucher->update($data);
                foreach($data['supply_details'] as $key => $material){
                    $supply_detail[$material['material_id']] = ['amount' => $material['amount']];
                }
                $supply_voucher->materials()->sync($supply_detail);
                return $supply_voucher;
            });

            if($info == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => "Sửa phiếu cung cấp thất bại.",
                ],422);
            }else{
                return response()->json([
                    'status' => 'success',
                    'msg' => "Sửa phiếu cung cấp thành công.",
                ]);
            }    
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
        $supply_voucher = SupplyVoucher::find($id);
        if($supply_voucher == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy phiếu cung cấp.",
            ],422); 
        }

        if($supply_voucher['status'] == 0 ){

            if($supply_voucher->materials()->get() == "[]"){
                return response()->json([
                    'status' => 'fail',
                    'msg' => "Phiếu cung cấp không thể xóa.",
                ],422); 
            }
            if($supply_voucher->delete())
                return response()->json([
                    'status' => 'success',
                    'msg' => "Xóa thông tin phiếu cung cấp thành công."
                ]);
        }else{
            return response()->json([
                'status' => 'fail',
                'msg' => "Phiếu cung cấp đã xác nhận không thể xóa.",
            ],422); 
        }

    }
}
