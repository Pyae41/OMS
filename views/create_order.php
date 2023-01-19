<?php

include "layouts/header.php";
require_once "../controllers/ProductController.php";
require_once "../controllers/CustomerController.php";
require_once "../controllers/OrderController.php";

$productController = new ProductController();
$products = $productController->getProducts();

$customerController = new CustomerController();
$customers = $customerController->getCustomers();

$orderController = new OrderController();

$date = date('Y-m-d');

if (isset($_POST["add"])) {

    $success = true;

    if ($_POST["customer_id"] == null) {
        $success = false;
    }

    if ($success) {

        // remove unwanted data
        unset($_POST["add"]);

        echo $confirm = "<script>confirm('Are you sure to order?');</script>";
        if ($confirm) {
            $result = $orderController->createOrders($_POST);
            // if ($result) {
            //     echo "
            //     <script>
            //     window.location.href = 'http://localhost/OrderManagementSystem/views/order.php';
            //     </script>
            //     ";
            // }
        }
    } else {
        echo "
             <script>
                alert('Please Select Customer');
             </script>
             ";
        echo "
             <script>
             window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
             </script>
             ";
    }
}

?>
<div class="container">
    <h3>Add Order</h3>
    <form action="" class="m-3" method="post" id="order-form">
        <div class="row">
            <div class="col-6">
                <a href="order.php" class="btn btn-primary d-inline">Back</a>
            </div>

            <div class="col-6">
                <div class="w-50 float-right">
                    <label for="" class="d-inline">Select Customer Customer:</label>
                    <select name="cus_id" id="customer_select" class="form-control">
                        <option value="0" disabled selected>Select Customer</option>
                        <?php
                        foreach ($customers as $customer) {
                            echo "<option value='" . $customer["id"] . "'>" . $customer["name"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col-6">
                        <h5>Customer ID:
                            <span id="customer_id">-------</span>
                            <input type="hidden" name="customer_id" id="hidden_cus_id">
                        </h5>
                        <h5>Name: <span id="name">-------</span></h5>
                        <h5>Address: <span id="address">-------</span></h5>
                    </div>
                    <div class="col-6">
                        <h5 class="text-right">Phone: <span id="phone">------</span></h5>
                        <h5 class="text-right">Email: <span id="email">------</span></h5>
                        <h5 class="text-right">Date: <?php echo $date; ?></h5>
                        <input type="hidden" name="date" value="<?php echo $date; ?>">
                    </div>
                </div>
            </div>

        </div>

        <table class="table mt-5 text-center" id="order-table">
            <thead>
                <th>
                    <a class="btn btn-success me-1" id="add_row">Add</span>
                </th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Remove</th>
            </thead>
            <tbody>
                <tr id="invoice_row mt-2">
                    <td style="width: 150px;"></td>
                    <td class="w-25">
                        <select name="product_id[]" id="product_select" class="form-control">
                            <option value="0" disabled selected>Select Product</option>
                            <?php
                            foreach ($products as $product) {
                                echo "<option value='" . $product["id"] . "'>" . $product["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td class="w-25">
                        <span>
                            <span id="product_name">------</span>
                        </span>
                    </td>
                    <td class="w-25">
                        <span class="text-muted">
                            <span id="unit_price">0</span> MMK
                        </span>
                    </td>
                    <td class="w-25">
                        <input type="text" name="qty[]" id="qty" class="form-control calculate w-25 mx-auto">
                        <small id="err_qty" class="text-danger"></small>
                    </td>
                    <td class="w-25">
                        <span class="text-muted mt-3">
                            <span id="subtotal">0</span> MMK
                        </span>
                    </td>
                    <td class="w-25">
                        <button class="btn btn-danger" id="del_row">X</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3 class="mt-5 float-right text-muted">Total : <span id="total" name="total">0</span> MMK</h3>
        <input type="hidden" name="total" id="hidden_total">

        <div class="form-group">
            <button class="btn btn-success" type="submit" name="add">Add Order</button>
        </div>
    </form>
</div>



<?php
include "layouts/footer.php";
?>