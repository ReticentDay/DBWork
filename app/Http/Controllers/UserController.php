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
        $userCheck = DB::select(    'select name,email,Identity_card_number,address,birthday,phont,sex,user_type,created_at
                                    from users where id = :id', ['id' => $id]);
        return view('test/test',['users' => $userCheck]);
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
        $userCheck = DB::select(    'select address,birthday,phont,sex
                                    from users where id = :id', ['id' => $id]);
        return view('test/test',['users' => $userCheck]);
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
                                set address = :address, birthday = :birthday, phont = :phont, sex = :sex 
                                where id = :id', 
                               ['address' => $request->input['address'] , 
                                'birthday' => $request->input['birthday'] ,
                                'sex' => $request->input['sex'] ,
                                'id' => $id ,
                                'phont' => $request->input['phone']]);

        return view();
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
        
        $userCheck = DB::select('select count(staff_id) from users where staff_id = :id'
                                , ['id' => Auth::user()->id]);
        dd($userCheck);
        if(Auth::user()->user_type != "staff" && $userCheck[0]->count(staff_id) > 0)
        {
            return "You can't see this";
        }
        $userList = DB::select('select name,email,id,user_type from users');
        return view('test/test',['userList' => $userList]);
    }

    public function typeListSerch($keyWord)
    {
        //會員狀態查詢{GET}：/user/type/serch/{關鍵字}
        $userCheck = DB::select('select count(staff_id) from users where staff_id = :id'
                                , ['id' => Auth::user()->id]);
        dd($userCheck);
        if(Auth::user()->user_type != "staff" && $userCheck[0]->count(staff_id) > 0)
        {
            return "You can't see this";
        }
        $userList = DB::select("select name,email,id,user_type from users 
                                where name like '%:search%'
                                or email like '%:search%'",
                                ['search' => $keyWord]);
        return view('test/test',['userList' => $userList]);
    }

    public function typeUpdate(Request $request)
    {
        //會員狀態更新{POST}：/user/type
        $userCheck = DB::select('select count(staff_id) from users where staff_id = :id'
                                , ['id' => Auth::user()->id]);
        dd($userCheck);
        if(Auth::user()->user_type != "staff" && $userCheck[0]->count(staff_id) > 0)
        {
            return "You can't see this";
        }
        $affected = DB::update('update users 
                                set user_type = :user_type
                                where id = :id', 
                               ['user_type' => $request->input['user_type'] , 
                                'id' => $request->input['id']]);
    }
}
