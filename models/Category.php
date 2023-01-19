<?php

include "../include/Db.php";

class Category
{
    public static function getCategoriesList()
    {
        $pdo = Db::connect();

        // write sql
        $query = "select * from categories";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function saveCategory($category, $parent)
    {

        $pdo = Db::connect();

        $query = "insert into categories (name,parent) values (:category,:parent)";

        $statement = $pdo->prepare($query);

        $statement->bindParam(":category", $category);
        $statement->bindParam(":parent", $parent);
        $result = $statement->execute();

        return $result;
    }
    public static function getCategoryById($id)
    {
        $pdo = Db::connect();

        $query = "select * from categories where id = $id";

        $statement = $pdo->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateCategory($id, $name, $parent)
    {
        $pdo = Db::connect();

        $query = "update categories set name=:name,parent=:parent where id = :id";

        $statement = $pdo->prepare($query);

        $statement->bindParam(":id", $id);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":parent", $parent);

        return $statement->execute();
    }

    public static function deleteCate($id)
    {
        $pdo = Db::connect();

        $check = self::checkExist($id);

        if ($check !== true) {
            $query = "delete from categories where id=:id";

            $statement = $pdo->prepare($query);

            $statement->bindParam(":id", $id);

            return $statement->execute();
        }

        return false;
    }

    private static function checkExist($id)
    {
        $pdo = Db::connect();

        $query = "select * from categories where parent = :id";

        $statement = $pdo->prepare($query);

        $statement->bindParam(":id", $id);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return true;
        }

        return false;
    }
}
