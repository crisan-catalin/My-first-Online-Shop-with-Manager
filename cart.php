<?php
require_once 'header.php';
require_once 'CartDAO.php';
require_once 'ProductDAO.php';

const MAX_PRODUCTS = 5;

if (isset($_POST['add'])) {
    CartDAO::addToCart($_SESSION['user_id'], $_POST['product_id'], 1);

    unset($_POST['add']);
} elseif (isset($_POST['remove'])) {
    CartDAO::removeFromCart($_SESSION['user_id'], $_POST['product_id'], 1);

    unset($_POST['remove']);
} elseif (isset($_POST['delete'])) {
    //buc 0 delete all
    CartDAO::removeFromCart($_SESSION['user_id'], $_POST['product_id'], 0);

    unset($_POST['delete']);
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if (CartDAO::showCheckout($_SESSION['user_id']) == false) {
        echo "Cosul este gol :(";

        require_once 'footer.php';
        return;
    }


    $response = ProductDAO::getProductsForCheckout($userId);

    foreach ($response as $item) {
        echo $item['name'];
        echo "<br>";
        echo "Pret: " . $item['price'] . "RON";
        echo "<br>";
        echo "Imagine: " . $item['image'];
        echo "<br>";

        $productsToCart = $item['buc'];
        $stock = $item['stock'];
        if (intval($stock) + intval($productsToCart) >= MAX_PRODUCTS) {
            $maxProductsToBuy = MAX_PRODUCTS;
        } else {
            $maxProductsToBuy = intval($stock) + intval($productsToCart);
        }

        $idProd = $item['id'];
        echo "Numar produse:";

        echo "<form action='cart.php' method='POST'>";
        echo "<input type='text' readonly value='$productsToCart'>";
        echo "<input type='hidden' name='product_id' value=$idProd>";

        $disableAdd = intval($productsToCart) === $maxProductsToBuy ? "disabled" : "";
        echo "<input type='submit' name='add' value='+' $disableAdd>";
        $disableRemove = intval($productsToCart) === 1 ? "disabled" : "";
        echo "<input type='submit' name='remove' value='-' $disableRemove>";
        echo "<input type='submit' name='delete' value='Sterge produs'>";
        echo "</form>";

        echo "TOTAL: " . intval($productsToCart) * intval($item['price']);
        echo "<br>Puteti cumpara maxim $maxProductsToBuy produse.";

        echo "<hr>";
    }

    echo "<form action='checkout.php' method='POST'>";
    echo "Nume si Prenume: <input type='text' name='name' required='required'>";
    echo "Telefon: <input type='tel' name='telephone' required='required'>";
    echo "<br>";
    echo "Judet: <input type='text' name='county' required='required'>";
    echo "Oras: <input type='text' name='city' required='required'>";
    echo "<br>";
    echo "Adresa: <input type='text' name='address' required='required'>";
    echo "<br>";
    echo "<input type='submit' name='checkout' value='Trimite comanda'>";
    echo "<br>";
    echo "<form>";
}

require_once 'footer.php';
?>