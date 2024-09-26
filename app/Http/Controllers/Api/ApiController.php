<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartChoose;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function productIndex(Request $request){
        $products= Product::get();

        return response()->json([
            'data' =>$products
        ]);
    }

    public function productStore(Request $request){

        $product = Product::create([
            'name'=> $request->name,
            'weight'=>$request->weight,
            'price'=>$request->price,
            'code'=>$request->code
        ]);

        if ($request->hasFile('file')) {
            $product->addMedia($request->file(key: 'file'))->toMediaCollection('product');
        }
        return response()->json([
            'data' =>$product
        ]);
    }

    public function cartIndex(Request $request){
        $carts = Cart::get();

        return response()->json([
            'data' => $carts
        ]);
    }

    public function cartStore(Request $request){
        $cart = Cart::create([
            'code'=> $request->code
        ]);
        return response()->json([
            'data' => $cart
        ]);
    }

    public function cartChoose(Request $request){
        $cart = CartChoose::create([
            'cart_id'=> $request->cart_id,
            'user_id'=> auth('api')->user()->id
        ]);

        return response()->json([
            'data' => $cart
        ]);
    }

    public function orderIndex(Request $request){

        $choose = CartChoose::where('user_id', auth('api')->user()->id)->latest()->first();

        $order = Order::with('product')->where('cart_id',$choose->user_id)->where('user_id',auth('api')->user()->id)->get();

        return response()->json([
            'data' =>$order
        ]);
    }

    public function orderStore(Request $request){
        $choose = CartChoose::where('user_id', auth('api')->user()->id)->latest()->first();

        $order = Order::create([
            'cart_id'=> $request->cart_id,
            'product_id'=>$request->product_id,
            'user_id'=> $choose->user_id,
            'weight'=> $request->weight,
            'price'=>$request->price,
        ]);

        return response()->json([
            'data' =>$order
        ]);
    }


}
