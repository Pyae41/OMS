<?php

include_once "../models/Customer.php";

class CustomerController
{
    public function getCustomers(){
        $customer = Customer::getCustomerList();
        return $customer;
    }

    public function saveCustomer($arr){
        $result = Customer::saveCustomer($arr);

        return $result;
    }
    public function updateCustomer($id,$customer){
        $result = Customer::updateCustomer($id, $customer);

        return $result;
    }
    public function getCustomerById($id){
        $result = Customer::getCustomerById($id);

        return $result;
    }
    public function deleteCustomer($id){
        $result = Customer::deleteCustomer($id);

        return $result;
    }
}
