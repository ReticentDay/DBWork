<?php

namespace App\Http\Controllers;

use Gate;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function add(Request $request)
    {
        //商品加入購物車{POST}：/shop/add
        if(!Auth::check())
            return "you can't do it";
        $member_id = Auth::user()->id;
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $shop_id = DB::select('select max s.shop_id
                               from shop s,shopping_cart sc
                               where s.member_id = :id
                               and s.shop_id = sc.shop_id
                               and sc.state = "NO"',['id' => $member_id]);
        if($shop_id == NULL)
        {
            DB::insert('insert into shop(member_id)
                        values(:member_id)',['member_id'=>$member_id]);
            $shop_id = DB::select('select max s.shop_id
                                   from shop s
                                   where s.member_id = :id',['id' => $member_id]);
            DB::insert('insert into shopping_cart(shop_id,state)
                        values(:shop_id,"NO")',['shop_id'=>$shop_id[0]->shop_id]);
        }
        DB::insert('insert into shop_product(shop_id,product_id,state,quantity)
                    values(:shopid,:productid,:state,:quantity)',
                    ['shopid'=>$shop_id[0]->shop_id,'productid'=>$product_id,'state' =>'shippig','quantity'=>$quantity]);
        return redirect()->route('product.show',[id => $product_id]);
    }

    public function list(Request $request)
    {
        //商品購物車查詢{POST}：/shop/list
        if(!Auth::check())
            return "you can't do it";
        $member_id = Auth::user()->id;
        $product = DB::select('select p.Product_name,p.Price
                              from shop s,shopping_cart sc,shop_product sp,product p
                              where s.member_id = :id
                              and s.shop_id = sc.shop_id
                              and sc.state = "NO"
                              and sp.shop_id = sc.shop_id
                              and sp.product_id = p.product_id',['id' => $member_id]);
        return view('ShoppingSystem/list',['product' => $product]);
    }

    public function order(Request $request)
    {
        //商品結帳頁面{POST}：/shop/order
        if(!Auth::check())
            return "you can't do it";
        $member_id = Auth::user()->id;
        $product = DB::select(  'select p.product_name,p.price,d.rate
                                from product p,shop s,discount d,shopping_cart sc,shop_product sp
                                where s.member_id = :member_id
                                and sc.state = "NO"
                                and s.shop_id = sp.shop_id
                                and sp.shop_id = p.product_id',
                                ['member_id' => $member_id]);
        return view('ShoppingSystem/order',['product' => $product]);
    }

    public function orderover(Request $request)
    {
        //商品結帳{POST}：/shop/order/over
        if(!Auth::check())
            return "you can't do it";
        date_default_timezone_set('Asia/Taipei');
        $datetime= date("Y/m/d H:i:s");
        $member_id = Auth::user()->id;
        $shop_id = DB::select('select max s.shop_id
                               from shop s,shopping_cart sc
                               where s.member_id = :id
                               and s.shop_id = sc.shop_id
        and sc.state = "NO"',['id' => $member_id]);
        DB::update('update shopping_cart
                    set state = "YES"
                    where shop_id = :shop_id',['shop_id'=>$shop_id[0]->$shop_id]);
        DB::insert('insert into order(shop_id,state,buy_date)
                    values(:shop_id,"Not delivered",:date)',['shop_id'=>$shop_id[0]->$shop_id,'date'=>$datetime]);
        return redirect()->route('product.index');
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
    public function store(Request $request)
    {
        //
    }

    public function search($key)
    {
        //訂單搜尋系統{GET}：/shop/serch/{關鍵字}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $key = "%".$key."%";
        $order = DB::select('select m.member_id ,m.name ,m.identity_card_number ,m.address ,o.shop_id ,o.state ,o.buy_state ,p.product_name ,p.price,d.rate
                             from member m ,shop s ,order o ,shop_product sp ,product p ,discount d
                             where o.shop_id = sp.shop_id
                             and sp.product_id = p.product_id
                             and sp.product_id = d.product_id
                             and (s.shop_id like ?) or (s.state like ?) or (p.product_id like ?)',[$key,$key,$key]);
        return view('OrderManagementSystem/search',['order' => $order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //訂單確認系統{GET}：/shop/{id}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $order = DB::select('select m.member_id ,m.name ,m.identity_card_number ,m.address ,o.shop_id ,o.state ,o.buy_state ,p.product_name ,p.price,d.rate
                             from member m ,shop s ,order o ,shop_product sp ,product p ,discount d
                             where o.shop_id = :shop_id
                             and sp.shop_id = o.shop_id
                             and sp.product_id = p.product_id
                             and sp.product_id = d.product_id
                             and s.shop_id = o.shop_id
                             and m.member_id = s.member_id',['shop_id'=>$id]);
        return view('OrderManagementSystem/check',['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //訂單修改頁面{GET}：/shop/{id}/edit
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $order = DB::select('select o.state ,o.buy_date
                             from order o
                             where o.shop_id = :shop_id',['shop_id'=>$id]);
        return view('OrderManagementSystem/fix',['order' => $order]);
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
        //訂單修改{PUT}：/shop/{id}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        DB::update('update order
                    set state = :state
                    where shop_id = :shop_id',['state' => $request[0]->$state,'shop_id'=>$id]);
        return redirect()->route('show.show',['id' => $id]);
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
    
}
