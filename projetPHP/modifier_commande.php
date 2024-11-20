<?php  
include './header.php';
$id_commande = $_GET['id'];
$commande = getcommandeById($id_commande);
var_dump($commande);
?>