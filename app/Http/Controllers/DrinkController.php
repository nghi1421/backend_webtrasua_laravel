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
        $newInfo = DB::transaction(function () use ($request, $drink) {
            $data = $request->all();
            $topping_data = $data['toppings'];
            $drink->update($data);
            $value_recipe = [];
            foreach($data['recipe'] as $material){
                // $new_drink->materials()->attach($material['id'], ['amount' => $material['amount']]);
                // $recipe = $new_drink->materials()->where('material_id',$material['id'])->firstOr(function () {
                //     $new_drink->materials()->attach($material['id'], ['amount' => $material['amount']]);
                // });;
                // if($recipe->exists())
                // $new_drink->materials()->updateExistingPivot($material['id'], ['amount'=> $material['amount']], false);
                $value_recipe[$material['id']] = ['amount' => $material['amount']];
            }
            $drink->materials()->sync($value_recipe);
            foreach($data['size'] as $size){
                $drink->sizes()->updateExistingPivot($size['id'], ['active'=> $size['active']], false);
            }
            return ['drink' => $drink, 'toppingData' => $topping_data];
        });

        $drink_details = DrinkDetail::where('drink_id', $newInfo['drink']['id'])->get();
        
        foreach($drink_details as $drink_detail){
            foreach($drink_detail->orders()->get() as $order_details){
                
            }
        }

        // foreach(Order::get() as $order){
        //     foreach($order->drink_details()->get() as $drinkDetail){
        //         if(Drink::find(DrinkDetail::where('drink_detail_id', $drinkDetail['drink_detail_id']->first()['drink_id'])->exists()){

        //         }
        //     }
        //     if()
        // }
        // foreach($newInfo['toppingData'] as $topping){
        //     Order
        //     // $topping['drink_id'] = $newInfo['drink']['id'];
        //     // $topping->update()
        // }

        // if($new_drink )
        return response()->json([
            'status' => 'success',
            'msg' => "Sửa đồ uống thành công.",
            gettype($drink_details),
            $drink_details
            // 'drink' => new DrinkAdminResource(Drink::find($newInfo['drink']['id'])),
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
        //
    }

    public function getAllDrinks(){
        return new DrinkCollection(new DrinkResource(Drink::get()));
    }

    public function getAllSize(){
        return response()->json([
            'status' => 'success',
            'sizes' => Size::get(),
        ]);
    }
}
