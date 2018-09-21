<?php

namespace App;

use App\User;
use App\Order;

/**
 * Orders Handler
 */
class OrdersHandler
{

    function __construct()
    {
        // code...
    }

    public function getFreeAdmins($user_role) // Returns a free admin i.e admin with orders < 2
    {
        $users = User::where(['isAdmin' => true, 'role' => $user_role])->get();
        $return = '';
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

    public function setAdminOrders($user_id = "", $order_id, $order_process) // Set Ordes to admins
    {
        $user = User::where('_id', $user_id)->first();
        $order = Order::where('_id', $order_id)->first();
        $order->process = $order_process;
        $order->pending = false;
        $order->admin = ($order_process == "Product Delivered") ? "" : $user->_id;
        $order->admin_type = ($order_process == "Product Delivered") ? "" : $user->role;
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
    public function removeAdminOrders($user_id, $order_id) // After Order complition , it removes past order_admin
    {
        $user = User::where('_id', $user_id)->first();
        $tmp = ltrim(rtrim(str_replace($order_id, "", $user->orders), " ") , " ");

        $user->orders = $tmp;
        $user->save();
    }


    public function setPending($order_id, $process) // If no admin is free , it sets order as pending
    {
        $admin_type;
        if($process == ''){
            $admin_type = 'order';
        }elseif($process == 'Order Confirmed'){
            $admin_type = 'shipping';
        }elseif($process == 'Product Shipped'){
            $admin_type = 'delivery';
        }
        $order = Order::where('_id', $order_id)->first();
        $order->process = $process;
        $order->admin = '';
        $order->pending = true;
        $order->admin_type = $admin_type;
        $order->save();
    }

    public function assignPending($user_role) // It assigns pending orders to free admins
    {
        $admin = $this->getFreeAdmins($user_role);
        $order = Order::where('pending' , true)->first();
        if($admin != '' && $order != '' && $admin->role == $order->admin_type){
            $this->setAdminOrders($admin->_id,$order->_id, $order->process);
        }
    }

}
