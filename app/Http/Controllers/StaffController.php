<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Resources\StaffCollection;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
        return new StaffResource(Staff::create($request->all()));
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
        return new StaffResource($staff);
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
        $staff->update($request->all());
    
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


    //function support------------------------------------------------
    public function paddingNumber($a){
        return $a > 99 ? strval($a) : str_pad($a, 3, '0', STR_PAD_LEFT);
    }
    public function autoUsernameNum(int $user_id,int $branch_id,int $role_id){
        return $this->paddingNumber($user_id).$this->paddingNumber($branch_id).$this->paddingNumber($role_id);
    }
}
