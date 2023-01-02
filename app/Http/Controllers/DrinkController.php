<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DrinkAdminResource;
use App\Http\Resources\DrinkAdminCollection;
use App\Http\Requests\StoreDrinkRequest;
use App\Http\Requests\UpdateDrinkRequest;
use App\Http\Resources\DrinkCollection;
use App\Http\Resources\DrinkResource;

use App\Models\Drink;
use App\Models\DrinkDetail;
use App\Models\Size;
use App\Models\Topping;
use App\Models\TypeOfDrink;
use Illuminate\Support\Facades\DB; 
 

class DrinkController extends Controller
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
            'data' => Drink::paginate(5)
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
    public function store(StoreDrinkRequest $request)
    {
        $newInfo = DB::transaction(function () use ($request) {
            $data = $request->all();
            $topping_data = $data['toppings'];
            $new_drink = Drink::create($data);

            foreach($data['recipe'] as $material){
                $new_drink->materials()->attach($material['id'], ['amount' => $material['amount']]);
            }

            foreach($data['size'] as $size){
                $new_drink->sizes()->attach($size['id'], ['active' => $size['active']]);
            }

            return ['newDrink' => $new_drink, 'toppingData' => $topping_data];
        });

        foreach($newInfo['toppingData'] as $topping){
            $topping['drink_id'] = $newInfo['newDrink']['id'];
            Topping::create($topping);
        }

        // if($new_drink )
        return response()->json([
            'status' => 'success',
            'msg' => "Thêm đồ uống thành công.",
            'newDrink' => new DrinkAdminResource(Drink::find($newInfo['newDrink']['id'])),
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Drink $drink)
    {
        return response()->json([
            'status' => 'success',
            'drinkInfo' => new DrinkAdminResource($drink)
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
    public function update(Request $request,Drink $drink)
    {
        $drink = DB::transaction(function () use ($request, $drink) {
            $data = $request->all();
            $drink->update($data);
            $value_recipe = [];
            foreach($data['recipe'] as $material){
                $value_recipe[$material['id']] = ['amount' => $material['amount']];
            }
            $drink->materials()->sync($value_recipe);
            foreach($data['size'] as $size){
                $drink->sizes()->updateExistingPivot($size['id'], ['active'=> $size['active']], false);
            }

            return $drink;
        });

        if($drink){
            return response()->json([
                'status' => 'success',
                'msg' => "Sửa đồ uống thành công.",
            ]);
        }
         else{
            return response()->json([
                'status' => 'fail',
                'msg' => "Sửa đồ uống thất bại.",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drink $drink)
    {
        $drink_details  = DrinkDetail::where('drink_id', $drink['id'])->get();
        foreach($drink_details as $drink_detail){
            if($drink_detail->orders()->get() != '[]'){
                return response()->json([
                    'status' => 'fail',
                    'msg' => "Xóa đồ uống thất bại."
                ],422);
            }
        }
        
        $result = DB::transaction(function () use($drink){
            $drink->sizes()->sync([]);
            $drink->materials()->sync([]);
            $drink->toppings()->delete();
            return $drink->delete();
        });
        
        if($result){
            return response()->json([
                'status' => 'success',
                'msg' => 'Xóa đồ uống thành công',
            ]);
        }else{
            return response()->json([
                'status' => 'erro',
                'msg' => 'Xóa đồ uống thất bại',
            ]);
        }
    }
       
    public function getAllDrinks(Request $request){
        $data_request = $request->all();

        if ($data_request != []) {
            $search = $data_request['search'];
            $search = str_replace("-", ' ', $search);
            $data = Drink::where('name','like', "%".$search."%")->get();
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        }
        return new DrinkCollection(Drink::get());
    }


    public function getDrinkByTypeOfDrink($tod_id){
        return new DrinkCollection(Drink::where('tod_id',$tod_id)->get());
    }

    public function getAllSize(){
        return response()->json([
            'status' => 'success',
            'sizes' => Size::get(),
        ]);
    }

    public function getAllTypeOfDrink(){
        return response()->json([
            'status' => 'success',
            'sizes' => TypeOfDrink::get(),
        ]);
    }

}
