<?php

require_once "../include/Db.php";
class Product
{
    public static function getProductsList()
    {
        $pdo = Db::connect();

        // write sql
        $query = "select products.id,products.name from products";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getProductDetail($id)
    {

        $pdo = Db::connect();

        // write sql
        $query = "select products.*,categories.name as c_name,selling_prices.price from products 
                    join categories on categories.id = products.category_id
                    join selling_prices on selling_prices.product_id = products.id
                    where products.id = $id";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getProductById($id)
    {
        $pdo = Db::connect();

        $query = "select * from products where id = :id";

        $statement = $pdo->prepare($query);

        $statement->bindParam(":id", $id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getCategory()
    {
        $pdo = Db::connect();

        $query = "select categories.name,categories.id from categories where categories.parent != 0";

        $statement = $pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function saveProduct($product)
    {
        $pdo = Db::connect();

        $query = "insert into products (category_id,name,model,brand,color,shape,description,status) values (:category_id,:name,:model,:brand,:color,:shape,:description,:status)";

        $statement = $pdo->prepare($query);


        foreach ($product as $key => $value) {
            $statement->bindParam(":$key", $product[$key]);
        }

        if ($statement->execute()) {

            // prepare data for stocks
            $product_id = self::getProductsList();
            $forStock =
                [
                    "product_id" => $product_id[count($product_id) - 1]["id"],
                    "total_qty" => 0
                ];

            return self::createStock($forStock);
        }

        return false;
    }

    public static function updateProduct($id, $product)
    {
        $pdo = Db::connect();

        $query = "update products set category_id = :category_id,name = :name,price = :price,model = :model,brand = :brand,color = :color,shape = :shape,description = :description,status = :status where id = :id";
        $statement = $pdo->prepare($query);

        $statement->bindParam(":category_id", $product["category_id"]);
        $statement->bindParam(":name", $product["name"]);
        $statement->bindParam(":price", $product["price"]);
        $statement->bindParam(":model", $product["model"]);
        $statement->bindParam(":brand", $product["brand"]);
        $statement->bindParam(":color", $product["color"]);
        $statement->bindParam(":shape", $product["shape"]);
        $statement->bindParam(":description", $product["description"]);
        $statement->bindParam(":status", $product["status"]);
        $statement->bindParam(":id", $id);

        return $statement->execute();
    }

    public static function deleteProduct($id)
    {
        $pdo = Db::connect();

        $query = "delete from products where id = :id";

        $statement = $pdo->prepare($query);

        $statement->bindParam(":id", $id);

        return $statement->execute();
    }

    private static function createStock($data)
    {
        $pdo = Db::connect();

        $query = "insert into stocks (product_id,total_qty) values (:product_id,:total_qty)";

        $statement = $pdo->prepare($query);

        foreach ($data as $key => $vale) {
            $statement->bindParam(":$key", $data[$key]);
        }

        return $statement->execute();
    }
}
