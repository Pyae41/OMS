<?php
include_once "layouts/header.php";
require_once "../controllers/OrderController.php";

$orderController = new OrderController();

// for customer detail from orders
$order_cus_detail = $orderController->getOrderCustomer($_GET["id"]);

// for order details
$order_details = $orderController->getOrderDetails($_GET["id"]);

?>

<div class="container">
    <h3>Order Details</h3>
    <a href="order.php" class="btn btn-primary mb-3">Back</a>

    <button type="submit" class="btn btn-primary" onclick="onPrint()">Print Voucher</button>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h5>
                    Order Id: <?php echo $order_cus_detail["id"] ?>
                </h5>
                <h5>
                    Customer Name: <?php echo $order_cus_detail["name"] ?>
                </h5>
                <h5>
                    Address: <?php echo $order_cus_detail["address"] ?>
                </h5>
            </div>
            <div class="col-6">
                <h5 class="text-right">
                    Email : <?php echo $order_cus_detail["email"] ?>
                </h5>
                <h5 class="text-right">
                    Customer Name: <?php echo $order_cus_detail["phone"] ?>
                </h5>
                <h5 class="text-right">
                    Date: <?php echo $order_cus_detail["order_date"] ?>
                </h5>
            </div>
        </div>

    </div>

    <table class="table mt-3 table-bordered table-striped text-center">
        <thead class="bg-dark text-white">
            <th>Id</th>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $total = 0;
            foreach ($order_details as $order_detail) {
                $sub_total = $order_detail['price'] * $order_detail["qty"];
                $total += $sub_total;
                echo "<tr>
                        <td>" . $count++ . "</td>
                        <td>" . $order_detail['name'] . "</td>
                        <td>" . $order_detail['price'] . "</td>
                        <td>" . $order_detail['qty'] . "</td>
                        <td>" . ($order_detail['price'] * $order_detail["qty"]) . "</td>
                    </tr>";
            }

            ?>
        </tbody>
    </table>
    <h2 class="text-right">Total: <?php echo $total; ?></h2>
</div>

<?php
include_once "layouts/footer.php";
?>