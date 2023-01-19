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
    <a href="order.php" class="btn btn-primary d-inline">Back</a>
    <button class="btn btn-warning text-dark" id="print_btn" type="submit">Print</button>
    <iframe src="" frameborder="0" hidden id="print-iframe"></iframe>

    <div id="printArea">
        <div class="container mt-4">
            <h1 style="text-align: center;">Order Management Voucher</h1>
            <div class="row" style="display: flex; width: 100%; margin-top:50px;">
                <div class="col-6" id="left">
                    <h3>
                        Order Id: <?php echo $order_cus_detail["id"] ?>
                    </h3>
                    <h3>
                        Customer Name: <?php echo $order_cus_detail["name"] ?>
                    </h3>
                    <h3>
                        Address: <?php echo $order_cus_detail["address"] ?>
                    </h3>
                </div>
                <div class="col-6" id="right">
                    <h3 class="text-right">
                        Email : <?php echo $order_cus_detail["email"] ?>
                    </h3>
                    <h3 class="text-right">
                        Phone: <?php echo $order_cus_detail["phone"] ?>
                    </h3>
                    <h3 class="text-right">
                        Date: <?php echo $order_cus_detail["order_date"] ?>
                    </h3>
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
                    echo "<tr style='text-align: center;'>
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
        <h2 class="text-right" style="text-align: right;">Total: <?php echo $total; ?></h2>
    </div>
</div>

<?php
include_once "layouts/footer.php";
?>