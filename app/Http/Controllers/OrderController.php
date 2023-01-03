<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Topping;
use App\Models\Drink;
use App\Models\DrinkDetail;
use App\Models\TypeOfDrink;
use App\Models\Size;

use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

use Illuminate\Support\Facades\DB; 

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->type == 'onl'){
            return new OrderCollection(Order::where('staff_id', NULL)->paginate(6));
        }
        else if($request->type == 'off'){
            return new OrderCollection(Order::where('staff_id','!=', NULL)->paginate(6));
        }
        else{
            return new OrderCollection(Order::paginate(6));
        }
        
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
    public function store(StoreOrder $request)
    {
        $data = $request->all();

        $result = DB::transaction(function () use ($data){

            $data['status'] = 1;
            // $data['created']
            $new_order = Order::create($data);

            foreach($data['order_detail'] as $key => $order_detail){
                $topping_list = [];

                $drink_detail= DrinkDetail::find($order_detail['drink_detail_id']);
                $drink_info = Drink::find($drink_detail['drink_id']);
                $drink_info['sales_on_day'] =  $order_detail['quantity'] + $drink_info['sales_on_day'];
                $drink_info->save();

                foreach($order_detail['topping_list'] as $key1 => $toppings){
                    $topping_list[$key1]['quan'] = $toppings['quan'];
                    $topping_list[$key1]['price'] = [];
                    foreach($toppings['topping'] as $key2 => $topping){
                        $topping_list[$key1]['price'][$key2] = Topping::select('price')->where('id', $topping['topping_id'])->first()->price + 0;
                        $topping_list[$key1]['topping'][$key2] = $topping['topping_id'];
                    }
                }

                $new_order->drinkDetails()->attach(
                    $order_detail['drink_detail_id'],
                    ['quantity' => $order_detail['quantity'],
                    'price' => $order_detail['price'],
                    'topping_list' => json_encode($topping_list)]
                );
            }
            return $new_order;
            
        });

        if($result == null){
            return response()->json([
                'status'   => 'error',
                'msg' => "Them that bai"
            ],422);
        }else{
            return response()->json([
                'status'   => 'success',
                'msg' => "Them thanh cong",
                'newOrder' => new OrderResource(Order::find($result['id'])),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
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

        return response()->json([
            'status' => 'success',
            'order' => new OrderResource($order),
            'orderDetail' => $order_details
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
    public function update(Request $request, $id)
    {
        //
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

    public function predictValues(Request $request){
        $data =$request->all();
        $dataReturn = [];
        
        $dataReturn['special'] = Drink::where('tod_id', $data['category_id'])->orderBy('sales_on_day','desc')->get();

        $dataReturn['normal'] = Drink::where('tod_id', '!=', $data['category_id'])->orderBy('sales_on_day','desc')->get();

        return response($dataReturn);
    }
}
