<?php
include "layouts/header.php";
require_once "../controllers/CategoryController.php";

$categoryController = new CategoryController();
$parents = $categoryController->getParents();

if (isset($_POST["submit"])) {
    $success = true;
    $category = $_POST["name"] ?? "";
    $parent = $_POST["parent"];

    if(empty($category)){
        $success = false;
    }
    if ($success) {
        
        $result = $categoryController->saveCategory($category,$parent);

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
            <input type="text" name="name" id="" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Parent</label>
            <select name="parent" id="" class="form-control">
                <option value="0" selected>No parent</option>
                <?php
                    foreach ($parents as $parent) {
                    echo "<option value='".$parent["id"]."'>".$parent["name"]."</option>";
                    }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100" name="submit">Add</button>
    </form>
</div>

<?php
include "layouts/footer.php";
?>