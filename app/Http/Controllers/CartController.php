<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
class CartController extends Controller
{
    function AddToCart(Request $request){

        $cart=new Cart;
        $cart->customer_email=$request->customer_email;
        $cart->orders=$request->orders;
        $items=explode(",",$request->orders);
        $cart->total_order_quantity=count($items);

        $cart->orders_quantity=$request->orders_quantity;

        $items_quantity=explode(",",$request->orders_quantity);

        //collecting each products price
        $price_array=array();
        foreach ($items as $item){
            $test=Product::where('product_id',$item)->get();
            $prices=$test[0]->price;
            array_push($price_array,$prices);
        }


        //collecting and multiplying each product quantity with their_price
        $total = array();
        foreach($price_array as $key => $price){
            $total[$key] = $price * $items_quantity[$key];
        }


        $cart->total_order_price=array_sum($total);

        $result=$cart->save();
       if($result){
           return response()->json(array("id"=> $cart->id,"Order_Total_price"=>$cart->total_order_price,'success'=>'Order made Successfully.'),200);
       }else{
           return ["An error occured"];
       }

    }
}
