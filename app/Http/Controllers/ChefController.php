<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DrinkDetail;
use App\Models\Drink;
use App\Models\Size;
use App\Models\Order;
use App\Models\Topping;

use App\Http\Resources\OrderResource;

class ChefController extends Controller
{
            //0 hủy
            //1 đã xác nhận
            //2 đang pha chế
            //3 đã pha chế
            //4 đã trả món
    public function getQueueOrdersConfirmed(){
        $orders = [];
        foreach(Order::where('status',1)->orderBy('created_at')->get() as $order_key => $order){
            $data = $order->drinkDetails()->get();
            $order_details = [];
            $toppingList = [];
            $i = 0;

            foreach($data as $order_detail){
                $order_details[$i]['drinkDetail'] = DrinkDetail::find($order_detail['id']);
                $order_details[$i]['drink_detail_id'] = $order_detail['id'];
                $order_details[$i]['drinkName'] = Drink::select('name')->where('id', $order_details[$i]['drinkDetail']['drink_id'])->first()['name'];
                $order_details[$i]['drinkSize'] = Size::select('name')->where('id', $order_details[$i]['drinkDetail']['size_id'])->first()['name'];
                $order_details[$i]['quantity'] = $order_detail['pivot']['quantity'];
                $order_details[$i]['price'] = $order_detail['pivot']['price'];    

                if($order_detail['pivot']['topping_list'] != null){
                $order_details[$i]['topping_list']  = json_decode($order_detail['pivot']['topping_list'], true);
                    foreach($order_details[$i]['topping_list'] as $key => $toppings){
                        foreach($toppings['topping'] as $key_topping => $topping_id){
                            $topping_info = Topping::select('id','name')->where('id',$topping_id)->first();
                            $topping_info['price'] = $toppings['price'][$key_topping];
                            $order_details[$i]['topping_list'][$key]['toppingInfo'][$key_topping] = $topping_info;
                        }
                        unset($order_details[$i]['topping_list'][$key]['price']);
                        unset($order_details[$i]['topping_list'][$key]['topping']);
                    }
                }else{
                    $order_details[$i]['topping_list'] == 'null';
                }
                unset($order_details[$i]['drinkDetail']);
                $i +=1;
            }

            $orders[$order_key]['order'] = $order;
            $orders[$order_key]['order']['orderDetail'] = $order_details;
        }
        
        return response()->json([
            'status' => 'success',
            'order' => $orders,
        ]);
    }

    public function getQueueOrdersPreparing(){
        $orders = [];
        foreach(Order::where('status',2)->orderBy('created_at')->get() as $order_key => $order){
            $data = $order->drinkDetails()->get();
            $order_details = [];
            $toppingList = [];
            $i = 0;

            foreach($data as $order_detail){
                $order_details[$i]['drinkDetail'] = DrinkDetail::find($order_detail['id']);
                $order_details[$i]['drink_detail_id'] = $order_detail['id'];
                $order_details[$i]['drinkName'] = Drink::select('name')->where('id', $order_details[$i]['drinkDetail']['drink_id'])->first()['name'];
                $order_details[$i]['drinkSize'] = Size::select('name')->where('id', $order_details[$i]['drinkDetail']['size_id'])->first()['name'];
                $order_details[$i]['quantity'] = $order_detail['pivot']['quantity'];
                $order_details[$i]['price'] = $order_detail['pivot']['price'];    

                if($order_detail['pivot']['topping_list'] != null){
                $order_details[$i]['topping_list']  = json_decode($order_detail['pivot']['topping_list'], true);
                    foreach($order_details[$i]['topping_list'] as $key => $toppings){
                        foreach($toppings['topping'] as $key_topping => $topping_id){
                            $topping_info = Topping::select('id','name')->where('id',$topping_id)->first();
                            $topping_info['price'] = $toppings['price'][$key_topping];
                            $order_details[$i]['topping_list'][$key]['toppingInfo'][$key_topping] = $topping_info;
                        }
                        unset($order_details[$i]['topping_list'][$key]['price']);
                        unset($order_details[$i]['topping_list'][$key]['topping']);
                    }
                }else{
                    $order_details[$i]['topping_list'] == 'null';
                }
                unset($order_details[$i]['drinkDetail']);
                $i +=1;
            }

            $orders[$order_key]['order'] = $order;
            $orders[$order_key]['order']['orderDetail'] = $order_details;
        }
        
        return response()->json([
            'status' => 'success',
            'order' => $orders,
        ]);
    }

    public function getAllOrderStatus(){
        $status = [];

        $status[0]['id'] = 0;
        $status[0]['name'] = 'Huỷ';
        $status[1]['id'] = 1;
        $status[1]['name'] = 'Đã xác nhận';
        $status[2]['id'] = 2;
        $status[2]['name'] = 'Đang pha chế';
        $status[3]['id'] = 3;
        $status[3]['name'] = 'Đã pha chế';
        $status[4]['id'] = 4;
        $status[4]['name'] = 'Đã đã món';

        return response()->json([
            'status' => 'success',
            'data' => $status,
        ]);
    }

    public function changePrepareStatus(Order $order){

    }
}
