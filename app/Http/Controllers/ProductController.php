<?php

namespace App\Http\Controllers;

use DB;
use Gate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //商品目錄{GET}：/product
        $productIndex = DB::select('select product_name,photo,price,product_id
                                    from product order by product_id asc');
        return view('ProductInquirySystem/index',['productIndex' =>$productIndex ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //商品上架編輯{GET}：/product/create
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        return view('GoodsShelvesSystem/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function search (Request $request){
      //商品查詢{GET}：/product/serch/{關鍵字}
        
        $keyword = '"%'.$request->input('key').'%"';
        $show_search = DB::select('select product_name,photo,price,product_id
                                    from product 
                                    where product_name like '.$keyword);
        //dd($show_search);
        return view('ProductInquirySystem/index',['productIndex'=>$show_search]);
    }

    public function store(Request $request)
    {
        //商品上架儲存{POST}：/product
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        DB::insert( 'insert into product 
                    (product_name, date, price, state, click_count, photo, info, stock) 
                    values (:product_name, :date, :price, :state, :click_count, :photo, :info, :stock)'
                    ,[
                        'product_name' => $request->Product_name,
                        'date' => date("Y/m/d"),
                        'price' => $request->price,
                        'state' => $request->state,
                        'click_count' => 0,
                        'photo' => $request->photo,
                        'info' => $request->info,
                        'stock' => $request->stock
                    ]);
        return redirect()->route('product.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //商品頁面{GET}：/product/{id}

        $product_info = DB::select( 'select product_id,price,photo,product_name,info,state,stock 
                                    from product 
                                    where product_id = :id'
                                    ,['id'=>$id]);
        //dd($product_info);
        return view('ProductInquirySystem/show',['product_info'=>$product_info,'user_type'=>Auth::user()->user_type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //商品修改{GET}：/product/{id}/edit
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $product_info = DB::select( 'select * 
                                    from product 
                                    where product_id = :id'
                                    ,['id'=>$id]);
        return view ('GoodsShelvesSystem/fix',['product_info'=>$product_info]);
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
        //商品修改上傳{PUT}：/product/{id}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $affected = DB::update('update product 
                                set product_name = :product_name, date = :date, price = :price
                                , state = :state, photo = :photo, info = :info, stock = :stock
                                where product_id = :id'
                                ,[
                                    'product_name' => $request->Product_name,
                                    'date' => date("Y/m/d"),
                                    'price' => $request->price,
                                    'state' => $request->state,
                                    'photo' => $request->photo,
                                    'info' => $request->info,
                                    'stock' => $request->stock,
                                    'id' => $id
                                ]);
        return redirect()->route('product.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //商品下架{DELETE}：/product/{id}
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        $deleted = DB::delete('delete from product where product_id = :id',['id' => $id]);
        return redirect()->route('product.create');
    }
}
