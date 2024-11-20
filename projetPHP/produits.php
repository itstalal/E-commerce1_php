<?php
include 'header.php';
if (!$_SESSION['utilisateur'] || $_SESSION['utilisateur']['description'] == "client") {
    header('Location: ../src/scroll_animation');
}

$produits = getProduits();
// echo $_SESSION['description'];
// echo $_SESSION['id_utilisateur'];

?>

<body class="container">
<?php include 'navbar2.php';
 echo "<br><br><br><br><br><br>";?>
    <h1 class="text-center text-primary mt-5">Listes des produits</h1>
    <a class="btn btn-primary" href="ajout.php">Ajouter un nouveau produit</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">image</th>
                <th scope="col">Nom</th>
                <th scope="col">Quantite</th>
                <th scope="col">Prix unitaire</th>
                <th scope="col">console</th>
                <th scope="col">style</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($produits as $produit) { ?>
                <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td>
                        <img height="50px" width="50px" src=" <?php echo (isset($produit['chemin']) && !empty($produit['chemin'])) ?
                                                               $produit['chemin'] : './images/image-back.png';

                                                                ?> ">
                    </td>
                    <td><?= $produit['nom']; ?></td>

                    <td><?= $produit['quantite']; ?></td>
                    <td><?= $produit['prix_unitaire']; ?></td>
                    <td><?= $produit['console']; ?></td>
                    <td><?= $produit['style']; ?></td>

                    <td>
                        <a class="btn btn-info" href=""><i class="bi bi-eye"></i></a>
                        <a class="btn btn-primary" href="modifier_produit.php?id=<?= $produit['id_produit']; ?>"><i class="bi bi-pencil-square"></i></a>
                        <a class="btn btn-danger" href="supprimer_produit.php?id=<?= $produit['id_produit']; ?>"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>


        </tbody>
    </table>

</body>

</html>