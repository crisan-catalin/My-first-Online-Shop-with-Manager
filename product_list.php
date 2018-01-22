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

        echo "<div class='row'>";

        for ($i = 0; $i < count($response) - 1; $i++) {
            ?>
            <div class="col-sm-5 offset-sm-1">
                <div class='card mb-4' style='width: 20rem;'>
                    <img class='card-img-top img-fluid' src='<?php echo $response[$i]["image"] ?>'>
                    <div class='card-block text-center'>
                        <h4 class='card-title'><?php echo $response[$i]['name'] ?></h4>
                        <p class='card-text text-center'>Descriere produs.</p>
                        <a href='<?php echo "product_info.php?product_id=" . $response[$i]['id'] ?>'
                           class='btn btn-primary'> Vezi produs</a>
                    </div>
                </div>
            </div>

            <?php
        }

        echo "</div>";
    } else {
        echo "<div class='alert alert-warning text-center' role='alert'>Nu exista produse disponibile :(</div>";

    }

    echo "<hr>";
    echo "<div class='row'>";
    echo "<div class='col-sm-12 text-center'>";

    for ($i = 0; $i < $pageResponse; $i++) {
        $pageNumber = $i + 1;

        echo "<a href='index.php?page=$pageNumber'>[$pageNumber]</a> &nbsp;";
    }
    echo "</div>";
    echo "</div>";
}

require_once 'footer.php';
?>
