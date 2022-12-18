<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Staff;
use App\Models\User;
use App\Http\Resources\StaffResource;
use Illuminate\Pagination\Paginator;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreUserAdmin;
use App\Http\Requests\UpdateUserRequest;

use App\Models\Role;

use Illuminate\Support\Facades\DB; 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::paginate(5);

        return response()->json([
            'status' => 'success',
            'data' => $users
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
    public function store(StoreUserAdmin $request)
    {
       $result = DB::transaction(function () use($request) {
            $data = $request->all();
            $staff_info = Staff::where('id', $data['staff_id'])->first();
            if($staff_info){
                if($staff_info['id_login'] == NULL){
                    $data['password'] = bcrypt($data['password']);
                    $new_user = User::create($data);
                    $staff_info['id_login'] = $new_user['id'];
                    $staff_info->save();
                    return true;    
                }
            }
            return false;
       });

       if($result){
            return response()->json([
                'status' => 'success',
                'msg' => "Thêm user thành công" ,
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Thêm user thất bại" ,
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user){
            $user['staff'] = new StaffResource(Staff::where('id_login' , $user['id'])->first());
            return response()->json([
                'status' => 'success',
                'data' => $user ,
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy tài khoản" ,
            ],422);
        }
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
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $data  = $request->all();
        if($user){

            // if (!Hash::check($user->makeVisible(['password']), $data['old_password'] )) {
            //     return response([
            //         'status' => 'error',
            //         'msg' => "1Xác thực đổi mật khẩu thất bại."
            //     ], 422);
            // }

            if(!Auth::guard('web')->attempt(['email' => $data['email'], 'password' => $data['old_password']])){
                return response([
                    'status' => 'error',
                    'msg' => "Xác thực đổi mật khẩu thất bại."
                ], 422);
            }

            $result = DB::transaction(function () use ($user, $data, $id) {
                $staff = Staff::where('id_login' , $user['id'])->first();
                // return response($staff);
                if($staff['id'] != $data['staff_id']){
                    $staff['id_login'] = NULL;
                    $staff->save();

                    $staff_new = Staff::find($data['staff_id']);
                    // return response($staff_new);
                    $staff_new['id_login'] = $id;
                    $staff_new->save();
                }

                $data['password'] = bcrypt($data['new_password']);
                if($user->update($data)){
                    return true;
                }
                else{
                    return false;

                }
            });

            if($result){
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Sửa thông tin tài khoản thành công',
                ]);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'msg' => "Sửa thông tin tài khoản thất bại" ,
                ],422);
            }
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy tài khoản" ,
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $staff =Staff::where('id_login' , $user['id'])->first();
            if($staff){
                $staff['id_login'] = NULL;
                $staff->save();
            }
            if($user->delete()){
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Xóa thông tin tài khoản thành công',
                ]);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'msg' => "Xóa thông tin tài khoản thất bại" ,
                ],422);
            }
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy tài khoản" ,
            ],422);
        }
    }

    public function getAllRole(){
        return response()->json([
            'status' => 'success',
            'data' => Role::get()
        ]);
    }

    public function setDefaultPassword($id){
        $user = User::find($id);
        if($user){
            $user['password'] = bcrypt("PhucLong123`");
            if($user->save()){
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Reset mật khẩu thành công.',
                ]);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'msg' => "Reset mật khẩu thất bại." ,
                ],422);
            }
        }
        else{
            return response()->json([
                'status' => 'error',
                'msg' => "Không tìm thấy tài khoản" ,
            ],422);
        }
    }
}
