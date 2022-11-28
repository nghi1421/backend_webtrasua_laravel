<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;


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
        return new CustomerResource(Customer::create($request->all()));
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
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if($customer->orders()=='{}'){
            return response()->json([
                $customer->orders()
            ],400);
        }
        $customer->delete();
        return $customer->delete();
    }

    public function active($id){
        $customer = Customer::find($id);
        $customer['active'] = true;
        $customer->update();
    }

    public function inActive($id){
        $customer = Customer::find($id);
        $customer['active'] = false;
        $customer->update();
    }
}
