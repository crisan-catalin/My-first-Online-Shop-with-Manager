<?php
require_once 'header.php';
require_once 'CheckoutDAO.php';

if (isset($_POST['checkout']) && isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $telephone = $_POST['telephone'];
    $county = $_POST['county'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    CheckoutDAO::checkout($id, $name, $telephone, $county, $city, $address);

    echo "Comanda finalizata cu success!";
}

require_once 'footer.php';
?>