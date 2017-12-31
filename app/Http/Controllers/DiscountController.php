<?php

namespace App\Http\Controllers;

use DB;
use Gate;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    //
    public function create()
    {
        //●商品則扣增加{GET}：/discount/create
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $productList = DB::select( 'select product_id,product_name
                                from product');
        return view('DiscountManagementSystem/create',['productList' => $productList]);
    }

    public function store(Request $request)
    {
        //●商品則扣儲存{POST}：/discount
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        DB::insert( 'insert into discount 
                    (product_id, rate, start_date, end_date)
                    values (:product_id, :rate, :start_date, :end_date)',
                    ['product_id' => $request->product_id,
                    'rate' => $request->rate,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date]);
        $discountList = DB::select( 'select d.product_id,p.product_name,p.price,d.rate,d.start_date,d.end_date
                                    from discount d,product p where d.product_id = p.product_id');
        return view('DiscountManagementSystem/index',['discountList' => $discountList]);
    }

    public function index()
    {
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $discountList = DB::select( 'select d.product_id,p.product_name,p.price,d.rate,d.start_date,d.end_date
                                    from discount d,product p where d.product_id = p.product_id');
        return view('DiscountManagementSystem/index',['discountList' => $discountList]);
    }

    public function search($id)
    {
        //商品則扣查詢{GET}：/discount/serch/{product_id}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $discount = DB::select( 'select d.product_id,p.product_name,p.price,d.rate,d.start_date,d.end_date
                                    from discount d,product p where d.product_id = p.product_id AND d.product_id like %'.$id.'%');
        return view('DiscountManagementSystem/search',['discountList' => $discount]);
    }

    public function update(Request $request, $id)
    {
        //商品則扣更改{PUT}：/discount/{discount_id}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $affected = DB::update('update discount 
                                set rate = :rate, start_date = :start_date, end_date = :end_date
                                where name = :id',
                                [   'rate' => $request->rate,
                                    'start_date' => $request->start_date,
                                    'end_date' => $request->end_date,
                                    'id' => $id]);
        $discountList = DB::select( 'select d.product_id,p.product_name,p.price,d.rate,d.start_date,d.end_date
                                    from discount d,product p where d.product_id = p.product_id');
        return view('DiscountManagementSystem/index',['discountList' => $discountList]);
    }
}
