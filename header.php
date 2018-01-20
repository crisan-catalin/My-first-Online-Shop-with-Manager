<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_GET['logout']);
    header("Location: http://localhost/proiect/index.php");
}

if (isset($_GET['page'])) {
    $_SESSION["active_page"] = $_GET['page'];
} elseif (!isset($_SESSION["active_page"])) {
    $_SESSION["active_page"] = 1;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Proiect PHP</title>
</head>
<body>

<?php

echo "<a href='index.php'>My Shop</a> <br><br>";

if (isset($_SESSION['username'])) {
    echo "Bine ai venit " . $_SESSION['username'] . "! <br>";

    if (isset($_SESSION['admin'])) {
        print('<a href="#">Panou control</a> <br>');
    }

    echo "<a href='index.php?logout'>Log out</a>";
} else {
    echo "Apasa <a href='login.php'>login</a> daca ai deja un cont sau <a href='signup.php'>creaza cont</a> nou.";
}

echo "<br>";
echo "<a href='cart.php'>Vezi cos</a>";


echo "<hr>";
?>
