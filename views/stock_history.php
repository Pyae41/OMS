<?php
include_once "./layouts/header.php";
require_once "../controllers/StockController.php";

$stockController = new StockController();
$stocks = $stockController->getHistory();

// add id for display
for ($i = 1; $i <= count($stocks); $i++) {
    $stocks[$i - 1] += ["d_id" => $i];
}

?>

<div class="container">
    <h3>History</h3>
    <a href="stocks.php" class="btn btn-primary mb-3">Back</a>

    <div class="row">
        <table class="table table-striped text-center">
            <thead class="bg-dark text-white">
                <th>Id</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit price</th>
                <th>Date</th>
            </thead>
            <tbody>
                <?php
                foreach ($stocks as $stock) {
                    echo "<tr>";
                    echo "<td>" . $stock["d_id"] . "</td>";
                    echo "<td>" . $stock["name"] . "</td>";
                    echo "<td>" . $stock["qty"] . "</td>";
                    echo "<td>" . $stock["unit_price"] . "</td>";
                    echo "<td>" . $stock["date"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



<?php
include_once "./layouts/footer.php";
?>