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
                        values(:shop_id,"NO")',['shop_id'=>$shop_id[0]->shop_id);
        }
        DB::insert('insert into shop_product(shop_id,product_id,state,quantity)
                    values(:shopid,:productid,:state,:quantity)',
                    ['shopid'=>$shop_id[0]->shop_id,'productid'=>$product_id,'state' =>'shippig','quantity'=>$quantity]);
    }

    public function list(Request $request)
    {
       $member_id = Auth::user()->id;
       if(!Auth::Check())
       {
           return "Action Fail!";
       }
       $product = DB::select('select p.Product_name,p.Price
                              from shop s,shopping_cart sc,shop_product sp,product p
                              where s.member_id = :id
                              and s.shop_id = sc.shop_id
                              and sc.state = "NO"
                              and sp.shop_id = sc.shop_id
                              and sp.product_id = p.product_id',['id' => $member_id]);
        dd($product);
    }

    public function order(Request $request)
    {
        $member_id = Auth::user()->id;
        $product = DB::('select p.product_name,p.price,d.rate
                         from product p,shop s,discount d,shopping_cart sc,shop_product sp
                         where s.member_id = :member_id
                         and sc.state = "NO"
                         and s.shop_id = sp.shop_id
                         and sp.shop_id = p.product_id',['member_id' => $member_id]);
    }

    public function orderover(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
