<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Facades\DB; 


class CustomerController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/admin/customers",
     *      operationId="getProjectsList",
     *      tags={"Projects"},
     *      summary="Lấy danh sách khách hàng",
     *      description="Trả về danh sách khách hàng đã phân trang",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     * 
     * )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function index()
    {
        return new CustomerCollection(Customer::paginate(5));
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
     * @OA\Post(
     *      path="/projects",
     *      operationId="storeProject",
     *      tags={"Projects"},
     *      summary="Store new project",
     *      description="Returns project data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     * )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     * )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Invalid inputs"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(StoreCustomerRequest $request)
    {
        try{
            $new_cus = new CustomerResource(Customer::create($request->all()));
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Thêm khách hàng thành công',
            'newCustomer' => $new_cus,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
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
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try{
            $customer1 =  $customer->update($request->all());
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }

        if(!$customer1){
            return response()->json([
                'status' => 'error',
                'msg' => 'Sửa thông tin khách hàng thất bại',
            ],422);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Sửa khách hàng thành công',
            'customer' => new CustomerResource($customer),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if($customer->orders()->get() !='[]'){
            return response()->json([
                'status' => 'error',
                'msg' => "Khách hàng đã mua hàng không thể xóa."
            ],400);
        }

        DB::transaction(function () use ($customer){

            foreach($customer->addresses()->get() as $address){
                $address->delete();
            }
            $customer->delete();
        });
        
        return response()->json([
            'status' => 'success',
            'msg' => "Xóa thông tin khách hàng thành công."
        ]);
    }

    public function active($id){
        $customer = Customer::find($id);

        if($customer['active'] ==  true){
            return response()->json([
                'status' => 'error',
                'msg' => 'Khách hàng đang thiết lập hoạt động.',
            ],422);
        }

        $customer['active'] = true;
        
        try{
            $customer->update();
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
        $customer = Customer::find($id);

        if($customer['active'] == false){
            return response()->json([
                'status' => 'error',
                'msg' => 'Nhân viên đang thiết lập ngưng hoạt động.',
            ],422);
        }

        $customer['active'] = false;
        $customer->update();

        try{
            $customer->update();
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

    public function addNewAddress($id, Request $request){
    
        $customer = Customer::find($id);
        if($customer){
            $new_address = Address::create([
                'address' => $request->address,
                'customer_id' => int($id),
            ]);

            if($new_address){
                return response()->json([
                    'status' => 'success',
                    'msg' => "Thêm địa chỉ mới thành công!",
                    'newAddress' => $new_address,
                ]);
            }
            else{
                return response()->json([
                    'status' => 'fail',
                    'msg' => "Thêm địa chỉ mới thất bại!",
                ],422);
            }
        }else{
            return response()->json([
                'status' => 'fail',
                'msg' => "Khách hàng không tồn tại!",
            ],422);
        }
    }
}
