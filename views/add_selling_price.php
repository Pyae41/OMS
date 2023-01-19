<?php
include_once "./layouts/header.php";
require_once "../controllers/StockController.php";


$stockController = new StockController();
$products = $stockController->getProducts();

if (isset($_POST["add"])) {
    $arr = [];
    $success = true;
    foreach ($_POST as $key => $value) {
        $arr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    // check array's value is null or not
    foreach ($arr as $key => $value) {
        if (is_null($arr[$key])) {
            $success = false;
        }
    }

    if ($success) {
        array_pop($arr);
    
        $result = $stockController->addSellingPrices($arr);
        if ($result) {
            echo "
            <script>
            window.location.href = 'http://localhost/OrderManagementSystem/views/stocks.php';
            </script>
            ";
        }
    }
}
?>

<div class="container">
    <h3>Add Stocks</h3>
    <a href="stocks.php" class="btn btn-primary">Back</a>

    <form class="w-50 mx-auto" method="post" action="">
        <div class="form-group">
            <label for="" class="form-label">Product</label>
            <select name="product_id" id="" class="form-control">
                <?php
                foreach ($products as $product) {
                    echo "<option value='" . $product["id"] . "'>" . $product["name"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="" class="form-label">Selling price</label>
            <input type="text" name="price" class="form-control">
        </div>

        <div class="form-group">
            <label for="" class="form-label">Date</label>
            <input type="date" name="date" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100" name="add">Add Price</button>
    </form>
</div>



<?php
include_once "./layouts/footer.php";
?>