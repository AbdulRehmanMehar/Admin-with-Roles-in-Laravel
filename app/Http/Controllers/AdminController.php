<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('PreventBackHistory');
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }
    public function index(){
        return view('admin.home');
    }

    public function createProduct()
    {
        // Returns the products create page
        return view('admin.createProduct');
    }


    public function storeProduct(Request $request)
    {
        // inserts newly created products to the db after validation

        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image'
        ]);

        // creates new instance of product model
        $product = new Product;

        // handles image creation and prevents duplicates
        $product_image = $request->image;
        $product_image_new_name = time(). $product_image->getClientOriginalName();
        $product_image->move('uploads/products', $product_image_new_name);

        // gets the values to be saved in the database
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = 'uploads/products/'. $product_image_new_name;

        $product->save();
        return redirect()->route('admin.home');


    }

    public function manageOrder()
    {
        $users = User::all();
        $orders = Order::all();
        return view('admin.manageOrder')->with(['orders'=> $orders, 'users' => $users]);
    }

    private function getFreeAdmins($user_role){
        $users = User::where(['isAdmin' => true, 'role' => $user_role])->get();
        $return = User::where(['isAdmin' => true, 'role' => 'mainAdmin'])->first(); // Just in case of no free admin
        foreach($users as $user){
            if(count(explode(" ", $user->orders)) < 3){
                $return = $user;
                break; // Exit the loop if admin is found.....
            }
        }
        return $return;
    }

    private function setAdminOrders($user_id, $order_id){
        $user = User::where('_id', $user_id)->first();
        if(strpos($user->orders , $order_id) !== false){
            return false;
        }
        if($user->orders == ""){
            $user->orders = "$order_id";
        }else{
            if($user->role == "mainAdmin"){
                $user->orders = $user->orders . " $order_id";
            }elseif(count(explode(" ", $user->orders)) < 3){
                $user->orders = $user->orders . " $order_id";
            }
        }
        $user->save();
    }
    private function removeAdminOrders($user_id, $order_id){
        $user = User::where('_id', $user_id)->first();
        $order = $user->orders;
        $tmp = str_replace($order_id, "", $order);
        $user->orders = $tmp;
        $user->save();
    }

    public function completeOrder(Request $request)
    {
        $order = Order::find($request->order_id)->first();
        $user_role = $request->user_role;
        $process;
        $admin;

        if($user_role == 'order'){
            $process = 'Order Confirmed';
            $admin = $this->getFreeAdmins('shipping'); // After Order Complition , Search for Shipping Manager
            $this->setAdminOrders($admin->_id, $order->_id);
        }elseif($user_role == 'shipping'){
            $process = 'Product Shipped';
            $admin = $this->getFreeAdmins('delivery'); // After Shipping Complition , Search for Delivery Manager
            $this->setAdminOrders($admin->_id, $order->_id);
        }elseif($user_role == 'delivery'){
            $admin = ""; // At this point, Order is Delivered so no need to worry about admin.
            $process = 'Product Delivered';
        }
        $order->admin = $admin->_id;
        $order->process = $process;
        $order->save();
        $this->removeAdminOrders($request->user_id, $request->order_id);
        return redirect()->route('admin.home');
    }
}
