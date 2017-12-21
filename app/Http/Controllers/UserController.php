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
        $userCheck = DB::select('select * from users where id = :id', ['id' => $id]);
        if(Gate::denies('checkUser', $userCheck))
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
    }

    public function typeListSerch($keyWord)
    {
        //會員狀態查詢{GET}：/user/type/serch/{關鍵字}
    }

    public function typeUpdate(Request $request)
    {
        //會員狀態更新{POST}：/user/type
    }
}
