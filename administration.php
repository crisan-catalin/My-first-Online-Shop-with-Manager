<?php
require_once 'admin_authorization.php';
require_once 'header.php';
require_once 'ProductDAO.php';
require_once 'AccountDAO.php';
require_once 'AdminHelper.php';

if (!isset($_GET['product_page'])) {
    $_GET['product_page'] = 1;
}
if (!isset($_GET['user_page'])) {
    $_GET['user_page'] = 1;
}

const PRODUCTS_PER_PAGE = 2;
const USER_PER_PAGE = 5;

echo "<h2>Produse</h2>";

echo "<form action='product_admin.php' method='POST'>";
echo "<input type='submit' name='add_product' value='+ Adauga produs'>";
echo "</form>";

$pageResponse = ProductDAO::getPageNumbersUsing(PRODUCTS_PER_PAGE);
if ($pageResponse['response'] != "failed") {

    $response = ProductDAO::getProducts(PRODUCTS_PER_PAGE, $_GET['product_page']);
    if ($response['response'] != "failed") {
        AdminHelper::displayTableFor("product", $response, $pageResponse);
    } else {
        echo "No product available.";
    }
}


echo "<h2>Utilizatori</h2>";

echo "<form action='user_admin.php' method='POST'>";
echo "<input type='submit' name='add_user' value='+ Adauga utilizator'>";
echo "</form>";

$pageResponse = AccountDAO::getPageNumbersUsing(USER_PER_PAGE);
if ($pageResponse['response'] != "failed") {

    $response = AccountDAO::getUsers(USER_PER_PAGE, $_GET['user_page']);
    if ($response['response'] != "failed") {
        AdminHelper::displayTableFor("user", $response, $pageResponse);
    } else {
        echo "No user available.";
    }
}

require_once 'footer.php';
?>

