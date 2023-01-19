<?php

require_once 'Product.php';
require_once '../include/Db.php';

class Stock
{

    public static function getStks()
    {
        $pdo = Db::connect();

        $query = "SELECT *,products.name FROM stocks
                    JOIN products ON products.id = stocks.product_id";

        $statement = $pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProducts()
    {
        $pdo = Db::connect();

        $query = "select products.id,products.name from products";

        $statement = $pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addStks($data)
    {

        $pdo = Db::connect();

        $query = "INSERT INTO `stocks_history`(`product_id`, `qty`, `unit_price`, `date`) VALUES (:product_id,:qty,:unit_price,:date)";

        $statement = $pdo->prepare($query);

        // selling data
        $selling_data = [
            "product_id" => $data["product_id"],
            "price" => $data["price"],
            "date" => $data["date"]
        ];

        unset($data["price"]);

        foreach ($data as $key => $value) {
            $statement->bindParam(":" . $key, $data[$key]);
        }

        if($statement->execute() && self::addSellingP($selling_data)){

            $query1 = "SELECT stocks_history.product_id, SUM(qty) as total_qty 
            FROM stocks_history 
            WHERE stocks_history.product_id=:product_id
            GROUP BY product_id";

            $statement1 = $pdo->prepare($query1);

            $statement1->bindParam(":product_id", $data["product_id"]);

            $statement1->execute();

            $result = $statement1->fetch(PDO::FETCH_ASSOC);

            if(count($result) > 0){
                return self::addTotalStock($result);
            }
        }

        return false;
    }

    public static function getStkHis(){
        $pdo = Db::connect();

        $query = "select stocks_history.*,products.name from stocks_history join products on products.id = stocks_history.product_id";

        $statment = $pdo->prepare($query);

        $statment->execute();

        return $statment->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Selling prices
    public static function getSellP(){
        $pdo = Db::connect();

        $query = "select selling_prices.product_id,selling_prices.price,selling_prices.date,products.name from selling_prices
                    join products on products.id = selling_prices.product_id";

        $statment = $pdo->prepare($query);

        $statment->execute();

        return $statment->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function addSellingP($data){
        $pdo = Db::connect();

        $query = "insert into selling_prices (product_id,price,date) values (:product_id,:price,:date)";

        $statement = $pdo->prepare($query);

        foreach($data as $key => $value){
            $statement->bindParam(":$key", $data[$key]);
        }
        
        return $statement->execute();
    }

    public static function addTotalStock($data){

        $query = "UPDATE stocks set total_qty=:total_qty WHERE product_id = :product_id";

        $pdo = Db::connect();

        $statement = $pdo->prepare($query);

        foreach($data as $key => $value){
            $statement->bindParam(":$key",$data[$key]);
        }

        return $statement->execute();

    }
}
