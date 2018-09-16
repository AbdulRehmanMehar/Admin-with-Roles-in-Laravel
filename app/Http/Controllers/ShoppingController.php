<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use App\User;
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

    private function getFreeAdmins(){
        $users = User::where(['isAdmin' => true, 'role' => 'order'])->get(); // Just Getting Order Managers.....
        $return = User::where(['isAdmin' => true, 'role' => 'mainAdmin'])->first(); // Just in case of no free admin
        foreach($users as $user){
            if($user->orders == ""){
                $return = $user;
                break; // Exit the loop if admin is found.....
            }
            if(count(explode(" ", $user->orders)) < 2){
                $return = $user;
                break; // Exit the loop if admin is found.....
            }
        }
        return $return;
    }

    private function setAdminOrders($user_id, $order_id){
        $user = User::where('_id', $user_id)->first();
        if($user->orders == ""){
            $user->orders = "$order_id";
        }else{
            if($user->role == "mainAdmin"){
                $user->orders = $user->orders . " $order_id";
            }elseif(count(explode(" ", $user->orders)) < 2){
                $user->orders = $user->orders . " $order_id";
            }
        }
        $user->save();
    }

    public function checkout(Request $request){
        // converts the Cart content from array to string to store it
        $cart = (string)(Cart::content());
        $order = Order::create([
            'cart' => $cart,
            'user_id' => Auth::user()->id,
            'state' => 0,
            'staff_id' => 0,
            'admin' => $this->getFreeAdmins()->_id
        ]);
        $this->setAdminOrders($order->admin, $order->_id);
        Cart::destroy();
        foreach(Cart::content() as $cartB){
            Cart::remove($cartB->id);
        }
        return redirect()->back();


    }


}
