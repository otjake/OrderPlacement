<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    function AddToCart(Request $request){

        $cart=new Cart;

        $rules=array(
            'customer_email'=>'required|email:dns,rfc',
        );

        $validator=Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        //cart orders[collect product_id]
        $cart->product_id=$request->product_id;
        $items=explode(",",$request->product_id);
        $items_count=count($items);
        $cart->total_order_quantity=$items_count;


        //cart orders quantity[collect quantity for each product]
        $cart->product_quantity=$request->product_quantity;
        $items_quantity=explode(",",$request->product_quantity);
        $items_quantity_count=count( $items_quantity);


        //making sure product entered and their no of quantity entered match
        if($items_count !== $items_quantity_count ){
            return response()->json(['error'=>"product inputs do not match quantity inputs,make sure inputs are comma separated"],401);

        }

        //collecting each products price and making sure they are integers
        $price_array=array();
        foreach ($items as $item){
            if(intval($item)) {
                $test = Product::where('product_id', $item)->get();
                $prices = $test[0]->price;
                array_push($price_array, $prices);
            }
            else{
                return response()->json(['error'=>"Non-numeric input product id,make sure inputs are comma separated"],401);

            }
        }


        $quantity_array=array();

        //validating integer entered
        foreach ($items_quantity as $item_q){
            if(intval($item_q)) {
                array_push($quantity_array, $item_q);
            }
            else{
                return response()->json(['error'=>"Non-numeric input in product quantity,make sure inputs are comma separated"],401);

            }
        }


        //collecting and multiplying each product quantity with their_price
        $total = array();
        foreach($price_array as $key => $price){
            $total[$key] = $price * $quantity_array[$key];
        }

        $cart->customer_email=$request->customer_email;
        $cart->total_order_price=array_sum($total);

        $result=$cart->save();
       if($result){
           return response()->json(array("id"=> $cart->id,"customer_email"=> $cart->customer_email,"Order_Total_price"=>$cart->total_order_price,'success'=>'Order made Successfully.'),200);
       }else{
           return ["An error occurred"];
       }

    }
}
