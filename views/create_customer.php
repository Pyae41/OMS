<?php
include "layouts/header.php";
require_once "../controllers/CustomerController.php";


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
        $customerController = new CustomerController();
        $result = $customerController->saveCustomer($arr);

        if ($result) {
            echo "
            <script>
            window.location.href = 'http://localhost/OrderManagementSystem/views/customer.php';
            </script>
            ";
        }   
    }
}
?>
<div class="container">
    <h3>Add Customer</h3>
    <a href="customer.php" class="btn btn-primary">Back</a>

    <form action="" class="form w-50 mx-auto" method="post">
        <div class="form-group">
            <for class="form-label">
                Name
            </for>
            <input type="text" name="name" id="" class="form-control">
        </div>
        <div class="form-group">
            <for class="form-label">
                Email
            </for>
            <input type="email" name="email" id="" class="form-control">
        </div>
        <div class="form-group">
            <for class="form-label">
                Phone
            </for>
            <input type="text" name="phone" id="" class="form-control">
        </div>
        <div class="form-group">
            <for class="form-label">
                Address
            </for>
            <input type="text" name="address" id="" class="form-control">
        </div>
        <button type="submit" class="btn btn-success w-100" name="submit">Add</button>
    </form>
</div>

<?php
include "layouts/footer.php";
?>