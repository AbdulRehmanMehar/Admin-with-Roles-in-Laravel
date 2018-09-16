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
            if($user->orders == ""){
                $return = $user;
                break; // Exit the loop if admin is found.....
            }
            if(count(explode(" ", $user->orders)) < 2){ // limit of order foreach user
                $return = $user;
                break; // Exit the loop if admin is found.....
            }
        }
        return $return;
    }

    private function setAdminOrders($user_id = "", $order_id, $order_process){
        $user = User::where('_id', $user_id)->first();
        $order = Order::where('_id', $order_id)->first();
        $order->process = $order_process;
        $order->admin = ($order_process == "Product Delivered") ? "" : $user->_id;
        if($order_process != "Product Delivered"){
            if(strpos($user->orders , $order_id) !== false){
                return false;
            }
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
        $order->save();
    }
    private function removeAdminOrders($user_id, $order_id){
        $user = User::where('_id', $user_id)->first();
        $tmp = ltrim(rtrim(str_replace($order_id, "", $user->orders), " ") , " ");

        $user->orders = $tmp;
        $user->save();
    }

    public function completeOrder(Request $request)
    {
        $user_role = $request->user_role;
        $process;
        $admin;

        if($user_role == 'order'){
            $process = 'Order Confirmed';
            $admin = $this->getFreeAdmins('shipping'); // After Order Complition , Search for Shipping Manager
        }elseif($user_role == 'shipping'){
            $process = 'Product Shipped';
            $admin = $this->getFreeAdmins('delivery'); // After Shipping Complition , Search for Delivery Manager
        }elseif($user_role == 'delivery'){
            $process = 'Product Delivered';
        }
        $this->removeAdminOrders($request->user_id, $request->order_id);
        if($user_role != 'delivery'){
            $this->setAdminOrders($admin->_id, $request->order_id, $process);
        }else{
            $this->setAdminOrders("", $request->order_id, $process);
        }
        return redirect()->route('admin.home');
    }
}
