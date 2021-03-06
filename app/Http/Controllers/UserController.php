<?php

namespace App\Http\Controllers;

use DB;
use Gate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //not thing
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //not thing
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //not thing
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //會員資料系統{GET}：/user/{id}
        if(!Auth::check())
        {
            return "You can't see this";
        }
        if(Auth::user()->id != $id)
        {
            return "You can't see this";
        }
        $userData = DB::select(    'select name,email,Identity_card_number,address,birthday,phont,sex,user_type,created_at
                                    from users where id = :id', ['id' => $id]);
        return view('MemberInformationSystem/show',['users' => $userData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //會員資料修改{GET}：/user/{id}/edit
        if(!Auth::check())
        {
            return "You can't see this";
        }
        if(Auth::user()->id != $id)
        {
            return "You can't see this";
        }
        $userData = DB::select(    'select address,birthday,phont,sex
                                    from users where id = :id', ['id' => $id]);
        return view('MemberInformationSystem/fix',['users' => $userData]);
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
        //會員資料修改上傳{PUT}：/user/{id}
        if(!Auth::check())
        {
            return "You can't see this";
        }
        if(Auth::user()->id != $id)
        {
            return "You can't see this";
        }
        $affected = DB::update('update users 
                                set address = :address, birthday = :birthday, phont = :phont 
                                where id = :id', 
                               ['address' => $request->address , 
                                'birthday' => $request->birthday ,
                                'id' => $id ,
                                'phont' => $request->phont]);
        $userData = DB::select( 'select name,email,Identity_card_number,address,birthday,phont,sex,user_type,created_at
                                from users where id = :id', ['id' => $id]);
        return view('MemberInformationSystem/show',['users' => $userData]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //not thing
    }

    /**
     * need add to the router↓
     */

    public function typeList()
    {
        //會員狀態列表{GET}：/user/type
        if(!Auth::check())
        {
            return "You can't see this";
        }
        $userCheck = DB::select('select count(staff_id) count from staff where staff_id = :id'
                                , ['id' => Auth::user()->id]);
        //dd($userCheck);
        if(Auth::user()->user_type != "staff" || $userCheck[0]->count <= 0)
        {
            return "You can't see this";
        }
        $userList = DB::select('select name,email,id,user_type from users');
        //dd($userList);
        return view('MemberManagementSystem/list',['userList' => $userList]);
    }

    public function typeListSerch($keyWord)
    {
        //會員狀態查詢{GET}：/user/type/serch/{關鍵字}
        $userCheck = DB::select('select count(staff_id) from staff where staff_id = :id'
                                , ['id' => Auth::user()->id]);
        //dd($userCheck);
        if(Auth::user()->user_type != "staff" || $userCheck[0]->count(staff_id) <= 0)
        {
            return "You can't see this";
        }

        $userList = DB::select("select name,email,id,user_type from users 
                                where name like '%".$keyWord."%'
                                or email like '%".$keyWord."%'");
        //dd($userList);
        return view('MemberManagementSystem/search',['userList' => $userList]);
    }

    public function typeUpdate(Request $request)
    {
        //會員狀態更新{POST}：/user/type
        $userCheck = DB::select('select count(staff_id) count from staff where staff_id = :id'
                                , ['id' => Auth::user()->id]);
        //dd($userCheck);
        if(Auth::user()->user_type != "staff" || $userCheck[0]->count <= 0)
        {
            return "You can't see this";
        }
        //dd($request);
        $deleted = DB::delete('delete from staff where staff_id = :id',['id' => $request->id]);
        $deleted = DB::delete('delete from manager where manager_id = :id',['id' => $request->id]);
        if($request->user_type == 'manager')
            DB::insert('insert into manager (manager_id, account) values (?, ?)', [$request->id, 500]);
        if($request->user_type == 'staff')
            DB::insert('insert into staff (staff_id, account) values (?, ?)', [$request->id, 1000]);
        $affected = DB::update("update users 
                                set user_type = '".$request->user_type."'
                                where id = ".$request->id);
        $userList = DB::select('select name,email,id,user_type from users');
        //dd($userList);
        return view('MemberManagementSystem/list',['userList' => $userList]);
    }
}
