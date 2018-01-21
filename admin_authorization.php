<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: http://localhost/proiect/index.php");
    exit();
}