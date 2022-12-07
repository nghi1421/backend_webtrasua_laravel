<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\WarehouseCollection;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB; 

// use App\Models\Staff;
// use App\Models\Order;
// use App\Models\Recipe;
// use App\Models\Material;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new WarehouseCollection(Warehouse::paginate(5));
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
    public function store(StoreWarehouseRequest $request)
    {
        $new_warehouse = DB::transaction(function () use ($request) {
            $all_data = $request->all();
            $new_warehouse = Warehouse::create($all_data);
            foreach($all_data['list_material'] as $material){
                $new_warehouse->materials()->attach($material['id'], ['amount'=> $material['amount']]);
            }
            return $new_warehouse;
        });

        $new_warehouse['materialsOfBranch'] = $this->getMaterialWarehouse($new_warehouse);
        return response()->json([
            'status' => "success",
            'msg' => "Thêm nhà kho thành công.",
            "newWarehouseInfo" => $new_warehouse
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        $warehouse['materialsOfWarehouse'] = $this->getMaterialWarehouse($warehouse);

        return response()->json([
            'status' => 'success',
            'warehouseInfo' => $warehouse,
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
    public function update(UpdateWarehouseRequest $request,Warehouse $warehouse)
    {
        $warehouseInfo = DB::transaction(function () use ($request, $warehouse) {
            $all_data = $request->all();
            $warehouse->update($all_data);

            foreach($all_data['list_material'] as $material){
                $warehouse->materials()->updateExistingPivot($material['id'], ['amount'=> $material['amount']], false);
            }
            return $warehouse;
        });

        $warehouseInfo['materialsOfwarehouse'] = $this->getMaterialWarehouse($warehouseInfo);
        return response()->json([
            'status' => "success",
            'msg' => "Sửa thông tin kho thành công.",
            "warehouseInfo" => $warehouseInfo
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
        $warehouse =  Warehouse::find($id);
        if($warehouse->importVouchers()->get() != '[]' || $warehouse->supplyVouchers()->get() != '[]') {
            return response()->json([
                'status' => 'error',
                'msg' => 'Xóa thông tin nhà kho thất bại thất bại.'
            ],400);
        }

        foreach($warehouse->materials()->get() as $material) {
            if($material['pivot']['amount']!=0){
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Kho đang có nguyên liệu tồn. Xóa nhà kho thất bại.'
                ],401 );
            }
        }

        $warehouseInfo = DB::transaction(function () use ($warehouse) {
            foreach($warehouse->materials()->get() as $material){
                $warehouse->materials()->detach($material['id']);
            }
            $warehouse->delete();
            return $warehouse;
        });

        return response()->json([
            'status' => 'success',
            'msg' => "Xóa thông tin nhà kho thành công."
        ]); 
    }

    public function active($id){
        $warehouse = Warehouse::find($id);

        if($warehouse['active'] ==  true){
            return response()->json([
                'status' => 'error',
                'msg' => 'Chi nhánh đang thiết lập hoạt động.',
            ],422);
        }

        $warehouse['active'] = true;
        
        try{
            $warehouse->update();
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Thiết lập hoạt động thành công.',
        ]);
    }

    public function inActive($id){

        $warehouse = Warehouse::find($id);
        if($warehouse['active'] == false){
            return response()->json([
                'status' => 'error',
                'msg' => 'Chi nhánh đang thiết lập ngưng hoạt động.',
            ],422);
        }

        $warehouse['active'] = false;
        $warehouse->update();

        try{
            $warehouse->update();
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Thiết lập ngừng hoạt động thành công.',
        ]);
    }


    public function getMaterialWarehouse($warehouse){
        $warehouseMaterial = $warehouse->materials()->get();
        $material_warehouse = [];
        $index = 0;
        foreach ($warehouseMaterial as $material) {
            $material_warehouse[$index] = [
                'id' => $material['id'],
                'name' => $material['name'],
                'uom' => $material['uom'],
                'amount' => $material['pivot']['amount']
            ];
            $index +=1;
        }
        return $material_warehouse;
    }
}
