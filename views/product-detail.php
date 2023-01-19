<?php
include_once "layouts/header.php";
require_once "../controllers/ProductController.php";

$productController = new ProductController();
$product = $productController->getProduct($_GET["id"]);

$latest_prices = $product[count($product) - 1];
?>

<div class="container">
    <h3>Product Details</h3>
    <a href="<?php echo $_SERVER["HTTP_REFERER"];?>" class="btn btn-primary">Back</a>
    <div class="card w-50 mx-auto">
        <div class="card-title">
            <h4 class="text-center mt-3">
                <?php echo $latest_prices["name"]; ?>
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h5>Model: <?php echo $latest_prices["model"] ?></h5>
                    <h5>Brand: <?php echo $latest_prices["brand"] ?></h5>
                    <h5>Price: <?php echo $latest_prices["price"] ?> MMK</h5>
                </div>
                <div class="col-6">
                    <h5>Color: <?php echo $latest_prices["color"] ?></h5>
                    <h5>Status: <?php echo $latest_prices["status"] ?></h5>
                    <h5>Category: <?php echo $latest_prices["c_name"] ?></h5>
                </div>
                <div class="col-12">
                    <h5 class="text-center">Description</h5>
                    <p>
                        <?php echo $latest_prices["description"] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once "layouts/footer.php";
?>