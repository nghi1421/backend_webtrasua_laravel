<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportVoucher;
use App\Http\Resources\ImportVoucherResource;
use App\Http\Resources\ImportVoucherCollection;
use App\Http\Requests\StoreImportVoucher;
use App\Http\Requests\UpdateImportVoucher;

use Illuminate\Support\Facades\DB; 

class ImportVoucherController extends Controller
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
            'data' => new ImportVoucherCollection(ImportVoucher::paginate(5)),
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
    public function store(StoreImportVoucher $request)
    {
        $newInfo = DB::transaction(function () use ($request) {
            $data = $request->all();
            $new_import_voucher = ImportVoucher::create($data);
            foreach($data['import_details'] as $material){
                $new_import_voucher->materials()->attach($material['material_id'], ['amount' => $material['amount']]);
            }
            return $new_import_voucher;
        });

        if($newInfo == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Thêm phiếu nhập hàng thất bại.",
            ],422);
        }else{
            return response()->json([
                'status' => 'success',
                'msg' => "Thêm phiếu nhập hàng thành công.",
                'newImportVoucher' => $newInfo
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
        $importVouher = ImportVoucher::find($id);
        if($importVouher == null){
            return response()->json([
                'status' => 'fail',
                'msg' => "Không tìm thấy"
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'data' => new ImportVoucherResource($importVouher),
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
    public function update(UpdateImportVoucher $request, $id)
    {
        $import_voucher = ImportVoucher::find($id);
        if($import_voucher == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy phiếu nhập.",
            ],422); 
        }

        if($import_voucher['status'] == 0){
            return response()->json([
                'status' => 'fail',
                'msg' => "Phiếu nhập hàng đã hủy không thể sửa.",
            ],422);
        }
        elseif($import_voucher['status'] == 4){
            return response()->json([
                'status' => 'fail',
                'msg' => "Phiếu nhập hàng đã hoàn tất không thể sửa.",
            ],422);
        }
        else{
            $info = DB::transaction(function () use ($request, $import_voucher) {
                $data = $request->all();
                $import_detail = [];
                $import_voucher->update($data);
                foreach($data['import_details'] as $key => $material){
                    $import_detail[$material['material_id']] = ['amount' => $material['amount']];
                }
                $import_voucher->materials()->sync($import_detail);
                return $import_voucher;
            });
            if($info == null){
                return response()->json([
                    'status' => 'error',
                    'msg' => "Sửa phiếu nhập hàng thất bại.",
                ],422);
            }else{
                return response()->json([
                    'status' => 'success',
                    'msg' => "Sửa phiếu nhập hàng thành công.",
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
        $imoprt_voucher = ImportVoucher::find($id);
        if($imoprt_voucher == null){
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy phiếu nhập.",
            ],422); 
        }

        if($imoprt_voucher['status'] == 0 ){

            if($imoprt_voucher->materials()->get() == "[]"){
                return response()->json([
                    'status' => 'fail',
                    'msg' => "Phiếu nhập hàng không thể xóa.",
                ],422); 
            }
            if($imoprt_voucher->delete())
                return response()->json([
                    'status' => 'success',
                    'msg' => "Xóa thông tin phiếu nhập hàng thành công."
                ]);
        }else{
            return response()->json([
                'status' => 'fail',
                'msg' => "Phiếu nhập hàng đã xác nhận không thể xóa.",
            ],422); 
        }
    }
}
