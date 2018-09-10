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

    public function completeOrder(Request $request)
    {
        $order = Order::find($request->order_id)->first();
        $user_role = $request->user_role;
        $process;
        if($user_role == 'order'){
            $process = 'Order Confirmed';
        }elseif($user_role == 'shipping'){
            $process = 'Product Shipped';
        }elseif($user_role == 'delivery'){
            $process = 'Product Delivered';
        }

        $order->process = $process;
        $order->save();
        return redirect()->route('admin.home');
    }
}
