<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use App\Order;
use App\Product;
use Auth;
use DB;

class ShoppingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_to_cart(){

        $pdt = Product::find(request()->product_id);

        $cartItem = Cart::add([
            'id' => $pdt->id,
            'name' => $pdt->name,
            'qty' => request()->qty,
            'price' => $pdt->price

        ]);

        Cart::associate($cartItem->rowId, 'App\Product');

        return redirect()->route('cart');

    }

    public function cart_save(){

            Cart::store(Auth::user()->id);

            return view('cart');

    }

    public function cart(){

        Cart::restore(Auth::user()->id);

        return view('cart');

    }

    public function cart_delete($id){
        Cart::remove($id);
        return redirect()->back();
    }

    public function checkout(Request $request){
        // converts the Cart content from array to string to store it
         $cart = (string)(Cart::content());

        Order::create([
            'cart' => $cart,
            'user_id' => Auth::user()->id,
            'state' => 0,
            'staff_id' => 0,
        ]);
        Cart::destroy();
        foreach(Cart::content() as $cartB){
            Cart::remove($cartB->id);
        }
        return redirect()->back();


    }


}
