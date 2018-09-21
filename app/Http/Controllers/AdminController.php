<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Product;
use App\OrdersHandler;
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

    public function completeOrder(Request $request)
    {
        $user_role = $request->user_role;
        $process;
        $admin;
        $OrdersHandler = new OrdersHandler; // Seperated functions into class App\OrdersHandler
        if($user_role == 'order'){
            $process = 'Order Confirmed';
            $admin = $OrdersHandler->getFreeAdmins('shipping'); // After Order Complition , Search for Shipping Manager
        }elseif($user_role == 'shipping'){
            $process = 'Product Shipped';
            $admin = $OrdersHandler->getFreeAdmins('delivery'); // After Shipping Complition , Search for Delivery Manager
        }elseif($user_role == 'delivery'){
            $admin = "blah"; // to get passed in if statement
            $process = 'Product Delivered';
        }

        if($admin != ''){ // If free admin is found, execute this code else pend the order 
            if($user_role != 'delivery'){
                $OrdersHandler->setAdminOrders($admin->_id, $request->order_id, $process); // Assigns Orders to admins
            }else{
                $OrdersHandler->setAdminOrders("",$request->order_id, $process); // For delivery manager , no next admin is needed because we don't need to process order anymore.
            }
        }else{
            $OrdersHandler->setPending($request->order_id, $process); // If no admin is free , set order as pending
        }

        $OrdersHandler->removeAdminOrders($request->user_id, $request->order_id); // Remove old admin
        $OrdersHandler->assignPending($user_role); // After each order complition , check for pending orders and assign to free admins

        return redirect()->route('admin.orders.manage');
    }
}
