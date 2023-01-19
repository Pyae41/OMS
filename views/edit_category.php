<?php
include "layouts/header.php";
require_once "../controllers/CategoryController.php";

$categoryController = new CategoryController();
$parents = $categoryController->getParents();

$cat_id = $categoryController->getCategoryById($_GET["id"]);

if (isset($_POST["submit"])) {
    $success = true;
    $category = $_POST["name"] ?? "";
    $parent = $_POST["parent"];

    if (empty($category)) {
        $success = false;
    }
    if ($success) {

        $result = $categoryController->updateCategory($_GET["id"], $category, $parent);

        if ($result) {
            echo "
            <script>
            window.location.href = 'http://localhost/OrderManagementSystem/views/category.php';
            </script>
            ";
        }
    }
}
?>
<div class="container">
    <h3>Add Customer</h3>
    <a href="category.php" class="btn btn-primary">Back</a>

    <form action="" class="form w-50 mx-auto" method="post">
        <div class="form-group">
            <label class="form-label">
                Name
            </label>
            <input type="text" name="name" value="<?php echo $cat_id["name"]; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for=''>Parent</label>
            <select name="parent" class="form-control">
                <?php

                if ($cat_id["parent"] == 0) {
                    echo "<option value='0' selected>No parent</option>";
                    foreach ($parents as $parent) {
                        echo "<option value='" . $parent["id"] . "'>" . $parent["name"] . "</option>";
                    }
                } else {
                    foreach ($parents as $parent) {
                        if ($parent["id"] == $cat_id["parent"]) {
                            echo "<option value='" . $parent["id"] . "' selected>" . $parent["name"] . "</option>";
                        } else {
                            echo "<option value='" . $parent["id"] . "'>" . $parent["name"] . "</option>";
                        }
                    }
                }


                ?>
            </select>;
        </div>
        <button type="submit" class="btn btn-success w-100" name="submit">Add</button>
    </form>
</div>

<?php
include "layouts/footer.php";
?>