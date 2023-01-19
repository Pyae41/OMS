<?php

require_once "../include/Db.php";
require_once '../controllers/StockController.php';
class Order
{
    public static function getOrdersList()
    {
        $pdo = Db::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // write sql
        $query = "select orders.*,customers.name from orders join customers 
                    where orders.cus_id = customers.id";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getOrderCustomer($id)
    {

        $pdo = Db::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // write sql
        $query = "select orders.id,orders.order_date,customers.name,customers.phone,customers.email,customers.address
                    from orders 
                    join customers on orders.cus_id = customers.id
                    where orders.id = $id";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getOrderDetails($id)
    {
        $pdo = Db::connect();
        // write sql
        $query =   "select order_details.qty,order_details.product_id,order_details.qty,products.name,orders.order_date
                    from order_details 
                    join products on order_details.product_id = products.id
                    join orders on order_details.order_id = orders.id
                    where order_details.order_id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);


        // if(count($result) == 1){
        //     //return $result;
        // }
        // else{

        // }
        $arr = array();

        foreach($result as $r){
            $search = self::searchLatestPrice($r["product_id"]);

            // echo count($search);
            if($search["product_id"] == $r["product_id"]){
                $search["qty"] = $r["qty"];
                array_push($arr, $search);
            }
        }
    
        return $arr;
    }

    public static function createOrder($data)
    {

        $pdo = Db::connect();

        $query = "insert into orders (cus_id,total_qty,total_balance,order_date) values (:cus_id,:total_qty,:total_balance,:order_date)";

        // getting total qty
        $total_qty = array_reduce($data["qty"], function ($value1, $value2) {
            return $value1 + $value2;
        });

        $statment = $pdo->prepare($query);

        $statment->bindParam(":cus_id", $data["cus_id"]);
        $statment->bindParam(":total_qty", $total_qty);
        $statment->bindParam(":total_balance", $data["total"]);
        $statment->bindParam(":order_date", $data["date"]);

        if ($statment->execute()) {
            // remove unwanted data
            unset($data["total"]);
            unset($data["date"]);
            unset($data['cus_id']);

            // getting new order id
            $order_id = self::getOrderId();

            return self::createOrderDetails($order_id, $data);
        }

        return false;
    }

    private static function createOrderDetails($order_id, $data)
    {
        $pdo = Db::connect();

        $length = 0;
        // get length if product_id lenght and qty length
        if (count($data["product_id"]) == count($data["qty"])) {
            $length = count($data["product_id"]);
        }

        // prepare sql statement with looping
        $query = "insert into order_details (order_id,product_id,qty) values (:order_id,:product_id,:qty)";
        $statement = $pdo->prepare($query);
        $result = false;

        try {
            //$arr = array();
            if ($length == 1) {
                $statement->bindParam(":order_id", $order_id);
                $statement->bindParam(":product_id", $data["product_id"][$length - 1]);
                $statement->bindParam(":qty", $data["qty"][$length - 1]);

                $result =  $statement->execute();
            } else {


                foreach (range(0, $length - 1) as $index) {
                    //array_push($arr, "(" . $order_id .",". $data["product_id"][$index] . "," . $data['qty'][$index] . ")");
                    $statement->bindParam(":order_id", $order_id);
                    $statement->bindParam(":product_id", $data["product_id"][$index]);
                    $statement->bindParam(":qty", $data["qty"][$index]);
                    $result = $statement->execute();
                }
            }
            if ($result) {

                return self::updateStockQty($data);
            }
            //$query .= implode(",", $arr);

            //echo $query;

        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    public static function getOrderId()
    {
        $pdo = Db::connect();

        $query = "select * from orders";
        $statement = $pdo->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result[count($result) - 1]["id"];
    }

    public static function updateStockQty($data)
    {

        $length = 0;
        if (count($data["product_id"]) == count($data["qty"])) {
            $length = count($data["product_id"]);
        }

        $query = "update stocks set stocks.total_qty = (stocks.total_qty - :qty)
                    where stocks.product_id = :product_id";

        $pdo = Db::connect();

        $statement = $pdo->prepare($query);
        try {
            if ($length == 1) {
                $statement->bindParam(":product_id", $data["product_id"][0]);
                $statement->bindParam(":qty", $data["qty"][0]);

                return $statement->execute();
            } else {
                foreach (range(0, $length - 1) as $index) {
                    $statement->bindParam(":product_id", $data["product_id"][$index]);
                    $statement->bindParam(":qty", $data["qty"][$index]);
                    $statement->execute();
                }
                return true;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    private static function searchLatestPrice($id)
    {
        $stockController = new StockController();
        $prices = $stockController->getSellingPrices();

        $data = [];

        foreach ($prices as $price) {
            if ($price["product_id"] == $id) {
                array_push($data, $price);
            }
        }

        
        return (count($data) > 1) ? $data[count($data) - 1] : $data[0];
    }
}
