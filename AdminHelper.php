<?php

class AdminHelper
{
    public static function displayTableFor($tableName, $elements, $pageNumbers)
    {
        switch ($tableName) {
            case "product":

                echo "<table class='table table-bordered table-hover'>";
                echo "<thead class='thead-light'>";
                echo "<tr>";
                echo "<th>Id</th>";
                echo "<th>Nume</th>";
                echo "<th>Pret</th>";
                echo "<th>Stoc</th>";
                echo "<th>Imagine</th>";
                echo "</tr>";
                echo "</thead>";


                for ($i = 0; $i < count($elements) - 1; $i++) {
                    $id = $elements[$i]['id'];
                    $name = $elements[$i]['name'];
                    $price = $elements[$i]['price'];
                    $stock = $elements[$i]['stock'];
                    $image = $elements[$i]['image'];

                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$price</td>";
                    echo "<td>$stock</td>";
                    echo "<td>$image</td>";
                    echo "<td class='text-center'><form action='product_admin.php?product_id=$id' method='POST'>
                        <input type='submit' name='edit_product' value='Modifica'>
                        <input type='submit' name='delete_product' value='Sterge produs'>
                        </form>
                    </td>";
                }

                echo "</table>";
                if ($pageNumbers > 1) {

                    echo "<div class='row'>";
                    echo "<div class='col-sm-12 text-center'>";

                    for ($i = 0; $i < $pageNumbers; $i++) {
                        $pageNumber = $i + 1;

                        echo "<a href='administration.php?product_page=$pageNumber'>[$pageNumber]</a> &nbsp;";
                    }

                    echo "</div>";
                    echo "</div>";
                }

                break;
            case "user":

                echo "<table class='table table-bordered table-hover'>";
                echo "<thead class='thead-light'>";
                echo "<tr>";
                echo "<th>Id</th>";
                echo "<th>Username</th>";
                echo "<th>Email</th>";
                echo "<th>Este admin</th>";
                echo "</tr>";
                echo "</thead>";


                for ($i = 0; $i < count($elements) - 1; $i++) {
                    $id = $elements[$i]['id'];
                    $username = $elements[$i]['username'];
                    $email = $elements[$i]['email'];
                    $admin = $elements[$i]['admin'];
                    $admin = $admin == 1 ? "DA" : "NU";
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$username</td>";
                    echo "<td>$email</td>";
                    echo "<td>$admin</td>";
                    echo "<td class='text-center'><form action='user_admin.php?user_id=$id' method='POST'>
                        <input type='submit' name='edit_user' value='Modifica'>
                        <input type='submit' name='delete_user' value='Sterge utilizator'>
                        </form>
                    </td>";
                }

                echo "</table>";

                if ($pageNumbers > 1) {

                    echo "<div class='row'>";
                    echo "<div class='col-sm-12 text-center'>";

                    for ($i = 0; $i < $pageNumbers; $i++) {
                        $pageNumber = $i + 1;

                        echo "<a href='administration.php?user_page=$pageNumber'>[$pageNumber]</a> &nbsp;";
                    }
                    echo "</div>";
                    echo "</div>";
                }
                break;
        }
    }
}