<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Models\Branch;
use App\Models\Staff;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Material;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MaterialCollection(Material::paginate(5));
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
    public function store(StoreMaterialRequest $request)
    {
        return new MaterialResource(Material::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return new MaterialResource($material);
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
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        if($material->drinks()->get() != '[]' ||
         $material->warehouses()->get() != '[]'||
          $material->branches()->get() != '[]'|| 
          $material->importVouchers()->get() != '[]'||
           $material->supplyVouchers()->get() != '[]'){
            return response()->json([
                'status' => 'error',
                'msg' => 'Không thể sửa nguyên liệu'
            ],422);
           }
        if($material->update($request->all())){
            return response()->json([
                'status' => 'success',
                'msg' => 'Cập nhật thông tin thành công'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Không thể sửa nguyên liệu'
            ],422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        if(
            $material->drinks()->get() != '[]' ||
            $material->branches()->get() != '[]' ||
            $material->importVouchers()->get() != '[]' ||
            $material->supplyVouchers()->get() != '[]' ||
            $material->warehouses()->get() != '[]'
          ){
            return response()->json([
                'status' => 'error',
                'msg' => 'Xoa nguyen lieu that bai'
            ],400);
          }

        return response()->json([
            'status' => 'error',
            'msg' => 'Xóa nguyên liệu thất bại'
        ],400);
        
    }

    public function getAllMaterial(){
        return response()->json([
            'status' => 'success',
            'data' => new MaterialCollection(Material::get())
        ]);
    }
}
