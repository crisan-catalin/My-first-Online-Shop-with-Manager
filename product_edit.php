<?php
require_once 'admin_authorization.php';
require_once 'header.php';
require_once 'ProductDAO.php';
const IMAGE_DIR = "produse/";

echo "<a href='administration.php'>Inapoi</a>";
echo "<br>";

if (isset($_POST['add_product']) || isset($_POST['edit_product'])) {
    if (!file_exists(IMAGE_DIR)) {
        mkdir(IMAGE_DIR);
    }
    $imageFile = IMAGE_DIR . basename($_FILES['product_image']['name']);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $imageFile);
}

if (isset($_POST['add_product'])) {
    $response = ProductDAO::addProduct($_POST['product_name'], $_POST['product_price'], $_POST['product_stock'], $imageFile);
    echo $response['response'] != "failed" ? "Produsul a fost adaugat cu succes!" : "A aparut o problema in timpul adaugarii produsului. Incearca din nou.";
} elseif (isset($_POST['edit_product'])) {
    $response = ProductDAO::updateProduct($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_stock'], $imageFile);
    echo $response['response'] != "failed" ? "Produsul a fost modificat cu succes!" : "A aparut o problema in timpul modificarii produsului. Incearca din nou.";
} else {
    echo "A aparut o problema in timpul modificarii produsului. Incearca din nou.";
}

require_once 'footer.php';