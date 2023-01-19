<?php

include_once "../include/Db.php";

class Customer
{

    public static function getCustomerList()
    {
        $pdo = Db::connect();
        // write sql
        $query = "select * from customers";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function saveCustomer($customer){

        $pdo = Db::connect();

        $query = "insert into customers (name,phone,address,email) values (:name,:phone,:address,:email)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $customer["name"]);
        $statement->bindParam(":phone", $customer["phone"]);
        $statement->bindParam(":address", $customer["address"]);
        $statement->bindParam(":email", $customer["email"]);
        $result = $statement->execute();

        return $result;
    }
    public static function deleteCustomer($id){

        $pdo = Db::connect();

        $query = "delete from customers where id = $id";
        $statement = $pdo->prepare($query);

        $result = $statement->execute();

        return $result;
    }

    public static function getCustomerById($id){

        $pdo = Db::connect();

        $query = "select * from customers where id = $id";

        $statement = $pdo->query($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function updateCustomer($id,$customer){
        $pdo = Db::connect();

        $query = "update customers set name=:name,phone=:phone,address=:address,email=:email where id = $id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $customer["name"]);
        $statement->bindParam(":phone", $customer["phone"]);
        $statement->bindParam(":address", $customer["address"]);
        $statement->bindParam(":email", $customer["email"]);
        $result = $statement->execute();

        return $result;
    }
}
