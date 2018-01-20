<?php
require_once 'ProductDAO.php';
require_once 'CartDAO.php';

class CheckoutDAO
{
    private static function addToCheckout($userId, $name, $phone, $address)
    {
        $query = "INSERT INTO checkout(user_id, date, address, phone, name) VALUES('$userId',now(),'$address','$phone','$name')";
        $result = mysql_query($query);
        $checkoutId = mysql_insert_id();

        return $result == false ? array("response" => "failed") : array("response" => "success", "checkout_id" => $checkoutId);
    }

    private static function addToOrderHistory($checkoutId, $productId)
    {
        $query = "INSERT INTO order_history VALUES($checkoutId,$productId)";
        $result = mysql_query($query);

        return $result == false ? array("response" => "failed") : array("response" => "success");

    }

    public static function checkout($userId, $name, $telephone, $county, $city, $address)
    {
        $response = ProductDAO::getProductsForCheckout($userId);

        $productsId = array();
        foreach ($response as $item) {
            $productId = $item['id'];
            $buc = $item['buc'];
            CartDAO::removeForCheckout($userId, $productId, $buc);
            array_push($productsId, $productId);
        }

        $checkoutResponse = self::addToCheckout($userId, $name, $telephone, $county . ", " . $city);
        if ($checkoutResponse['response'] != "failed") {
            $checkoutId = $checkoutResponse['checkout_id'];
            foreach ($productsId as $id) {
                self::addToOrderHistory($checkoutId, $id);
            }
        }
    }
}