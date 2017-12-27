<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function money()
    {
        //●商品則扣增加{GET}：/money
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type != 'staff' )
            return "you can't do it";
        $orderList = DB::select('select o.state,o.buy_date,sp.quantity,p.product_name,p.price,u.name
                                form order o,Shop_product sp,shop s,product p,Users u
                                where o.shop_id = s.shop_id
                                and sp.shop_id = s.shop_id
                                and p.product_id = sp.product_id
                                and s.member_id = u.id');
        return view('FinancialReportingSystem/index',['orderList' => $orderList]);
    }
}
