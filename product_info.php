<?php
require_once 'header.php';
require_once 'ProductDAO.php';
require_once 'CartDAO.php';

if (isset($_POST['add_product'])) {
    if (isset($_SESSION['user_id'])) {
        CartDAO::addToCart($_SESSION['user_id'], $_GET['product_id'], 1);
    } else {
        echo "Autentifica inainte de a adauga produse in cos!";
    }
}

if (isset($_GET['product_id'])) {
    $response = ProductDAO::getProduct($_GET['product_id']);

    if ($response['response'] == "failed") {
        echo "Problem to load product";
        echo "<a href='index.php'>Inapoi</a>";
        return;
    }
    ?>

    <a href='index.php'>Inapoi</a>
    <form action="product_info.php?product_id=<?php echo $_GET['product_id'] ?>" method="POST">
        <h1>Produs: <?php echo $response['name'] ?></h1>
        <h2>Pret: <?php echo $response['price'] ?>RON </h2>
        <h2>Stoc: <?php echo((int)$response['stock'] > 0 ? "DA" : "NU") ?> </h2>
        <h2>Imagine: <?php echo $response['image'] ?> </h2>
        <input type="hidden" name="product_id" value="<?php echo $_GET['product_id'] ?>">
        <input type="submit" name="add_product" value="Adauga in cos">
    </form>

    <?php
} else {
    echo "Page not found";
    echo "<a href='index.php'>Inapoi</a>";
    return;
}

require_once 'footer.php';
?>