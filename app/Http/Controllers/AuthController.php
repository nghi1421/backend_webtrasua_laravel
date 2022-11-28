<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
    public function register(Request $request){
        $data = Validator::make($request->all(),[
            'username' => 'required|string|unique:users,username',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'role_id' => 'required',
            'staff_id' => 'required',
        ]);

        if( $data->fails() ){
            return response([
                'msg' => 'Invalid inputs',
            ], 400);
        }

        /** @var \App\Models\User $user */
        $user = User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role_id' => $data['role_id'],
        ]);
        
        $token = $user->createToken('main')->plainTextToken;

        $staff_inf = Staff::where('id',$data['staff_id'])->first();
        $staff_inf['id_login'] = $user['id'];
        $staff_inf->save();

        return response([
            'staff_information' => $staff_inf,
            'token' => $token,
            'msg' => 'Dang ki thanh cong'
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
            'username' => 'required|string|exists:users,username',
            'password' => [
                'required'
            ],
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials, $remember)){
            return response([
                'msg' => 'Xac thuc khong hop le',
            ], 422);
        }

        $user = Auth::user();

        $role = Role::where('id',$user['role_id'])->first();

        $user_info =  Staff::where('id_login',$user['id'])->first();

        $token = $user->createToken('main')->plainTextToken;
        return response([
            'role' => $role,
            'information' => $user_info,
            'token' => $token,
        ]);

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
            'msg' => "Dang xuat thanh cong",
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
            'phone_number' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9'
        ]);
        // $validation = $request->all();
        $info_cus = Customer::where('phone_number',$validation['phone_number'])->first();
        
        if(!$info_cus){
            return response()->json([
                'msg' => "Khachh hang chua co tai khoan"
            ],400);
        }
        $login_customer = [
            'username' => 'allcustomer123',
            'password' => 'ThanhNghi123`',
        ];

        Auth::attempt($login_customer);
        $user = Auth::user();
        $token = $user->createToken('customer')->plainTextToken;
        // $token = 1;
        return response([
            'information' => $info_cus,
            'token' => $token,
            'msg' => "Dang nhap khach hang thanh cong"
        ]);

    }
}
