<?php
include "layouts/header.php";
require_once "../controllers/CategoryController.php";
require_once '../include/Pagination.php';

$categoryController = new CategoryController();
$categories = $categoryController->getCategories();

// filter parent
$parents = array_values(array_filter($categories, function ($value) {
    return $value["parent"] == 0;
}));

// // filter Subcategories
// $subs = array_values(array_filter($categories, function ($value) {
//     return $value["parent"] != 0;
// }));
if (isset($_GET["id"])) {
    echo $check = "<script>confirm('Are you sure to delete?');</script>";
    if ($check) {
        $result = $categoryController->deleCategory($_GET["id"]);

        if ($result) {
            echo "
        <script>
        window.location.href = 'http://localhost/OrderManagementSystem/views/category.php';
        </script>
        ";
        } else {
            echo "<script>alert('Cannot delete.There is a relationship.')</script>";
            echo "
        <script>
        window.location.href = 'http://localhost/OrderManagementSystem/views/category.php';
        </script>
        ";
        }
    }
}
?>
<div class="container w-100">
    <h3>Categories</h3>

    <a href="create_category.php" class="btn btn-success mb-3">Add new category</a>
    <div class="row">
        <table class="table table-striped" id="dataTable" style="width: 1000px !important;">
            <thead class="bg-dark text-white">
                <th>Id</th>
                <th>Name</th>
                <th>Subcategories</th>
                <th>Function</th>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($categories as $parent) {
                    echo "<tr>";
                    echo "<td>" . $count++ . "</td>";
                    echo "<td>" . $parent["name"] . "</td>";
                    echo "<td>";
                    if ($parent["parent"] == 0) {
                        echo "-";
                    } else {
                        foreach ($parents as $sub) {
                            if ($sub["id"] == $parent["parent"]) {
                                echo $sub["name"];
                            }
                        }
                    }
                    echo "</td>";
                    echo "<td>
                            <a href='edit_category.php?id=" . $parent["id"] . "' class='btn btn-success'>Edit</a>
                            <a href='" . $_SERVER["PHP_SELF"] . "?id=" . $parent["id"] . "' class='btn btn-danger'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php include "layouts/footer.php";
