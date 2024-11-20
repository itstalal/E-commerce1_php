<?php 
include './header.php';


if (isset($_SESSION['utilisateur'])) {
    $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];


    if (isset($_SESSION['Paniers']) && !empty($_SESSION['Paniers'])) {
        sauvegarder_panier($id_utilisateur, $_SESSION['Paniers']);
    }

    
    unset($_SESSION['utilisateur']);
}

session_destroy();
header("Location: ../src/scroll_animation/");
exit;

?>
