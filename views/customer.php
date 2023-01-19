<?php include "layouts/header.php";
require_once "../controllers/CustomerController.php";
require_once "../include/Pagination.php";

$customerController = new CustomerController();
$customers = $customerController->getCustomers();

// display id for customer
for ($i = 1; $i <= count($customers); $i++) {
    $customers[$i - 1] += ["d_id" => $i];
}

// add pagination
$pages = (isset($_GET["pages"]))? (int)$_GET["pages"] : 1;

$per_page = 4;
$num_of_pages = ceil(count($customers) / $per_page);
$pagi_cus = Pagination::paginator($pages, $customers, $per_page);

if (isset($_GET['id'])) {
    $result = $customerController->deleteCustomer($_GET["id"]);

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
    <h3>Customers</h3>

    <a href="create_customer.php" class="btn btn-success">Add new customer</a>
    <div class="row">
        <table class="table border table-striped text-center mt-3">
            <thead class="bg-dark text-white">
                <th>Id</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                foreach ($pagi_cus as $customer) {
                    echo "<tr>
                            <td>" . $customer["d_id"] . "</td>
                            <td>" . $customer['name'] . "</td>
                            <td>" . $customer['phone'] . "</td>
                            <td>" . $customer['address'] . "</td>
                            <td>" . $customer['email'] . "</td>
                            <td>
                                <a href='edit_customer.php?id=" . $customer["id"] . "' class='btn btn-success'>Edit</a>
                                <a href='" . $_SERVER["PHP_SELF"] . "?id=" . $customer["id"] . "' class='btn btn-danger'>Delete</a>
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

<?php include "layouts/footer.php" ?>