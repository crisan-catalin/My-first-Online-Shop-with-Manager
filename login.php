<?php
require_once 'header.php';
?>
    <h1>Login</h1>
    <form action="account_login.php" method="POST">
        <input type="text" name="user_name" placeholder="Nume utilizator" pattern=".{5,}" required="required">
        <input type="password" name="password" pattern=".{5,}" required="required">
        <input type="submit" name="Login">
    </form>

<?php
require_once 'footer.php';
?>