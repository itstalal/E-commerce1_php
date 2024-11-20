<?php 

 include './header.php';

 if(!isset($_SESSION['utilisateur'])){
    header("Location: ../../db/CONNEXION.php");


 }
// var_dump($_POST);
$id_produit=$_POST['id_produit'];
$quantite = $_POST['quantite'];
$id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
// var_dump($id_utilisateur);die();

if(!empty($id_produit) && !empty($quantite)){

    if(!isset($_SESSION['panier'][$id_utilisateur])){
        $_SESSION['panier'][$id_utilisateur]=[];
    }

if($quantite == 0){
    unset( $_SESSION['panier'][$id_utilisateur][$id_produit]);
}
else{

    $_SESSION['panier'][$id_utilisateur][$id_produit] = $quantite;
}

    
   var_dump($_SESSION['panier']) ; 
    
     var_dump($_SESSION['utilisateur']);
     var_dump($_SESSION['panier'][$id_utilisateur][$id_produit]);

  
}



?>

<body>
    <input type="text" value="<?= $_SESSION['panier'][$id_utilisateur][$id_produit]; ?>">
    <input type="text" value="<?= $_POST['nom']; ?>">
    <input type="text" value="<?= $_POST['prix_unitaire']; ?>">
</body>
