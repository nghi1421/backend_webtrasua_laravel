<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StaffResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\StaffAuthResource;
use App\Http\Requests\StoreNewCustomerRequest;
use App\Models\User;

use App\Models\Staff;
use App\Models\Customer;
use App\Models\Role;

class AuthController extends Controller
{
    /**
     * Đăng kí tài khoản cho nhân viên
     * @OA\Post (
     *     path="/api/admin/register",
     *     tags={"API Authentication"},
     * 
     * *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 @OA\Property(
        *                      type="object",
        *                      @OA\Property(
        *                          property="username",
        *                          type="string"
        *                      ),
        *                      @OA\Property(
        *                          property="password",
        *                          type="string"
        *                      ),
        *                      @OA\Property(
        *                          property="password_confirmation",
        *                          type="string"
        *                      ),
        *                      @OA\Property(
        *                          property="role_id",
        *                          type="number"
        *                      ),
        *                      @OA\Property(
        *                          property="staff_id",
        *                          type="number"
        *                      )
        *                 ),
        *                 example={
        *                     "username":"nghi1421",
        *                     "password":"123123123",
        *                     "password_confirmation": "123123123",
        *                     "role_id": 1,
        *                     "staff_id": 1,
        *                }
        *             )
        *         )
        *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     * *             @OA\Property(
     *                 type="object",
     *                 property="role",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="Quản lí"),
     *                 
     *              ),
     *              @OA\Property(
     *                 type="object",
     *                 property="information",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="Nguyen Van A"),
     *                  @OA\Property(property="gender", type="number", example=1),
     *                  @OA\Property(property="phone_number", type="string", example="0123123123"),
     *                  @OA\Property(property="address", type="string", example="abc"),
     *                  @OA\Property(property="dob", type="string", example="2001-04-01"),
     *                  @OA\Property(property="hometown", type="string", example="abc"),
     *                  @OA\Property(property="active", type="number", example=1),
     *                  @OA\Property(property="id_login", type="number", example=1),
     *                  @OA\Property(property="branch_id", type="number", example=1),
     *                  @OA\Property(property="position_id", type="number", example=1),
     *                  @OA\Property(property="email", type="string", example="abc@gmail.com"),
     *                 
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 property="token",
     *                 example="123123123123123123123"
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 property="msg",
     *                 example="Dang ki thanh cong"
     *             )
     *         )
     *     ),
     *  @OA\Response(
     *         response=400,
     *         description="fail",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="string",
     *                 property="msg",
     *                 example="Invalid inputs"
     *             )
     *         )
     *     )
     * )
     */
    public function register(StoreUserRequest $request){
        $data = $request->all();
        
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $token = $user->createToken('main')->plainTextToken;

        $staff_inf = Staff::find($data['staff_id']);

        $staff_inf['id_login'] = $user['id'];
        $staff_inf->save();

        return response()->json([
            'staff_information' => new StaffResource($staff_inf),
            'token' => $token,
            'newUser' => $user
        ],200);
    }

    /**
     * Đăng nhập tài khoản cho nhân viên
     * @OA\Post (
     *     path="/api/admin/login",
     *     tags={"API Authentication"},
   
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 @OA\Property(
        *                      type="object",
        *                      @OA\Property(
        *                          property="username",
        *                          type="string"
        *                      ),
        *                      @OA\Property(
        *                          property="password",
        *                          type="string"
        *                      ),
        *                      @OA\Property(
        *                          property="remember",
        *                          type="boolean"
        *                      )
        *                 ),
        *                 example={
        *                     "username":"nghi1421",
        *                     "password":"123123123",
        *                     "remember": true,
        *                }
        *             )
        *         )
        *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     * *             @OA\Property(
     *                 type="object",
     *                 property="role",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="Quản lí"),
     *                 
     *              ),
     *              @OA\Property(
     *                 type="object",
     *                 property="information",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="Nguyen Van A"),
     *                  @OA\Property(property="gender", type="number", example=1),
     *                  @OA\Property(property="phone_number", type="string", example="0123123123"),
     *                  @OA\Property(property="address", type="string", example="abc"),
     *                  @OA\Property(property="dob", type="string", example="2001-04-01"),
     *                  @OA\Property(property="hometown", type="string", example="abc"),
     *                  @OA\Property(property="active", type="number", example=1),
     *                  @OA\Property(property="id_login", type="number", example=1),
     *                  @OA\Property(property="branch_id", type="number", example=1),
     *                  @OA\Property(property="position_id", type="number", example=1),
     *                  @OA\Property(property="email", type="string", example="abc@gmail.com"),
     *                 
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 property="token",
     *                 example="123123123123123123123"
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 property="msg",
     *                 example="Dang ki thanh cong"
     *             )
     *         )
     *     ),
     *  @OA\Response(
     *         response=400,
     *         description="fail",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="string",
     *                 property="msg",
     *                 example="Invalid inputs"
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required'
            ],
            'remember' => 'boolean'
        ]);

        

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials, $remember)){
            return response([
                'status' => 'error',
                'msg' => "Xác thực không thành công."
            ], 422);
        }

        $user = Auth::user();

        $role = Role::where('id',$user['role_id'])->first();
        if($role['id'] != 6){
            $user_info =  new StaffAuthResource(Staff::where('id_login',$user['id'])->first());

            if($user_info['active']==0){
                return response([
                    'status' => 'error',
                    'msg' => "Xác thực không thành công."
                ], 422);
            }
            
            $token = $user->createToken('main')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'msg' => "Đăng nhập thành công.",
                'information' => $user_info,
                'roleUser' => $role,
                'token' => $token,
            ]);    
        }
        else{
            return response()->json([
                'status' => 'success',
                'msg' => "Đăng nhập thành công.",
                'roleUser' => $role,
                'token' => $user->createToken('customer')->plainTextToken,
            ]); 
        }
        

    }

    /**
     * Đăng kí tài khoản
     * @OA\Post (
     *     path="//api/admin/logout",
     *     tags={"API Authentication"},
 *             @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 @OA\Property(
        *                      type="object",
        *                      @OA\Property(
        *                          property="phone_number",
        *                          type="string"
        *                      ),
        *                 ),
        *                 example={
        *                     "username":"nghi1421",
        *                     "password":"123123123",
        *                     "remember": true,
        *                }
        *             )
        *         )
        *      ),


     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     * *             @OA\Property(
     *                 type="string",
     *                 property="msg",
     *                 example = "Dang xuat thanh cong",
     *                 
     *              ),
     *              @OA\Property(
     *                 type="boolean",
     *                 property="success",
     *                 example = true,
     *             )
     *      ),     

     * )
     * )
     */
    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'status' => 'success',
            'msg' => "Đăng xuất thành công.",
        ]);
    }


     /**
     * Đăng nhập khách háng
     * @OA\Post (
     *     path="/api/login-customer",
     *     tags={"API Authentication"},
        *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
    *                      @OA\Property(
    *                          property="phone_number",
    *                          type="string",
    *                          example = "0123123123"
    *                      )
        *          
        *             )
        *         )
        *      ),
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 type="object",
     *                 property="information",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="Nguyen Van A"),
     *                  @OA\Property(property="gender", type="number", example=1),
     *                  @OA\Property(property="phone_number", type="string", example="0123123123"),
     *                  @OA\Property(property="dob", type="string", example="2001-04-01"),
     *                  @OA\Property(property="active", type="booelan", example=true),
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 property="token",
     *                 example="123123123123123123123"
     *             ),
     *             @OA\Property(
     *                 type="string",
     *                 property="msg",
     *                 example="Dang nhap khach hang thanh cong"
     *             )
     *          )
     *    ),      
    *       @OA\Response(
    *         response=400,
    *         description="FAIL",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 type="string",
    *                 property="msg",
    *                 example="Chua co thong tin khach hang"
    *             )
    *         )
    *     )
     * 
     * )
     */
    public function loginCustomer(Request $request){
        $validation = $request->validate([
            'phone_number' => ['required','regex:/(0)[0-9]/','not_regex:/[a-z]/','min:9']
        ]);

        return response()->json([
            'status' => 'success',
            'fakeOTP' => random_int(100000,999999),
        ]);


        
    }

    public function getCustomerThroughtOTP(Request $request){
        $data  = $request->all();
        if($data['result']){

            $login_customer = [
                'email' => 'admin@gmail.com',
                'password' => 'Admin12345.',
            ];
    
            Auth::attempt($login_customer);
            $user = Auth::user();
            $token = $user->createToken('customer')->plainTextToken;

            $cus = Customer::where('phone_number',$data['phone_number'])->first();
        
            if(!$cus){
                return response()->json([
                    'status' => 'fail',
                    'phone_number' => $data['phone_number'],
                    'msg' => "Khách hàng chưa có tài khoản.",
                    'token' => $token
                ],400);
            }

            $info_cus = new CustomerResource($cus);
           

            return response([
                'status' => 'success',
                'msg' => "Đăng nhập thành công.",
                'information' => $info_cus,
                'roleUser' =>  Role::find(6),
                'token' => $token,
            ]);
        }else{
            return response()->json([
                'status' => 'fail',
                'msg' => "Xác thực otp thất bại."
            ],400);
        }
    }

    public function addCustomer(StoreNewCustomerRequest $request){

        $new_cus = new CustomerResource(Customer::create($request->all()));
        
        if($new_cus){

            return response()->json([
                'status' => 'success',
                'msg' => 'Thêm khách hàng thành công',
                'newCustomer' => $new_cus,
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Thêm nhân viên thất bại",
            ],422);
        }
    }
}
