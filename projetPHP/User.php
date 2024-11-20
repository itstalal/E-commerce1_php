<?php
// include 'header.php';
require '../db/fonction.php';
$Users = getUtilisateurs();


?>

<body class="container">
<?php include 'navbar2.php '; echo "<br><br><br><br><br><br>"; ?>
    <h1 class="text-center text-primary mt-5">Listes des utilisateurs</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">image</th>
                <th scope="col">Nom complet</th>
                <th scope="col">age</th>
                <th scope="col">Courriel</th>
                <th scope="col">Téléphone</th>

            </tr>
        </thead>
        <tbody>
            <?php
    $i = 1;
    foreach ($Users as $User) { ?>
            <tr>
                <th scope="row"><?= $i++; ?></th>
                <td>
                    <img height="50px" width="50px" src=" <?php echo (isset($User['chemin']) && !empty($User['chemin'])) ?
                   $User['chemin'] : './image2/nophoto.png';
                ?> ">
                </td>
                <td><?= $User['nom']." ".$User['prenom']; ?></td>
                <td><?= calculAge($User['date_naissance']); ?></td>
                <td><?= $User['courriel'] ?></td>
                <td><?= $User['telephone'] ?></td>

                <td>
                    <a class="btn btn-info" href="./voir_user.php?id=<?= $User["id_utilisateur"]; ?>"><i
                            class="bi bi-eye"></i></a>
                    <a class="btn btn-danger" href="./supprimer_user.php?id=<?= $User["id_utilisateur"]; ?>"><i
                            class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php } ?>


        </tbody>
    </table>

</body>

</html>