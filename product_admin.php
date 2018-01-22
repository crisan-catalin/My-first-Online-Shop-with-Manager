<?php
require_once 'admin_authorization.php';

if (isset($_POST['delete_no'])) {
    header("Location: http://localhost/proiect/administration.php");
}

require_once 'header.php';
require_once 'ProductDAO.php';

if (isset($_POST['delete_yes'])) {
    $response = ProductDAO::removeProduct($_GET['product_id']);
    if ($response['response'] != "failed") {
        echo "<a href='administration.php'>Inapoi</a>";
        echo "<div class='alert alert-success text-center' role='alert'>Produsul a fost sters cu success</div>";

        require_once 'footer.php';
        return;
    } else {
        echo "A aparut o eroare in timpul stergerii produsului. Incearca din nou.";
    }
}

if (isset($_POST['add_product'])) {
    echo "<h2>Adauga produs</h2>";
    echo "<a href='administration.php'>Inapoi</a>";

    echo "<form action='product_edit.php' method='POST' enctype='multipart/form-data'>";
    echo "Nume produs: <input type='text' name='product_name' required='required'>";
    echo "<br>";
    echo "Pret produs: <input type='number' name='product_price' required='required'> RON";
    echo "<br>";
    echo "Stoc produs: <input type='number' name='product_stock' required='required'> buc.";
    echo "<br>";
    echo "Imagine produs: <input type='file' name='product_image' required='required' accept='.jpg, .png'>";
    echo "<br>";
    echo "<input type='submit' value='Adauga' name ='add_product'>";
    echo "<form>";
} elseif (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    if (isset($_POST['edit_product'])) {
        $response = ProductDAO::getProduct($productId);
        if ($response['response'] != "failed") {
            $productName = $response['name'];
            $productPrice = $response['price'];
            $productStock = $response['stock'];
            $productImage = $response['image'];
            echo "<h2>Modifica produsul</h2>";
            echo "<a href='administration.php'>Inapoi</a>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-light'><tr><th>Nume produs</th><th>Pret</th><th>Stoc</th><th>Imagine</th></tr></thead>";
            echo "<tr><td>$productName</td><td>$productPrice</td><td>$productStock</td><td>$productImage</td></tr>";
            echo "</table>";

            echo "<form action='product_edit.php' method='POST' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='product_id' value='$productId'>";
            echo "<div class='form-group'>";
            echo "Nume nou produs: <input type='text' class='form-control' name='product_name' placeholder='(Optional)'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "Pret nou produs (RON): <input type='number' class='form-control' name='product_price' placeholder='(Optional)'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "Stoc nou produs (buc): <input type='number' class='form-control' name='product_stock' placeholder='(Optional)'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "Imagine noua (Optional): <input type='file' class='form-control' name='product_image' accept='.jpg, .png'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<input type='submit' value='Modifica produs' name ='edit_product'>";
            echo "</div>";
            echo "<form>";
        }

    } elseif (isset($_POST['delete_product'])) {
        echo "Esti sigur ca doresti sa stergi produsul?";
        echo "<form action='product_admin.php?product_id=$productId' method='POST'>";
        echo "<input type='submit' name='delete_yes' value='Da, sunt sigur'>";
        echo "<input type='submit' name='delete_no' value='Nu'>";
        echo "</form>";
    }
} else {
    echo "<h2>Nu a fost gasit niciun produs.</h2>";
}

require_once 'footer.php';