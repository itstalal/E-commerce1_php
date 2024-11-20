<?php

//if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
//header('Location: commandes.php');
//exit();
//} else {
include 'header.php';
$id_produit = $_GET['id'];
$id_commande = $_GET['id2'];

$resultat = deleteProduit_commande($id_commande, $id_produit);
if ($resultat) {
?>
    <script>
        window.location.href = "modifier_commande.php?id=<?= $id_commande ?>";
    </script>
<?php
} else {
}
//}


?>