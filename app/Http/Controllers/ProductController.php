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
        $productIndex = DB::select('select product_name,photo,price form product order by product_id asc');
        return view(ProductInquirySystem/product,['' =>$productIndex ]);

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

    public function search (Request $request){
      //商品查詢{GET}：/product/serch/{型態}/{關鍵字}

      $keyword = $request -> input('');
      $keyword = '%'.$keyword.'%';
      $show_search = DB::select('select product_name,photo,price form product where product_name like ?',array('$keyword'));
      return view(ProductInquirySystem/product/search,[''->$show_search]);
    }

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
        //商品頁面{GET}：/product/{id}

        $product_info = DB::select('select product_id,price,photo,product_name,info,stock from product where product_id=:id',['id'=>$id]);
        return view (ProductInquirySystem/show,[''->$product_info]);
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
