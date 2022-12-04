<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchCollection;
use App\Http\Resources\BranchResource;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Models\Branch;
use App\Models\Staff;
use App\Models\Order;
use App\Models\Material;
use Illuminate\Support\Facades\DB; 


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        return new BranchCollection(Branch::paginate(5));
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
    public function store(StoreBranchRequest $request)
    {   
        $new_branch = DB::transaction(function () use ($request) {
            $all_data = $request->all();
            $new_branch = Branch::create($all_data);
            foreach($all_data['list_material'] as $material){
                $new_branch->materials()->attach($material['id'], ['amount'=> $material['amount']]);
            }
            return $new_branch;
        });

        $new_branch['materialsOfBranch'] = $this->getMaterialBranch($new_branch);
        return response()->json([
            'status' => "success",
            'msg' => "Thêm chi nhánh thành công.",
            "newBranchInfo" => $new_branch
        ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {

        $branch['materialsOfBranch'] = $this->getMaterialBranch($branch);


        return response()->json([
            'status' => 'success',
            'branchInfo' => $branch,
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
    public function update(UpdateBranchRequest $request,Branch $branch)
    {
        $branchInfo = DB::transaction(function () use ($request, $branch) {
            $all_data = $request->all();
            $branch->update($all_data);

            foreach($all_data['list_material'] as $material){
                $branch->materials()->updateExistingPivot($material['id'], ['amount'=> $material['amount']], false);
            }
            return $branch;
        });

        $branchInfo['materialsOfBranch'] = $this->getMaterialBranch($branchInfo);
        return response()->json([
            'status' => "success",
            'msg' => "Sửa thông tin chi nhánh thành công.",
            "branchInfo" => $branchInfo
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
        $branch =  Branch::find($id);
        if($branch->orders()->get() != '[]' || $branch->staffs()->get() != '[]') {
            return response()->json([
                'status' => 'error',
                'msg' => 'Chi nhánh đã có nhân viên. Xóa chi nhánh thất bại.'
            ],400);
        }

        foreach($branch->materials()->get() as $material) {
            if($material['pivot']['amount']!=0){
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Chi nhánh đang có nguyên liệu tồn. Xóa chi nhánh thất bại.'
                ],401 );
            }
        }

        $branchInfo = DB::transaction(function () use ($branch) {
            foreach($branch->materials()->get() as $material){
                $branch->materials()->detach($material['id']);
            }
            $branch->delete();
            return $branch;
        });

        return response()->json([
            'status' => 'success',
            'msg' => "Xóa thông tin chi nhánh thành công."
        ]);
    }

    public function active($id){
        $branch = Branch::find($id);

        if($branch['active'] ==  true){
            return response()->json([
                'status' => 'error',
                'msg' => 'Chi nhánh đang thiết lập hoạt động.',
            ],422);
        }

        $branch['active'] = true;
        
        try{
            $branch->update();
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
        $branch = Branch::find($id);

        if($branch['active'] == false){
            return response()->json([
                'status' => 'error',
                'msg' => 'Chi nhánh đang thiết lập ngưng hoạt động.',
            ],422);
        }

        $branch['active'] = false;
        $branch->update();

        try{
            $branch->update();
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


    public function getMaterialBranch($branch){
        $branchMaterial = $branch->materials()->get();
        $material_branch = [];
        $index = 0;
        foreach ($branchMaterial as $material) {
            $material_branch[$index] = [
                'id' => $material['id'],
                'name' => $material['name'],
                'uom' => $material['uom'],
                'amount' => $material['pivot']['amount']
            ];
            $index +=1;
        }
        return $material_branch;
    }
}
