<?php
session_start();
if(isset($_SESSION['admin']) && !empty($_SESSION["admin"])){
    session_destroy();
    header('Location: produits.php');
}
?>