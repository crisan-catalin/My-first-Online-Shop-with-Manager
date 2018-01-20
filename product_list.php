<?php

require_once 'header.php';
require_once 'ProductDAO.php';
const PRODUCTS_PER_PAGE = 2;

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

$pageResponse = ProductDAO::getPageNumbersUsing(PRODUCTS_PER_PAGE);
if ($pageResponse['response'] != "failed") {

    $response = ProductDAO::getProducts(PRODUCTS_PER_PAGE, $_GET['page']);
    if ($response['response'] != "failed") {
        for ($i = 0; $i < count($response) - 1; $i++) {
            echo 'Produs: ' . $response[$i]['name'];
            echo "<input type='hidden' name='product_id' value='" . $response[$i]['id'] . "'>";
            echo '<a href="product_info.php?product_id=' . $response[$i]['id'] . '">Vezi produs</a>';
            echo "<hr>";
        }
    } else {
        echo "No product available";
    }


    echo "<hr>";
    for ($i = 0; $i < $pageResponse; $i++) {
        $pageNumber = $i + 1;

        echo "<a href='index.php?page=$pageNumber'>[$pageNumber]</a> &nbsp;";
    }
}


require_once 'footer.php';
?>
