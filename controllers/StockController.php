<?php

require_once '../models/Stock.php';

class StockController
{
    // Stock
    public function getStocks(){
        return Stock::getStks();
    }
    public function getProducts(){
        return Stock::getProducts();
    }

    public function addStocks($data){
        return Stock::addStks($data);
    }

    public function getHistory(){
        return Stock::getStkHis();
    }

    // Stock

    // Selling prices
    public function getSellingPrices(){
        return Stock::getSellP();
    }

    public function addSellingPrices($data){
        return Stock::addSellingP($data);
    }
}
