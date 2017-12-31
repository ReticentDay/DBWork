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
        $productIndex = DB::select('select product_name,photo,price 
                                    form product order by product_id asc');
        return view('ProductInquirySystem/product',['productIndex' =>$productIndex ]);

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

    public function search (Request $request,$keyword){
      //商品查詢{GET}：/product/serch/{關鍵字}

      $keyword = '%'.$keyword.'%';
      $show_search = DB::select('select product_name,photo,price 
                                form product 
                                where product_name like ?',
                                [$keyword]);
      return view('ProductInquirySystem/product/search',['show_search'->$show_search]);
    }

    public function store(Request $request)
    {
        //商品上架儲存{POST}：/product
        if(!Auth::check())
            return "you can't do it";
        if(Auth::user()->user_type == 'customer' )
            return "you can't do it";
        DB::insert( 'insert into product 
                    (Product_name, Date, Price, State, Click_count, Photo, Info, Stock) 
                    values (:Product_name, :Date, :Price, :State, :Click_count, :Photo, :Info, :Stock)'
                    ,[
                        'Product_name' => $request->Product_name,
                        'Date' => date("Y/m/d"),
                        'Price' => $request->Price,
                        'State' => $request->State,
                        'Click_count' => 0,
                        'Photo' => $request->file('photo'),
                        'Info' => $request->Info,
                        'Stock' => $request->Stock
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

        $product_info = DB::select( 'select product_id,price,photo,product_name,info,stock 
                                    from product 
                                    where product_id = :id'
                                    ,['id'=>$id]);
        return view ('ProductInquirySystem/show',['product_info'->$product_info]);
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
        return view ('GoodsShelvesSystem/fix',['product_info'->$product_info]);
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
        $affected = DB::update('update product set 
                                set product_name = :product_name, date = :date, price = :price
                                , state = :state, photo = :photo, info = :info, stock = :stock
                                where product_id = :id'
                                ,[
                                    'product_name' => $request->Product_name,
                                    'date' => date("Y/m/d"),
                                    'price' => $request->Price,
                                    'state' => $request->State,
                                    'photo' => $request->file('photo'),
                                    'info' => $request->Info,
                                    'stock' => $request->Stock,
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
