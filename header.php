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

    <!--        Navigation bar-->
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-inverse">
                <h1><a class="navbar-brand" href="index.php">My SHOP</a></h1>
                <?php

                echo '<ul class="nav">';

                if (isset($_SESSION['admin'])) {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link active" href="administration.php">Panou control</a>';
                    echo '</li>';
                }
                echo '<li class="nav-item">';
                echo '<a class="nav-link" href="cart.php">Vezi cos</a>';
                echo '</li>';

                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link btn btn-danger" href="index.php?logout">Deconectare</a>';
                    echo '</li>';
                }

                echo "</ul>";
                ?>
            </nav>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p class='text-center'>Bine ai venit " . $_SESSION['username'] . "! </p>";
            } else {
                echo "<p class='text-center'>Apasa <a href='login.php'>login</a> daca ai deja un cont sau <a href='signup.php'>creaza cont</a> nou.</p>";
            }
            ?>
        </div>
    </div>
