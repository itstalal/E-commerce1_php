<?php
include "header.php";

$id_commande = $_GET['id'];
$commandes = getcommandeById($id_commande);
$commande = $commandes[0];
if (isset($_POST["appliquer"])) {
    $tab = ["id_commande" => $id_commande, "etat" => $_POST["etats"]];
    updateEtat($tab);
    header("Location: ./commandes.php");
}
// $utilisateur = getUserById($commande['id_utilisateur']);

// var_dump($commande);


?>



<div class="container mt-5">
    <h1 class="mb-4">Détails de la Commande</h1>

    <!-- Détails de la commande -->
    <form method="post">
    <div class="order-summary">
        <h2>Commande <?php echo $commande['id_commande'] ?> </h2>
        <p><strong>Date :</strong><?php echo $commande['date_commane'] ?> </p>
        <p><strong>Statut :</strong><?php echo $commande['etat'] ?></p>
        <select name="etats">
            <option value="en attente" <?php if ($commande['etat'] == "en attente") {
                                            echo "selected";
                                        } ?>>en attente</option>
            <option value="en cour de traitement" <?php if ($commande['etat'] == "en cour de traitement") {
                                                        echo "selected";
                                                    } ?>>en cour de traitement</option>
            <option value="livre" <?php if ($commande['etat'] == "en livre") {
                                        echo "selected";
                                    } ?>>livre</option>
        </select>


        <!-- Informations client -->
        <div class="mb-4">
            <h4>Informations Client</h4>
            <p><strong>Nom :</strong>
                <?php  ?> <?php echo $commande['prenom'] ?></p>
            <p><strong>Adresse :</strong> <?php echo $commande['rue'] ?>,<?php echo $commande['ville'] ?> </p>
            </p>
        </div>

        <!-- Liste des produits -->
        <h4>Produits Commandés</h4>
        <?php $i = 1;
        foreach ($commandes as $commande) { ?>
            <div class="order-item">
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>Produit :</strong>produit <?php echo $i;
                                                                $i++ ?></p>
                        <p><strong>Description :</strong> <?php echo $commande['descriptions'] ?></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p><strong>Quantité :</strong> <?php echo $commande['quantite'] ?></p>
                        <p><strong>Prix Unitaire :</strong> <?php echo $commande['prix_unitaire'] ?></p>
                        <p><strong>Total :</strong>
                            <?php echo $commande['quantite'] * $commande['prix_unitaire'] ?></p><br>
                    </div>

                </div>
            </div>
        <?php } ?>
        <!-- Total de la commande -->
        <div class="mt-4">
            <h4>Total de la Commande</h4>
            <p><strong>Total Avant Taxes :</strong><?php
                                                    echo $commande["prix"] ?></p>
            <p><strong>Taxes :</strong>
                <?php $taxe = $commande["prix"] * 0.15;
                echo $taxe ?></p>
            <p><strong>Total Général :</strong>
                <?php $total = $commande["prix"] + $taxe;
                echo $total; ?></p>
        </div>

    <input type="submit" name="appliquer" value="Appliquer">
</form>
    </div>
</div>

<!-- Lien vers Bootstrap JS et Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>