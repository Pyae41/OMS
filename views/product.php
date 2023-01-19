<?php
include_once "layouts/header.php";
require_once "../controllers/ProductController.php";
require_once "../include/Pagination.php";

$productController = new ProductController();
$products = $productController->getProducts();

// add id for display
for ($i = 1; $i <= count($products); $i++) {
    $products[$i - 1] += ['d_id' => $i];
}

// pagination
$pages = (isset($_GET["pages"])) ? (int)$_GET["pages"] : 1;
$per_page = 3;
$num_of_pages = ceil(count($products) / $per_page);

$pagi_pro = Pagination::paginator($pages, $products, $per_page);

if (isset($_GET["id"])) {
    $result = $productController->deleteProduct($_GET["id"]);

    if ($result) {
        echo "
        <script>
        window.location.href = '" . $_SERVER["HTTP_REFERER"] . "';
        </script>
        ";
    }
}
?>

<div class="container">
    <h3>Products</h3>
    <a href="create_product.php" class="btn btn-success mb-3">Add new product</a>
    <div class="row">
        <table class="table border table-striped text-center">
            <thead class="bg-dark text-white">
                <th>Id</th>
                <th>Name</th>
                <th>Function</th>
            </thead>
            <tbody>
                <?php
                foreach ($pagi_pro as $product) {
                    echo "<tr>
                            <td>" . $product['d_id'] . "</td>
                            <td>" . $product['name'] . "</td>   
                            <td>
                                <a href='product-detail.php?id=" . $product['id'] . "' class='btn btn-info text-white'>Details</a>
                                <a href='edit_product.php?id=" . $product['id'] . "' class='btn btn-success text-white'>Edit</a>
                                <a href='" . $_SERVER["PHP_SELF"] . "?id=" . $product['id'] . "' class='btn btn-danger text-white'>Delete</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example mx-auto">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php

            for ($page = 1; $page <= $num_of_pages; $page++) {
                echo "<li class='page-item'><a class='page-link' href='" . $_SERVER["PHP_SELF"] . "?pages=" . $page . "'>" . $page . "</a></li>";
            }
            ?>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php
include_once "layouts/footer.php";
?>