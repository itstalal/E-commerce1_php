<?php
include 'header.php';

$id_utilisateur = $_GET['id'];
$User = getUtilidsateursByid($id_utilisateur);
$statut = getdescriptionRole($id_utilisateur);

if(isset($_POST['appliquer'])){
    $valeur = $_POST['statut'];
    if($valeur=="client" || $valeur = "admin"){
        $valeur = getRoleByDesc($valeur);
        updateStaututUser($id_utilisateur,$valeur['id_role']);
        header('Location: User.php');
    }
}

?>


<body class="mt-5">
    <form method="post" class="container ">
        <h1 class="text-center">information sur l'utilisateur <?= $User['courriel']?></h1>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" value="<?= $User['nom']?>" readonly>


        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prenom</label>
            <input type="text" class="form-control" name="prenom" value="<?= $User['prenom']?>" readonly>
        </div>
        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" name="date_naissance" value="<?= $User['date_naissance']?>"
                readonly>
        </div>
        <div class="mb-3">
            <label for="courriel" class="form-label">Courriel</label>
            <input type="email" placeholder="Entrer votre courriel" class="form-control" name="courriel"
                value="<?= $User['courriel']?>" readonly>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" placeholder="Entrer votre telephone" class="form-control" name="telephone"
                value="<?= $User['telephone']?>" readonly>
        </div>
        <div>
            <h2>statut : <?= $statut['description']?></h2>

            <select name="statut" id="">
                <option value="client" disabled="disable" selected>mofier le statut</option>
                <option value="<?php if($statut['description']=="admin"){echo"client";}else{echo"admin";}?>">
                    <?php if($statut['description']=="admin"){echo"client";}else{echo"admin";}?></option>
            </select>
            <input type="submit" name="appliquer" id="" name="appliquer" value="appliquer">
        </div>
    </form>

</body>

</html>