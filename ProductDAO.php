<?php
require_once 'connection.php';

class ProductDAO
{
    private static function productExistWithName($productName)
    {
        $query = "SELECT * FROM product WHERE name='$productName'";
        $result = mysql_query($query);

        return mysql_num_rows($result) > 0;
    }

    private static function productExistWithId($id)
    {
        $query = "SELECT * FROM product WHERE id='$id'";
        $result = mysql_query($query);

        return mysql_num_rows($result) > 0;
    }

    public static function createProduct($productName, $price, $stock, $imagePath)
    {
        if (self::productExistWithName($productName)) {
            return array("response" => "exist");
        }

        $query = "INSERT INTO product(name, price, stock, image) VALUES('$productName',$price,$stock,'$imagePath')";
        $result = mysql_query($query);

        return $result === true ? array("response" => "success") : array("response" => "failed");
    }

    public static function getProduct($id)
    {
        if (!self::productExistWithId($id)) {
            return array("response" => "failed");
        }

        $query = "SELECT name, price, stock, image FROM product WHERE id=$id";
        $result = mysql_query($query);

        if ($result == false) {
            return array("response" => "failed");
        }

        $row = mysql_fetch_row($result);
        return array("response" => "success",
            "name" => $row[0],
            "price" => $row[1],
            "stock" => $row[2],
            "image" => $row[3]);
    }

    //TODO: getProducts for pagination

    public static function getAllProducts()
    {
        $query = "SELECT id, name, price, stock, image FROM product";
        $result = mysql_query($query);

        if ($result == false) {
            return array("response" => "failed");
        }

        $productArray = array("response" => "success");
        while ($row = mysql_fetch_array($result)) {
            array_push($productArray, array("id" => $row[0],
                "name" => $row[1],
                "price" => $row[2],
                "stock" => $row[3],
                "image" => $row[4]));
        }

        return $productArray;
    }

    public static function updateProduct($id, $productName, $price, $stock, $imagePath)
    {
        if (!self::productExistWithId($id)) {
            return array("response" => "failed");
        }

        $paramsArray = array();

        if (strlen($productName) > 0) {
            array_push($paramsArray, "name='$productName'");
        }
        if (strlen($price) > 0) {
            array_push($paramsArray, "price=$price");
        }
        if (strlen($stock) > 0) {
            array_push($paramsArray, "stock=$stock");
        }
        if (strlen($imagePath) > 0) {
            array_push($paramsArray, "image='$imagePath'");
        }

        $queryParams = "";

        for ($i = 0; $i < count($paramsArray); $i++) {
            $queryParams .= $paramsArray[$i];
            if ($i < count($paramsArray) - 1) {
                $queryParams .= ",";
            }
        }

        $query = "UPDATE product SET $queryParams WHERE id=$id";
        $result = mysql_query($query);

        return $result === true ? array("response" => "success") : array("response" => "failed");
    }

    public static function deleteProduct($id)
    {
        if (!self::productExistWithId($id)) {
            return array("response" => "failed");
        }

        $query = "DELETE FROM product WHERE id=$id";
        $result = mysql_query($query);

        return $result === true ? array("response" => "success") : array("response" => "failed");

    }

    public static function getStockForProduct($productId)
    {
        if (!self::productExistWithId($productId)) {
            return array("response" => "failed");
        }

        $query = "SELECT stock FROM product WHERE id=$productId";
        $result = mysql_query($query);

        if ($result === false) {
            return array("response" => "failed");
        }

        return array("response" => "success", "stock" => mysql_result($result, 0, "stock"));
    }

    public static function removeFromStock($productId, $buc = 1)
    {
        $response = self::getStockForProduct($productId);
        if ($response["response"] == "failed") {
            return array("response" => "failed");
        }

        $stock = intval($response["stock"]);
        if ($stock > 0) {
            self::updateProduct($productId, null, null, $stock - $buc, null);
            return array("response" => "success");
        }

        return array("response" => "no stock");
    }

    public static function addToStock($productId, $buc = 1)
    {
        if (!self::productExistWithId($productId)) {
            return array("response" => "failed");
        }

        $query = "UPDATE product SET stock = stock + $buc";
        $result = mysql_query($query);

        return $result == false ? array("response" => "failed") : array("response" => "success");
    }
}