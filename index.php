<?php

session_start();

if (isset($_GET['page'])) {
    $_SESSION["active_page"] = $_GET['page'];
} elseif (!isset($_SESSION["active_page"])) {
    $_SESSION["active_page"] = 1;
}

require_once 'header.php';
require_once 'product_list.php';
require_once 'footer.php';
require_once 'AccountDAO.php';
require_once 'ProductDAO.php';
require_once 'CartDAO.php';

if (isset($_SESSION['admin_id'])) {
    echo "<br> Welcome admin = " . $_SESSION['admin_id'];
} elseif (isset($_SESSION['user_id'])) {
    echo "<br> Welcome user = " . $_SESSION['user_id'];
} else {
    echo "Bleeaah";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Proiect PHP</title>
</head>
<body>

</body>
</html>