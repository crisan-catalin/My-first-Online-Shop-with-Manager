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
        $query = "SELECT username, email, admin FROM user WHERE id=" . $id;
        $result = mysql_query($query);

        if ($result == false || mysql_num_rows($result) == 0) {
            return array("response" => "failed");
        }

        $row = mysql_fetch_row($result);

        return array("response" => "success",
            "username" => $row[0],
            "email" => $row[1],
            "admin" => $row[2]);
    }

    public static function updateAccount($id, $newUsername, $newEmail, $newPassword, $isAdmin)
    {
        $response = self::getAccountWithId($id);
        if ($response['response'] == "failed") {
            return $response;
        }

        $paramsArray = array();

        if (strlen($newUsername) > 0) {
            array_push($paramsArray, "username='$newUsername'");
        }
        if (strlen($newEmail) > 0) {
            array_push($paramsArray, "email='$newEmail'");
        }
        if (strlen($newPassword) > 0) {
            array_push($paramsArray, "password='" . md5($newPassword) . "'");
        }
        if ($isAdmin == true) {
            array_push($paramsArray, "admin=1");
        } else {
            array_push($paramsArray, "admin=0");
        }

        $queryParams = "";

        for ($i = 0; $i < count($paramsArray); $i++) {
            $queryParams .= $paramsArray[$i];
            if ($i < count($paramsArray) - 1) {
                $queryParams .= ",";
            }
        }

        $query = "UPDATE user SET $queryParams WHERE id=$id";
        $result = mysql_query($query);

        return $result === true ? array("response" => "success") : array("response" => "failed");
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