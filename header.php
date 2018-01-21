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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Proiect PHP</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- custom css for users -->
    <link href="style/user.css" rel="stylesheet" media="screen">
</head>
<body>

<!-- container -->
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="page-header">
                <h1><a href='index.php'>My Shop</a></h1>
            </div>
        </div>

        <?php


        if (isset($_SESSION['username'])) {
            echo "Bine ai venit " . $_SESSION['username'] . "! <br>";

            if (isset($_SESSION['admin'])) {
                print('<a href="administration.php">Panou control</a> <br>');
            }

            echo "<a href='index.php?logout'>Log out</a>";
        } else {
            echo "Apasa <a href='login.php'>login</a> daca ai deja un cont sau <a href='signup.php'>creaza cont</a> nou.";
        }

        echo "<br>";
        echo "<a href='cart.php'>Vezi cos</a>";


        echo "<hr>";
        ?>
