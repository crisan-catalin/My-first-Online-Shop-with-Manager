<?php
include('connection.php');
require_once 'ProductDAO.php';

class CartDAO
{
    public static function addToCart($userId, $productId, $buc)
    {
        $response = ProductDAO::removeFromStock($productId, $buc);
        if ($response["response"] !== "success") {
            return $response;
        }

        $query = "INSERT INTO cart(user_id, product_id) values($userId,$productId)";
        $result = mysql_query($query);

        return $result == false ? array("response" => "failed") : array("response" => "success");
    }

    // Set $buc = 0 to delete all pieces from cart
    public static function removeFromCart($userId, $productId, $buc)
    {
        $limit = intval($buc) > 0 ? "LIMIT $buc" : "";
        $query = "DELETE FROM cart WHERE user_id=$userId AND product_id=$productId $limit";
        $result = mysql_query($query);

        if ($result == false) {
            return array("response" => "failed");
        }

        $addToStock = mysql_affected_rows();
        $response = ProductDAO::addToStock($productId, $addToStock);
        if ($response["response"] !== "success") {
            return $response;
        }

        return array("response" => "success");
    }

    public static function checkout($userId)
    {
        $queryHistory = "INSERT INTO history(user_id, checkout) VALUES($userId,now())";
        $result = mysql_query($queryHistory);

        if ($result == false) {
            return array("response" => "failed");
        }

        $historyId = mysql_insert_id();

        $query = "SELECT product_id FROM cart WHERE user_id=$userId";
        $result = mysql_query($query);

        if ($result == false) {
            return array("response" => "failed");
        }

        while ($row = mysql_fetch_array($result)) {
            $productId = $row[0];

            $query = "INSERT INTO order_history VALUES($historyId,$productId)";
            $result = mysql_query($query);
            if ($result == false) {
                return array("response" => "failed");
            }

            self::removeFromCart($userId, $productId, 1);
        }
        print "[INFO] showCheckout method don't work.";
    }

    public static function showCheckout($userId)
    {
        $query = "SELECT COUNT(product_id) FROM cart WHERE user_id=$userId";
        $result = mysql_query($query);

        if ($result == false) {
            return array("response" => "failed");
        }

        $count = mysql_result($result, 0);
        $count = intval($count);

        return $count > 0 ? true : false;
    }
}