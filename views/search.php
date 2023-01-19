<?php

require_once '../controllers/CustomerController.php';
require_once '../controllers/StockController.php';


$customerController = new CustomerController();
$customers = $customerController->getCustomers();

$stockController = new StockController();
$products = $stockController->getSellingPrices();

// search custoemr
if (isset($_POST["cus_id"])) {

    $customer = searchCus($_POST["cus_id"], $customers);
    if (count($customer) > 0) {
        echo json_encode($customer);
    } else {
        echo "Not found";
    }
}

function searchCus($id, $data)
{
    foreach ($data as $cus) {
        if ($cus["id"] == $id) {
            return $cus;
        }
    }

    return $data = [];
}
// search customer

// search product

if (isset($_POST["pro_id"])) {

    $pro_id = $_POST["pro_id"];
    $product = searchPro($pro_id, $products);
    if (count($product) > 0) {
        echo json_encode($product);
    } else {
        echo "Not found";
    }
}
function searchPro($id,$products){
    $data = [];
    foreach($products as $pro){
        if($pro["product_id"] == $id){
            array_push($data,$pro);
        }
    }

    return (count($data) > 0) ? $data[count($data) - 1] : $data;
}
// search product