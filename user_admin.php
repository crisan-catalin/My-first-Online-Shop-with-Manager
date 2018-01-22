<?php
require_once 'admin_authorization.php';

if (isset($_POST['delete_no'])) {
    header("Location: http://localhost/proiect/administration.php");
}

require_once 'header.php';
require_once 'AccountDAO.php';

if (isset($_POST['delete_yes'])) {
    $response = AccountDAO::deleteAccountWithId($_GET['user_id']);
    if ($response['response'] != "failed") {
        echo "<a href='administration.php'>Inapoi</a>";
        echo "<div class='alert alert-success text-center' role='alert'>Utilizatorul a fost sters cu success</div>";


        require_once 'footer.php';
        return;
    } else {
        echo "A aparut o eroare in timpul stergerii utilizatorului. Incearca din nou.";
    }
}
if (isset($_POST['add_user'])) {
    echo "<h2>Adauga utilizator</h2>";
    echo "<a href='administration.php'>Inapoi</a>";

    echo "<form action='user_edit.php' method='POST'>";
    echo "Nume utilizator: <input type='text' name='username' required='required'>";
    echo "<br>";
    echo "Email: <input type='email' name='email' required='required'>";
    echo "<br>";
    echo "Parola: <input type='password' name='password' required='required'>";
    echo "<br>";
    echo "Drept admin: <input type='checkbox' name='admin'>";
    echo "<br>";
    echo "<input type='submit' value='Adauga' name ='add_user'>";
    echo "</form>";
} elseif (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    if (isset($_POST['edit_user'])) {
        $response = AccountDAO::getAccountWithId($userId);
        if ($response['response'] != "failed") {
            $username = $response['username'];
            $email = $response['email'];
            $isAdmin = $response['admin'];
            if (intval($isAdmin) == 0) {
                $checked = "";
                $isAdmin = "NU";
            } else {
                $checked = "checked";
                $isAdmin = "DA";
            }

            echo "<h2>Modifica utilizator</h2>";
            echo "<a href='administration.php'>Inapoi</a>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-light'><tr><th>Username</th><th>Email</th><th>Admin</th></tr></thead>";
            echo "<tr><td>$username</td><td>$email</td><td>$isAdmin</td></tr>";
            echo "</table>";

            echo "<form action='user_edit.php' method='POST'>";
            echo "<input type='hidden' name='user_id' value='$userId'>";
            echo "<div class='form-group'>";
            echo "Username: <input type='text' class='form-control' name='username' placeholder='(Optional)'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "Email: <input type='email' class='form-control' name='email' placeholder='(Optional)'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "Drept admin: <input type='checkbox' name='admin' $checked>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<input type='submit' value='Modifica utilizator' name ='edit_user'>";
            echo "</div>";
            echo "<form>";
        }

    } elseif (isset($_POST['delete_user'])) {
        echo "Esti sigur ca doresti sa stergi utilizatorul?";
        echo "<form action='user_admin.php?user_id=$userId' method='POST'>";
        echo "<input type='submit' name='delete_yes' value='Da, sunt sigur'>";
        echo "<input type='submit' name='delete_no' value='Nu'>";
        echo "</form>";
    }
} else {
    echo "<h2>Nu a fost gasit niciun utilizator.</h2>";
}

require_once 'footer.php';