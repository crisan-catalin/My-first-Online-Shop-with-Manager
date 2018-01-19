<?php
session_start();
require_once 'AccountDAO.php';

if (isset($_POST['user_name']) && isset($_POST['email']) && isset($_POST['password'])) {

    $response = AccountDAO::createAccount(false, $_POST['user_name'], $_POST['password'], $_POST['email']);

    if ($response['response'] == "exist") {
        echo 'Username sau adresa de email deja existenta<br>';
        echo '<a href="signup.php">Incearca dinnou</a>';
        exit;
    } elseif ($response['response'] == "failed") {
        echo 'A exista o problema in timpul inregristrarii.<br>';
        echo '<a href="signup.php">Incearca dinnou</a>';
        exit;
    } elseif ($response['response'] == "success") {
        header("Location: http://localhost/proiect/index.php");
    }
} else {
    echo 'Date de inregistrare invalide <br>';
    echo '<a href="signup.php">Incearca dinnou</a>';
    exit;
}
?>