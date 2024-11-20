<?php

include './header.php';
if (isset($_SESSION['user_id']) && !empty($_SESSION["user_id"])) {
  header('Location: produits.php');
}

if (isset($_POST["btn_envoyer"])) {
  if (isset($_POST['username']) && !empty($_POST['username'])) {

    if (validateEmail($_POST['username'])) {

      if (isset($_POST['password']) && !empty($_POST['password'])) {
        $Users = connection(($_POST));


        if (connection($_POST) !== false) {
          $_SESSION['User_id'] = $Users['id_utilisateur'];
          $_SESSION['description'] = $Users['description'];

          header('Location: produits.php');
        } else $erreur = "email ou mot de passe inccorect";
      } else $erreur = "veuiller saisir votre mot de passe ";
    } else $erreur = " veuiller saisir un email valide";
  } else $erreur = "veuiller saisir un Username";
}


?>



<form class="container mt-5" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <?php if (isset($erreur)) {
    echo $erreur;
  } ?><br>
    <input type="submit" class="btn btn-primary" value="submit" name="btn_envoyer" />
</form>
</body>

</html>