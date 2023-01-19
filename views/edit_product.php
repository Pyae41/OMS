<?php
include "layouts/header.php";
require_once "../controllers/ProductController.php";

$productController = new ProductController();
$categories = $productController->getCategories();
$product = $productController->getProductById($_GET["id"]);


if (isset($_POST["submit"])) {
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
        $result = $productController->updateProduct($_GET["id"],$arr);

        if ($result) {
            echo "
            <script>
            window.location.href = 'http://localhost/OrderManagementSystem/views/product.php';
            </script>
            ";
        }
    }
}
?>
<div class="container">
    <h3>Edit Product</h3>
    <a href="product.php" class="btn btn-primary">Back</a>

    <form action="" class="form w-50 mx-auto" method="post">
        <div class="form-group">
            <for class="form-label">
                Name
            </for>
            <input type="text" name="name" id="" class="form-control" value="<?php echo $product["name"]; ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Category
            </for>
            <select name="category_id" id="" class="form-control">
                <?php
                foreach ($categories as $category) {
                    if($category["id"] == $product["category_id"])
                    {
                        echo "<option value='" . $category["id"] . "' selected>" . $category["name"] . "</option>";
                    }
                    else{
                        echo "<option value='" . $category["id"] . "'>" . $category["name"] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <for class="form-label">
                Price
            </for>
            <input type="text" name="price" id="" class="form-control" value="<?php echo $product["price"]; ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Model
            </for>
            <input type="text" name="model" id="" class="form-control" value="<?php echo $product["model"]; ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Brand
            </for>
            <input type="text" name="brand" id="" class="form-control" value="<?php echo $product["brand"]; ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Color
            </for>
            <input type="text" name="color" id="" class="form-control" value="<?php echo $product["color"] ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Shape
            </for>
            <input type="text" name="shape" id="" class="form-control" value="<?php echo $product["shape"]; ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Description
            </for>
            <textarea name="description" class="form-control"><?php echo $product["description"]; ?></textarea>
        </div>
        <div class="form-group">
            <for class="form-label">
                Status
            </for>
            <input type="text" name="status" id="" class="form-control" value="<?php echo $product["status"]; ?>">
        </div>
        <button type="submit" class="btn btn-success w-100" name="submit">Update</button>
    </form>
</div>

<?php
include "layouts/footer.php";
?>