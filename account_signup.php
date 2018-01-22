<?php
session_start();
require_once 'AccountDAO.php';

if (isset($_POST['user_name']) && isset($_POST['email']) && isset($_POST['password'])) {

    $response = AccountDAO::createAccount(false, $_POST['user_name'], $_POST['password'], $_POST['email']);

    if ($response['response'] == "exist") {
        require_once 'header.php';
        echo "<div class='alert alert-warning text-center' role='alert'>Username sau adresa de email deja existenta</div>";
        require_once 'footer.php';
    } elseif ($response['response'] == "failed") {
        require_once 'header.php';
        echo "<div class='alert alert-warning text-center' role='alert'>A existat o problema in timpul inregristrarii. Incearca dinnou</div>";
        require_once 'footer.php';
    } elseif ($response['response'] == "success") {
        header("Location: http://localhost/proiect/index.php");
    }
} else {
    require_once 'header.php';
    echo "<div class='alert alert-warning text-center' role='alert'>Date de inregistrare invalide</div>";
    require_once 'footer.php';
}
?>