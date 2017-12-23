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
        DB::select('insert into SHOPPRODUCT(shop_id,product_id,)
                    select s.shop_id
                    from SHOP s,SHOPPRODUCT sp
                    where s.shop_id');
    }

    public function list(Request $request)
    {
       $member_id = Auth::user()->id;
       $product = DB::select('   select p.Product_name,p.Price
                                    from SHOP s,SHOPINGCART sc,SHOPPRODUCT sp,PRODUCT p
                                    where s.member_id = :id
                                    and s.shop_id = sc.shop_id
                                    and sc.state = "NO"
                                    and sp.shop_id = sc.shop_id
                                    and sc.product_id = p.product_id',['id' => $member_id]);
        dd($product);
        return view('ShoppingSystem.list',['product'=>$product]);
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
