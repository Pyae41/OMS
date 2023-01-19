<?php

require_once "../models/Category.php";

class CategoryController
{
    public function getCategories()
    {
        $categories = Category::getCategoriesList();

        return $categories;
    }

    public function getCategoryById($id)
    {
        $result = Category::getCategoryById($id);

        return $result;
    }

    public function saveCategory($category, $parent)
    {
        $category = Category::saveCategory($category, $parent);

        return $category;
    }

    public function getParents()
    {
        // filter parent data
        $parents = array_values(array_filter($this->getCategories(), function ($value) {
            return $value["parent"] == 0;
        }));

        return $parents;
    }

    public function updateCategory($id, $name, $parent)
    {
        $result = Category::updateCategory($id, $name, $parent);

        return $result;
    }

    public function deleCategory($id){
        try{
            return Category::deleteCate($id);
        }
        catch(PDOException $e){
            return false;
        }
    }
}
