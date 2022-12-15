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
use App\Models\Warehouse;
use App\Models\Material;

use Illuminate\Support\Facades\DB; 

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
        $data = $request->all();
        $new_material=  DB::transaction(function () use ($data){
             $new_material = Material::create($data);
             foreach(Branch::all() as $branch){
                $branch->materials()->attach($new_material['id'], ['amount' => 0]);
             }

             foreach(Warehouse::all() as $warehouse){
                $warehouse->materials()->attach($new_material['id'], ['amount' => 0]);
             }

             return $new_material;
        });

        if($new_material == null ){
            return response()->json([
                'status' => 'error',
                'msg' => "Thêm thất bại"
            ],422);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Thêm thành công",
                'newMateriarl' => $new_material
            ]);
        }
        
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
          $material->importVouchers()->get() != '[]'||
           $material->supplyVouchers()->get() != '[]'){
            return response()->json([
                'status' => 'error',
                'msg' => 'Không thể sửa nguyên liệu'
            ],422);
           }

           foreach($material->branches()->get() as $branch){
            if($branch['pivot']['amount'] != 0) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Chi nhánh đang có nguyên liệu không thể sửa.'
                ],422); 
            }
        }

        foreach($material->warehouses()->get() as $warehouse){
            if($warehouse['pivot']['amount'] != 0) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Nhà kho đang có nguyên liệu không thể sửa.'
                ],422); 
            }
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
            $material->importVouchers()->get() != '[]' ||
            $material->supplyVouchers()->get() != '[]'
          ){
            return response()->json([
                'status' => 'error',
                'msg' => 'Xóa nguyên liệu thất bại.'
            ],400);
          }


        
        foreach($material->branches()->get() as $branch){
            if($branch['pivot']['amount'] != 0) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Chi nhánh đang có nguyên liệu không thể xóa.'
                ],422); 
            }
        }
        foreach($material->warehouses()->get() as $warehouse){
            if($warehouse['pivot']['amount'] != 0) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Nhà kho đang có nguyên liệu không thể xóa.'
                ],422); 
            }
        }

        $result = DB::transaction(function () use ($material){
    
            foreach($material->branches()->get() as $branch){
                $material->branches()->detach($branch['id']);
            }
    
            foreach($material->warehouses()->get() as $warehouse){
                $material->warehouses()->detach($warehouse['id']);
            }
            
            if($material->delete()){
                return true;
            }
            return false;
        });
        if($result){
            return response()->json([
                'status' => 'error',
                'msg' => 'Xóa nguyên liệu thành công'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Xóa nguyên liệu thất bại'
            ],400);
        }

  
    }

    public function getAllMaterial(){
        return response()->json([
            'status' => 'success',
            'data' => new MaterialCollection(Material::get())
        ]);
    }
}
