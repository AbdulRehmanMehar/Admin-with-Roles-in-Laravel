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

    public function getFreeAdmins($user_role){
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

    public function setAdminOrders($user_id = "", $order_id, $order_process){
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
    public function removeAdminOrders($user_id, $order_id){
        $user = User::where('_id', $user_id)->first();
        $tmp = ltrim(rtrim(str_replace($order_id, "", $user->orders), " ") , " ");

        $user->orders = $tmp;
        $user->save();
    }


    public function setPending($order_id, $process)
    {
        $order = Order::where('_id', $order_id)->first();
        $order->process = $process;
        $order->admin = '';
        $order->pending = true;
        $order->save();
    }

    public function assignPending($user_role){
        $process;
        if($user_role == 'order'){
            $process = '';
        }elseif($user_role == 'shipping'){
            $process = 'Order Confirmed';
        }elseif($user_role == 'delivery'){
            $process = 'Product Shipped';
        }

        $admin = ($this->getFreeAdmins($user_role) == '') ? '' : $this->getFreeAdmins($user_role);
        $order = Order::where(['process' => $process ,'pending' => true])->first();
        if($admin != '' && $order != ''){
            $order->admin = $admin->_id;
            $order->pending = false;
            $order->save();
        }
    }

}
