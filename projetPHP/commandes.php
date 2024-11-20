<?php
session_start();
if (!$_SESSION['utilisateur'] || $_SESSION['utilisateur']['description'] == "client") {
    header('Location: ../src/scroll_animation');
}
else{
// include 'header.php';
require_once '../db/fonction.php';
$commandes = getcommandes();
}

?>

<body class="container">
    <?php include 'navbar2.php ';
    echo "<br><br><br><br><br><br>"; ?>
    <h1 class="text-center text-primary mt-5">Listes des commandes</h1> 
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">num_comm</th>
                <th scope="col">num_utilisateur</th>
                <th scope="col">quantite</th>
                <th scope="col">Prix</th>
                <th scope="col">date commande</th>
                <th scope="col">Etat</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($commandes as $commande) { ?>
                <tr>
                    <th scope="row"><?= $i++; ?></th>

                    <td><?= $commande['id_commande']; ?></td>

                    <td><?= $commande['id_utilisateur']; ?></td>
                    <td><?= $commande['quantite']; ?></td>
                    <td><?= $commande['prix']; ?></td>
                    <td><?= $commande['date_commane']; ?></td>
                    <td><?= $commande['etat']; ?></td>



                    <td>
                        <a class="btn btn-info" href="voir_commande.php?id=<?= $commande['id_commande']; ?>"><i class="bi bi-eye"></i></a>
                       
                       
                    </td>
                </tr>
            <?php } ?>


        </tbody>
    </table>

</body>

</html>