<?php
include_once "./layouts/header.php";
require_once "../controllers/StockController.php";

$stockController = new StockController();
$stocks = $stockController->getStocks();
$selling_prices = $stockController->getSellingPrices();

// add id for display
for ($i = 1; $i <= count($stocks); $i++) {
    $stocks[$i - 1] += ["d_id" => $i];
}

for ($i = 1; $i <= count($selling_prices); $i++) {
    $selling_prices[$i - 1] += ["d_id" => $i];
}

?>

<div class="container">
    <h3>Stocks</h3>
    <a href="add_stock.php" class="btn btn-success mb-3">Add new stock</a>
    <a href="add_selling_price.php" class="btn btn-success mb-3">Add selling price</a>
    

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a data-toggle="tab" href="#stocks" class="nav-link active">Stocks</a>
        </li>
        <li class="nav-item">
            <a data-toggle="tab" href="#selling_prices" class="nav-link">Selling prices</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="stocks" class="tab-pane active">
            <div class="row mt-3">
                <a href="stock_history.php" class="btn btn-facebook mb-3 mt-3">History</a>
                <table class="table table-striped text-center">
                    <thead class="bg-dark text-white">
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($stocks as $stock) {
                            echo "<tr>";
                            echo "<td>" . $stock["d_id"] . "</td>";
                            echo "<td>" . $stock["name"] . "</td>";
                            echo "<td>" . $stock["total_qty"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="selling_prices" class="tab-pane fade in">
            <div class="row mt-3">
                <table class="table table-striped text-center">
                    <thead class="bg-dark text-white">
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($selling_prices as $selling) {
                            echo "<tr>";
                            echo "<td>" . $selling["d_id"] . "</td>";
                            echo "<td>" . $selling["name"] . "</td>";
                            echo "<td>" . $selling["price"] . "</td>";
                            echo "<td>" . $selling["date"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <?php
    include_once "./layouts/footer.php";
    ?>