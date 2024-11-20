<?php
include 'header.php';

// var_dump(connexionDB());
if (isset($_POST['inscription'])) {
    $resultat = inscription($_POST,$_FILES);
    
    if ($resultat) {
        ?>
        <script>
            window.location.href = "User.php";
        </script>
        <?php 
    } else {
        echo "Erreur";
    }

}
?>


<body class="container mt-5">
<form method="post" class="container " enctype="multipart/form-data">
    <h1 class="text-center">Inscription</h1>
  <div class="mb-3">
    <label for="nom" class="form-label">Nom</label>
    <input type="text" class="form-control" name="nom">
  </div>
  <div class="mb-3">
    <label for="prenom" class="form-label">Prenom</label>
    <input type="text" class="form-control" name="prenom">
  </div>
  <div class="mb-3">
    <label for="date_naissance" class="form-label">Date de naissance</label>
    <input type="date" class="form-control" name="date_de_naissance">
  </div> 
  <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
  <div class="mb-3">
    <label for="courriel" class="form-label">Courriel</label>
    <input type="email" placeholder="Entrer votre courriel" class="form-control" name="courriel">
  </div>
  <div class="mb-3">
    <label for="telephone" class="form-label">Téléphone</label>
    <input type="text" placeholder="Entrer votre telephone" class="form-control" name="telephone">
  </div>
  <div class="mb-3">
    <label for="mot_de_passe" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" name="mot_de_passe">
  </div>
  <div class="mb-3">
    <label for="c_mot_de_passe" class="form-label">Confirmer votre mot de passe</label>
    <input type="password" class="form-control" name="confmdp">
  </div>
  
  
  
  <input type="submit" name="inscription" class="btn btn-primary" value="Inscription">
</form>
    
</body>
</html>