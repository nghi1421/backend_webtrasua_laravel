<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Resources\StaffCollection;
use App\Http\Resources\StaffResource;
use App\Http\Resources\PositionCollection;
use App\Http\Resources\PositionResource;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Position;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StaffCollection(Staff::paginate(5));
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
    public function store(StoreStaffRequest $request)
    {
        // $validation = $request->validate([
        //     'name' => 'required',
        //     'gender' => 'required',
        //     'phone_number' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|unique:staffs,phone_number',
        //     'address' => 'required',
        //     'hometown' => 'required',
        //     'branch_id' => 'required',
        //     'position_id' => 'required',
        //     'create_account' => 'required',
        //     'email' => 'required|email|unique:staffs,email',
        // ]);
        // $data = $request->all();
        // $new_staff = Staff::create([
        //                 'name' =>  $validation['name'],
        //                 'gender' =>  $validation['gender'],
        //                 'phone_number' => $validation['phone_number'],
        //                 'address' => $validation['address'],
        //                 'hometown' => $validation['hometown'],
        //                 'branch_id' => $validation['branch_id'],
        //                 'position_id' => $validation['position_id'],
        //                 'dob' => $data['dob'],
        //                 'email' => $validation['email'],
        //                 'active' => true,
        //         ]);

        // if($validation['create_account']){
        //     $pos_blank = strripos($validation['name'], ' ');
        //     $name  = '';
        //     if($pos_blank){
        //         $name = substr($validation['name'], $pos_blank);
        //     }
        //     else{
        //         $name = $validation['name'];
        //     }
        //     $new_user = User::create([

        //                     'username' => strtolower($name).$this->autoUsernameNum((int)$new_staff['id'], (int)$validation['branch_id'], (int)$data['role_id']),
        //                     'password' => bcrypt('PhucLong123`'),
        //                     'role_id' => $data['role_id'],

        //                 ]);
        //     $new_staff['id_login'] = $new_user['id'];
        //     $new_staff->save();
        // }
        // return response()->json([
        //     'msg' => 'Them nhan vien thanh cong',        
        // ]);
        try {
            $new_staff = new StaffResource(Staff::create($request->all()));
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Thêm nhân viên thành công',
            'newStaff' => $new_staff,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        // $staff = Staff::where('id',$id)->first();
        // return $staff ? response()->json([
        //     'staff_infomation' => $staff
        // ]) :  response()->json([
        //     'msg' => 'Thong tin nhan vien khong ton tai'
        // ],400);

        // if(!$staff){
        //     return response()->json([
        //         'status' => 'error',
        //         'msg' => $e->getMessage(),
        //     ],422);
        // }

        try{
            $staff_info = new StaffResource($staff);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }

        if (!$staff_info){
            return response()->json([
                'status' => 'success',
                'msg' => 'Mã nhân viên không tồn tại',
            ],201);
        }

        return response()->json([
            'status' => 'success',
            'staff_infomation' => $staff_info,
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        
        try{
            $staff->update($request->all());
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }
        
        return response()->json([
            'status' => 'success',
            'msg' => 'Sửa thông tin nhân viên thành công.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        if(
            $staff->importVouchers()->get() != "[]" ||
            $staff->supplyVouchers()->get() != "[]" ||
            $staff->orders()->get() != "[]"
        ) {
            return response()->json([
                'status' => 'false',
                'msg' => "Nhan vien da lap don khong the xoa",
            ],400);
        }

        if($staff['id_login'])
            User::find($staff['id_login'])->delete();

        try{
            $staff->delete();
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ],422);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Xoa nhân viên thành công',
        ]);
    }


    public function active($id){
        $staff = Staff::find($id);

        if($staff['active'] ==  true){
            return response()->json([
                'status' => 'error',
                'msg' => 'Nhân viên đang thiết lập hoạt động.',
            ],422);
        }

        $staff['active'] = true;
        
        try{
            $staff->update();
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
        $staff = Staff::find($id);

        if($staff['active'] == false){
            return response()->json([
                'status' => 'error',
                'msg' => 'Nhân viên đang thiết lập ngưng hoạt động.',
            ],422);
        }

        $staff['active'] = false;
        $staff->update();

        try{
            $staff->update();
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

    public function getPosition(){
        $position = new PositionCollection(Position::paginate(5));
        return response()->json([
            'status' => 'success',
            'positions' => $position
        ]);
    }

    //function support------------------------------------------------
    public function paddingNumber($a){
        return $a > 99 ? strval($a) : str_pad($a, 3, '0', STR_PAD_LEFT);
    }
    public function autoUsernameNum(int $user_id,int $branch_id,int $role_id){
        return $this->paddingNumber($user_id).$this->paddingNumber($branch_id).$this->paddingNumber($role_id);
    }
}
