<?php
include('connection.php');

class AccountDAO
{
    private static function isValidAccount($isAdmin, $username, $password)
    {
        $table = $isAdmin == true ? "admin" : "user";
        $query = "SELECT * FROM $table WHERE username='$username' AND password='" . md5($password) . "'";
        $result = mysql_query($query);

        return mysql_num_rows($result) > 0;
    }

    private static function existAccountWith($isAdmin, $username, $email)
    {
        $table = $isAdmin === true ? "admin" : "user";

        $query = "SELECT * FROM $table WHERE username='$username' OR email='$email'";
        $result = mysql_query($query);

        return mysql_num_rows($result) > 0;
    }

    public static function createAccount($isAdmin, $username, $password, $email)
    {
        $table = $isAdmin === true ? "admin" : "user";

        if (self::existAccountWith($isAdmin, $username, $email)) {
            return array("response" => "exist");
        }

        $query = "INSERT INTO $table(username,password,email) VALUES('$username','" . md5($password) . "','$email')";
        $result = mysql_query($query);

        if ($result) {
            $accountId = mysql_insert_id();
            $_SESSION["user_id"] = $accountId;

            return array("response" => "success");
        }

        return array("response" => "failed");
    }

    public static function loginAccount($username, $password)
    {
        if (self::isValidAccount(true, $username, $password)) {
            $_SESSION['user_id'] = mysql_insert_id();
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $username;

            return array("response" => "success");
        }

        if (self::isValidAccount(false, $username, $password)) {
            $_SESSION['user_id'] = mysql_insert_id();
            $_SESSION['username'] = $username;

            return array("response" => "success");
        }
        return array("response" => "failed");
    }

    public static function getAccountWithId($isAdmin, $id)
    {
        $table = $isAdmin === true ? "admin" : "user";

        $query = "SELECT username, email FROM $table WHERE id=" . $id;
        $result = mysql_query($query);

        if ($result == false) {
            return array("response" => "failed");
        }

        $row = mysql_fetch_row($result);

        return array("response" => "success",
            "username" => $row[0],
            "email" => $row[1]);
    }

    public static function updateAccountEmail($isAdmin, $id, $email)
    {
        $table = $isAdmin === true ? "admin" : "user";

        $query = "SELECT id FROM $table WHERE id=" . $id;
        $result = mysql_query($query);

        if (mysql_num_rows($result) != 1) {
            return array("response" => "failed");
        }

        $query = "UPDATE $table SET email='" . $email . "' WHERE id=" . $id;
        return mysql_query($query) == true ? array("response" => "success") : array("response" => "failed");
    }

    public static function updateAccountPassword($isAdmin, $id, $password)
    {
        $table = $isAdmin === true ? "admin" : "user";

        $query = "SELECT id FROM $table WHERE id=" . $id;
        $result = mysql_query($query);

        if (mysql_num_rows($result) != 1) {
            return array("response" => "failed");
        }

        $query = "UPDATE $table SET password='" . md5($password) . "' WHERE id=" . $id;
        return mysql_query($query) == true ? array("response" => "success") : array("response" => "failed");
    }

    public static function deleteAccountWithId($isAdmin, $id)
    {
        $table = $isAdmin === true ? "admin" : "user";

        $query = "DELETE FROM $table WHERE id=" . $id;
        return mysql_query($query) == true ? array("response" => "success") : array("response" => "failed");
    }
}