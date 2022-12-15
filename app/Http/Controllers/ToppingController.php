<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topping;
use App\Models\DrinkDetail;
use App\Http\Requests\UpdateToppingRequest;
use App\Http\Requests\StoreToppingRequest;



class ToppingController extends Controller
{
    public function remove($id){
        $drink_id = Topping::select('drink_id')->where('id', $id)->first()['drink_id'];
        $drink_details = DrinkDetail::where('drink_id', $drink_id)->get();

        foreach($drink_details as $drink_detail){
            foreach($drink_detail->orders()->get() as $order_detail){
                $topping_list = json_decode($order_detail['pivot']['topping_list']);
                foreach($topping_list as $toppings){
                    if(in_array($id, $toppings->topping)){
                        return response()->json([
                            'status' => 'success',
                            'msg' => "Topping ở trong order không thể xóa topping.",
                        ],422);
                    }     
                }
            }
        }

        if(Topping::find($id)->delete()){
            return response()->json([
                'status' => 'success',
                'msg' => "Xóa topping thành công",
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'msg' => "Xóa topping thất bại",
            ],422);
        }
    }

    public function update(UpdateToppingRequest $request,$id){

        $data = $request->all();
        
        if(Topping::find($id)->update($data)){
            return response()->json([
                'status' => 'success',
                'msg' => "Cập nhật topping thành công",
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'msg' => "Cập nhật topping thất bại",
            ],422);
        }
    }

    public function create(StoreToppingRequest $request){
        $data = $request->all();
        $new_topping = Topping::create($data);
        if($new_topping){
            return response()->json([
                'status' => 'success',
                'msg' => "Thêm topping thành công",
                'newTopping' => $new_topping
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'msg' => "Thêm topping thất bại",
            ],422);
        }
    }
}
