<?php
require_once 'admin_authorization.php';
require_once 'header.php';
require_once 'AccountDAO.php';

echo "<a href='administration.php'>Inapoi</a>";
echo "<br>";

if (isset($_POST['add_user'])) {

    $isAdmin = isset($_POST['admin']) ? true : false;
    $response = AccountDAO::createAccount($isAdmin, $_POST['username'], $_POST['password'], $_POST['email']);
    echo $response['response'] != "failed" ? "Utilizatorul a fost creat cu succes!" : "A aparut o problema in timpul crearii utilizatorului. Incearca din nou.";

} elseif (isset($_POST['edit_user'])) {

    $isAdmin = isset($_POST['admin']) ? true : false;
    $response = AccountDAO::updateAccount($_POST['user_id'], $_POST['username'], $_POST['email'], $_POST['password'], $isAdmin);
    echo $response['response'] != "failed" ? "Utilizatorul a fost modificat cu succes!" : "A aparut o problema in timpul modificarii datelor utilizatorul. Incearca din nou.";

} else {
    echo "A aparut o problema in timpul modificarii datelor utilizatorul. Incearca din nou.";
}

require_once 'footer.php';