<?php

require_once "../models/Order.php";

class OrderController
{
    public function getOrders(){
        $orders = Order::getOrdersList();

        return $orders;
    }
    public function getOrderCustomer($id){
        $order = Order::getOrderCustomer($id);

        return $order;
    }

    public function getOrderDetails($id){
        $order = Order::getOrderDetails($id);

        return $order;
    }

    public function createOrders($data){
        return Order::createOrder($data);
    }
}
