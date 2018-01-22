<?php
session_start();
require_once 'AccountDAO.php';

if (isset($_POST['user_name']) && isset($_POST['password'])) {

    $response = AccountDAO::loginAccount($_POST['user_name'], $_POST['password']);

    if ($response['response'] == "success") {
        header("Location: http://localhost/proiect/index.php");
        exit();
    } else {
        require_once 'header.php';
        echo "<div class='alert alert-warning text-center' role='alert'>Nume sau parola invalida</div>";
        require_once 'footer.php';
    }
} else {
    require_once 'header.php';
    echo "<div class='alert alert-warning text-center' role='alert'>Nume sau parola invalida</div>";
    require_once 'footer.php';
}
?>