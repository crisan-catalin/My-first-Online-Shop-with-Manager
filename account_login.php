<?php
session_start();
require_once 'AccountDAO.php';

if (isset($_POST['user_name']) && isset($_POST['password'])) {
    $response = AccountDAO::loginAccount($_POST['user_name'], $_POST['password']);
    if ($response['response'] == "success") {
        header("Location: http://localhost/proiect/index.php");
        exit();
    } else {
        echo 'Nume sau parola invalida <br>';
        echo '<a href="login.php">Incearca dinnou</a>';
        exit;
    }
} else {
    echo 'Nume sau parola invalida <br>';
    echo '<a href="login.php">Incearca dinnou</a>';
    exit;
}
?>