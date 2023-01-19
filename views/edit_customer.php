<?php
include "layouts/header.php";
require_once "../controllers/CustomerController.php";

$customerController = new CustomerController();
$customer = $customerController->getCustomerById($_GET["id"]);


if (isset($_POST["submit"])) {
    $arr = [];
    $error = true;
    foreach ($_POST as $key => $value) {
        $arr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    // check array's value is null or not
    foreach ($arr as $key => $value) {
        if (is_null($arr[$key])) {
            $error = false;
        }
    }

    if ($error) {
        $customerController = new CustomerController();
        $result = $customerController->updateCustomer($_GET["id"],$arr);

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
            <input type="text" name="name" id="" class="form-control" value="<?php echo $customer["name"] ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Email
            </for>
            <input type="email" name="email" id="" class="form-control" value="<?php echo $customer["email"] ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Phone
            </for>
            <input type="text" name="phone" id="" class="form-control" value="<?php echo $customer["phone"] ?>">
        </div>
        <div class="form-group">
            <for class="form-label">
                Address
            </for>
            <input type="text" name="address" id="" class="form-control" value="<?php echo $customer["address"] ?>">
        </div>
        <button type="submit" class="btn btn-success w-100" name="submit">Update</button>
    </form>
</div>

<?php
include "layouts/footer.php";
?>