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
        return new BranchResource(Branch::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        // foreach ($branch->materials() as $material) {
        //     return response()->json([
        //         $material,
        //     ]);
        // }
        // Branch::find($branch['id']);
        $branchMaterial = $branch->materials()->get();

        $material_all = Material::get();
        $material_branch = [];
        $material_left = new MaterialCollection($material_all);
        $index = 0;
        foreach ($branchMaterial as $material) {

            $material_branch[$index] = [
                'id' => $material['id'],
                'name' => $material['name'],
                'uom' => $material['uom'],
                'amount' => $material['pivot']['amount']
            ];

            // unset($material_left[array_search($material_left, array_keys([
            //     'id' => $material['id'],
            //     'name' => $material['name'],
            //     'uom' => $material['uom'],
            // ]))]);
            // // $material_left =array_filter($material_left, function($element) {
            // //     return ($element[0]['id'] != $material['id']);
            // //  });
            $index +=1;
        }
        
        // foreach($material_left as $material){
        //     unset($material_left[array_search($material, $material_left)]);
        // }

        Branch::find($branch['id']);
        return response()->json([
            'branchInfo' => new BranchResource($branch),
            'branchMaterial' => $material_branch,
            'allMaterial' => $material_left
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
        $branch->update($request->all());
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
        if($branch->orders()->get() != '[]' || $branch->staffs()->get() != '[]' || $branch->materials()->get() != '[]') {
            return response()->json([
                'msg' => 'Xoa chi nhanh that bai'
            ],400);
        }

        return $branch->delete();
    }
}
