<?php
require_once 'admin_authorization.php';
require_once 'header.php';
require_once 'ProductDAO.php';
const IMAGE_DIR = "produse/";

echo "<a href='administration.php'>Inapoi</a>";
echo "<br>";

if (isset($_POST['add_product']) || isset($_POST['edit_product']) && strlen($_FILES['product_image']['name']) > 0) {
    if (!file_exists(IMAGE_DIR)) {
        mkdir(IMAGE_DIR);
    }
    $imageFile = IMAGE_DIR . basename($_FILES['product_image']['name']);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $imageFile);
    unset($_FILES['product_image']);
}

if (isset($_POST['add_product'])) {
    $response = ProductDAO::addProduct($_POST['product_name'], $_POST['product_price'], $_POST['product_stock'], $imageFile);
    echo $response['response'] != "failed" ?
        "<div class='alert alert-success text-center' role='alert'>Produsul a fost adaugat cu succes!</div>"
        :
        "<div class='alert alert-danger text-center' role='alert'>A aparut o problema in timpul adaugarii produsului. Incearca din nou.</div>";
} elseif (isset($_POST['edit_product'])) {
    $response = ProductDAO::updateProduct($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_stock'], $imageFile);

    echo $response['response'] != "failed" ?
        "<div class='alert alert-success text-center' role='alert'>Produsul a fost modificat cu succes!</div>"
        :
        "<div class='alert alert-danger text-center' role='alert'>A aparut o problema in timpul modificarii produsului. Incearca din nou.</div>";
} else {
    echo "<div class='alert alert-danger text-center' role='alert'>A aparut o problema in timpul adaugarii produsului. Incearca din nou.</div>";
}

require_once 'footer.php';