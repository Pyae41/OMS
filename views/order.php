<?php
include_once "layouts/header.php";
require_once "../controllers/OrderController.php";

$orderController = new OrderController();
$orders = $orderController->getOrders();
?>

<div class="container">
    <h3>Orders</h3>
    <a href="create_order.php" class="btn btn-success mb-3">Add new order</a>

    <!-- <button class="btn btn-primary" id="print_btn">Print</button>

    <iframe id="print-iframe" width="0" height="0" hidden></iframe> -->
    <div class="row" id="printArea">
        <table class="table border table-striped text-center">
            <thead class="bg-dark text-white">
                <th>Id</th>
                <th>Order id</th>
                <th>Customer Name</th>
                <th>Detail</th>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($orders as $order) {
                    echo "<tr>
                            <td>" . $count++ . "</td>
                            <td>" . $order['id'] . "</td>
                            <td>" . $order['name'] . "</td>
                            <td>
                                <a href='order-detail.php?id=".$order["id"]."' class='btn btn-info text-white'>Details</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include_once "layouts/footer.php";
?>