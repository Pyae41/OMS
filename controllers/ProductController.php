<?php

require_once '../models/Product.php';
class ProductController
{
    public function getProducts(){
        $products = Product::getProductsList();

        return $products;
    }

    public function getProduct($id){
        $product = Product::getProductDetail($id);

        return $product;
    }

    public function getProductById($id){
        return Product::getProductById($id);
    }
    public function getCategories(){
        return Product::getCategory();
    }
    public function saveProduct($product){

        return Product::saveProduct($product);
    }
    public function updateProduct($id,$product){
        return Product::updateProduct($id, $product);
    }

    public function deleteProduct($id){
        return Product::deleteProduct($id);
    }
}
