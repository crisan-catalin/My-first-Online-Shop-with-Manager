<?php
include('connection.php');
require_once 'ProductDAO.php';

class CartDAO
{
    public static function addToCart($userId, $productId)
    {
        $response = ProductDAO::removeFromStock($productId, 1);
        if ($response["response"] !== "success") {
            return $response;
        }

        $query = "INSERT INTO cart(user_id, product_id) values($userId,$productId)";
        $result = mysql_query($query);

        return $result == false ? array("response" => "failed") : array("response" => "success");
    }

    public static function removeFromCart($userId, $productId)
    {
        $response = ProductDAO::addToStock($productId, 1);
        if ($response["response"] !== "success") {
            return $response;
        }

        $query = "DELETE FROM cart WHERE user_id=$userId AND product_id=$productId";
        $result = mysql_query($query);

        return $result == false ? array("response" => "failed") : array("response" => "success");
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

            self::removeFromCart($userId, $productId);
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