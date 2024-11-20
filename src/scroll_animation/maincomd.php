<?php
session_start();


// include 'header.php';
require_once '../../db/fonction.php';
$id_User=$_SESSION['utilisateur']['id_utilisateur'];
$commandes = getcommandeByIduser($id_User);


?>

<body class="container">
    <?php include 'navbar.php ';
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
                

            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if($commandes==false){
                echo "<h4 class='container text-danger'>Vous navez pas de commande</h4>";
            }else{
            foreach ($commandes as $commande) { ?>
                <tr>
                    <th scope="row"><?= $i++; ?></th>

                    <td><?= $commande['id_commande']; ?></td>

                    <td><?= $commande['id_utilisateur']; ?></td>
                    <td><?= $commande['quantite']; ?></td>
                    <td><?= $commande['prix']; ?></td>
                    <td><?= $commande['date_commane']; ?></td>
                    <td><?= $commande['etat']; ?></td>



                   
                </tr>
            <?php } }?>


        </tbody>
    </table>

</body>

</html>