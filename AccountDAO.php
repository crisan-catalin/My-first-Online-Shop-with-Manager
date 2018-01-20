<?php
include('connection.php');

class AccountDAO
{
    private static function isValidAccount($isAdmin, $username, $password)
    {
        $isAdmin = intval($isAdmin);
        $query = "SELECT * FROM user WHERE username='$username' AND password='" . md5($password) . "' AND admin=$isAdmin";
        $result = mysql_query($query);

        return mysql_num_rows($result) > 0;
    }

    private static function existAccountWith($username, $email)
    {
        $query = "SELECT * FROM user WHERE username='$username' OR email='$email'";
        $result = mysql_query($query);

        return mysql_num_rows($result) > 0;
    }

    public static function createAccount($isAdmin, $username, $password, $email)
    {
        $isAdmin = intval($isAdmin);

        if (self::existAccountWith($username, $email)) {
            return array("response" => "exist");
        }

        $query = "INSERT INTO user(username,password,email,admin) VALUES('$username','" . md5($password) . "','$email',$isAdmin)";
        $result = mysql_query($query);

        if ($result == true) {
            $accountId = mysql_insert_id();
            $_SESSION["user_id"] = $accountId;
            $_SESSION['username'] = $username;

            if ($isAdmin == 1) {
                $_SESSION['admin'] = true;
            }

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

    public static function getAccountWithId($id)
    {
        $query = "SELECT username, email FROM user WHERE id=" . $id;
        $result = mysql_query($query);

        if ($result == false || mysql_num_rows($result) == 0) {
            return array("response" => "failed");
        }

        $row = mysql_fetch_row($result);

        return array("response" => "success",
            "username" => $row[0],
            "email" => $row[1]);
    }

    public static function updateAccountEmail($id, $newEmail)
    {
        $response = self::getAccountWithId($id);
        if ($response['response'] == "failed") {
            return $response;
        }

        $query = "UPDATE user SET email='" . $newEmail . "' WHERE id=" . $id;
        return mysql_query($query) == true ? array("response" => "success") : array("response" => "failed");
    }

    public static function updateAccountPassword($id, $password)
    {
        $response = self::getAccountWithId($id);
        if ($response['response'] == "failed") {
            return $response;
        }

        $query = "UPDATE user SET password='" . md5($password) . "' WHERE id=" . $id;
        return mysql_query($query) == true ? array("response" => "success") : array("response" => "failed");
    }

    public static function deleteAccountWithId($id)
    {
        $response = self::getAccountWithId($id);
        if ($response['response'] == "failed") {
            return $response;
        }

        $query = "DELETE FROM user WHERE id=" . $id;
        return mysql_query($query) == true ? array("response" => "success") : array("response" => "failed");
    }
}