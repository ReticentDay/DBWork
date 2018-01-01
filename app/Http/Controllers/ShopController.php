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
        $shop_id = DB::select('select max(s.shop_id) shop_id
                               from shop s,shapping_car sc
                               where s.member_id = :id
                               and s.shop_id = sc.shop_id
                               and sc.state = "NO"',['id' => $member_id]);
        //dd($shop_id);
        if($shop_id[0]->shop_id == NULL)
        {
            DB::insert('insert into shop(member_id)
                        values(:member_id)',['member_id'=>$member_id]);
            $shop_id = DB::select('select max(s.shop_id) shop_id
                                   from shop s
                                   where s.member_id = :id',['id' => $member_id]);
            DB::insert('insert into shapping_car(shop_id,state)
                        values(:shop_id,"NO")',['shop_id'=>$shop_id[0]->shop_id]);
        }
        DB::insert('insert into shop_product(shop_id,product_id,state,quantity)
                    values(:shopid,:productid,:state,:quantity)',
                    ['shopid'=>$shop_id[0]->shop_id,'productid'=>$product_id
                    ,'state' =>'shippig','quantity'=>$quantity]);
        return redirect()->route('product.show',['id' => $product_id]);
    }

    public function list(Request $request)
    {
        //商品購物車查詢{get}：/shop/list
        if(!Auth::check())
            return "you can't do it";
        $member_id = Auth::user()->id;
        date_default_timezone_set('Asia/Taipei');
        $datetime= date("Y/m/d");
        $productList = DB::select('select p.product_name product_name,p.price price,sp.quantity quantity,d.rate rate
                                from shop s,shapping_car sc,shop_product sp,product p
                                Left JOIN discount d
                                on (p.product_id = d.product_id
                                    and d.start_date <= :today_s
                                    and d.end_date >= :today_e)
                                where s.member_id = :id
                                and s.shop_id = sc.shop_id
                                and sc.state = "NO"
                                and sp.shop_id = sc.shop_id
                                and sp.product_id = p.product_id',['today_s' => $datetime,'today_e' => $datetime,'id' => $member_id]);
        $total = 0;
        foreach($productList as $product){
            $price = $product->price * $product->quantity;
            if($product->rate != null)
                $price *= $product->rate;
            $total += $price;
        }
        return view('ShoppingSystem/list',['productList' => $productList,'total' => $total]);
    }

    public function order(Request $request)
    {
        //商品結帳頁面{POST}：/shop/order
        if(!Auth::check())
            return "you can't do it";
        $member_id = Auth::user()->id;
        $productList = DB::select('select p.product_name product_name,p.price price,sp.quantity quantity,d.rate rate
                                from shop s,shapping_car sc,shop_product sp,product p
                                Left JOIN discount d
                                on (p.product_id = d.product_id
                                    and d.start_date <= :today_s
                                    and d.end_date >= :today_e)
                                where s.member_id = :id
                                and s.shop_id = sc.shop_id
                                and sc.state = "NO"
                                and sp.shop_id = sc.shop_id
                                and sp.product_id = p.product_id',['today_s' => $datetime,'today_e' => $datetime,'id' => $member_id]);
        $total = 0;
        foreach($productList as $product){
            $price = $product->price * $product->quantity;
            if($product->rate != null)
                $price *= $product->rate;
            $total += $price;
        }
        return view('ShoppingSystem/order',['productList' => $productList,'total' => $total]);
    }

    public function orderover(Request $request)
    {
        //商品結帳{POST}：/shop/order/over
        if(!Auth::check())
            return "you can't do it";
        date_default_timezone_set('Asia/Taipei');
        $datetime= date("Y/m/d H:i:s");
        $member_id = Auth::user()->id;
        $shop_id = DB::select(  'select max(s.shop_id) shop_id
                                from shop s,shapping_car sc
                                where s.member_id = :id
                                and s.shop_id = sc.shop_id
                                and sc.state = "NO"',['id' => $member_id]);
        DB::update('update shapping_car
                    set state = "YES"
                    where shop_id = :shop_id',['shop_id'=>$shop_id[0]->shop_id]);
        DB::insert('insert into `order`(shop_id,state,buy_date)
                    values(:shop_id,"Not delivered",:date)',['shop_id'=>$shop_id[0]->shop_id,'date'=>$datetime]);
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
        $order = DB::select('select m.id id ,m.name name ,m.identity_card_number identity_card_number
                            ,m.address address ,o.shop_id shop_id ,o.state state ,o.buy_date buy_date
                            from users m ,shop s ,`order` o
                            where m.id = s.member_id
                            and s.shop_id = o.shop_id
                            and (s.shop_id like "?") or (s.state like "?")',[$key,$key]);
        return view('OrderManagementSystem/search',['orderList' => $order]);
    }

    public function searchs()
    {
        //訂單搜尋系統{GET}：/shop/serchs
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $order = DB::select('select m.id id ,m.name name ,m.identity_card_number identity_card_number
                            ,m.address address ,o.shop_id shop_id ,o.state state ,o.buy_date buy_date
                            from users m ,shop s ,`order` o
                            where m.id = s.member_id
                            and s.shop_id = o.shop_id');
        return view('OrderManagementSystem/search',['orderList' => $order]);
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
        $datetime = DB::select('select buy_date from `order` where shop_id = :shop_id',['shop_id'=>$id]);
        $orderList = DB::select('select m.id id,m.name name,m.identity_card_number identity_card_number,m.address address
                                ,o.shop_id shop_id,o.state state,d.rate rate,o.buy_date buy_date
                                ,p.product_name product_name,p.price price, sp.quantity quantity
                                from users m ,shop s ,`order` o ,shop_product sp ,product p
                                Left JOIN discount d
                                on (p.product_id = d.product_id
                                    and d.start_date <= :today_s
                                    and d.end_date >= :today_e)
                                where o.shop_id = :shop_id
                                and sp.shop_id = o.shop_id
                                and sp.product_id = p.product_id
                                and s.shop_id = o.shop_id
                                and m.id = s.member_id',['today_s' => $datetime[0]->buy_date,'today_e' => $datetime[0]->buy_date,'shop_id'=>$id]);
        $total = 0;
        foreach($orderList as $product){
            $price = $product->price * $product->quantity;
            if($product->rate != null)
                $price *= $product->rate;
            $total += $price;
        }
        
        return view('OrderManagementSystem/check',['orderList' => $orderList,'total'=>$total]);
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
        $datetime = DB::select('select buy_date from `order` where shop_id = :shop_id',['shop_id'=>$id]);   
        $orderList = DB::select('select m.id id,m.name name,m.identity_card_number identity_card_number,m.address address
                                ,o.shop_id shop_id,o.state state,d.rate rate,o.buy_date buy_date
                                ,p.product_name product_name,p.price price, sp.quantity quantity
                                from users m ,shop s ,`order` o ,shop_product sp ,product p
                                Left JOIN discount d
                                on (p.product_id = d.product_id
                                    and d.start_date <= :today_s
                                    and d.end_date >= :today_e)
                                where o.shop_id = :shop_id
                                and sp.shop_id = o.shop_id
                                and sp.product_id = p.product_id
                                and s.shop_id = o.shop_id
                                and m.id = s.member_id',['today_s' => $datetime[0]->buy_date,'today_e' => $datetime[0]->buy_date,'shop_id'=>$id]);
        $total = 0;
        foreach($orderList as $product){
            $price = $product->price * $product->quantity;
            if($product->rate != null)
                $price *= $product->rate;
            $total += $price;
        }
        $order = DB::select('select o.state ,o.buy_date
                             from `order` o
                             where o.shop_id = :shop_id',['shop_id'=>$id]);
        return view('OrderManagementSystem/fix',['order' => $order,'orderList' => $orderList,'total'=>$total]);
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
        DB::update('update `order`
                    set state = :state
                    where shop_id = :shop_id',['state' => $request->state,'shop_id'=>$id]);
        return redirect()->route('shop.show',['id' => $id]);
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
