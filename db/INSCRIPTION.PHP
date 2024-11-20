<?php
include './header.php';
require_once './fonction.php';
$questions = getquestion();

if (isset($_POST['btn-insc'])) {
  $resultat = Inscription($_POST, $_FILES);
  $tab = ["rue" => $_POST["rue"], "ville" => $_POST['ville'], "code_postal" => $_POST['code_postal'], "numero" => $_POST['numero'], "province" => $_POST['province']];
   echo "<br>";
  insertAdresse($tab);
  $utilisateur = getUtilisateurByEmail($_POST['courriel']);
 
  

  insertUtilisateur_addresse($tab2);
  if (!$resultat) {
    $error_message = "Vueillez rentrer correctement vos information!";
    echo "<p style='color: red;'>Erreur : $error_message</p>";
  } else {
    header('Location: ./CONNEXION.php');
  }
}
// var_dump($_POST);
?>

<!-- 
<body class="container mt-5">
<form method="post">
  <div class="mb-3">
    <label for="nom" class="form-label">NOM</label>
    <input type="text" class="form-control" id="nom" aria-describedby="emailHelp" name="nom">
  </div>
  <div class="mb-3">
    <label for="pricunitaire" class="form-label">PRENOM</label>
    <input type="text" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="prenom">
  </div>
  <div class="mb-3">
    <label for="quantite" class="form-label">DATE DE NAISSANCE</label>
    <input type="date" class="form-control" id="quantite" aria-describedby="emailHelp" name="date_de_naissance">
  </div>
  <div class="mb-3">
    <label for="pricunitaire" class="form-label">TELEPHONE</label>
    <input type="text" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="telephone">
  </div>
  <div class="mb-3">
    <label for="pricunitaire" class="form-label">COURIEL</label>
    <input type="text" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="courriel">
  </div>
  <div class="mb-3">
    <label for="pricunitaire" class="form-label">MOT DE PASSE</label>
    <input type="password" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="mot_de_passe">
  </div>
   <div class="mb-3">
    <label for="pricunitaire" class="form-label">CONFIRMER VOTRE MOT DE PASSE</label>
    <input type="password" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="confmdp">
  </div> 
  <label for="pricunitaire" class="form-label">choisir une question de sécurité</label>

   <br>

<div class="mb-3">
    <input type="text" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="security_answer">
  </div> 
<br>
  <input type="submit" value="suivant" name="btn-insc" class="btn btn-primary container">
  </form> -->

<section class="bg-gray-50 min-h-screen flex items-center justify-center">
  <!-- login container -->
  <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
    <!-- form -->
    <div class="md:w-1/2 px-8 md:px-16">
      <h2 class="font-bold text-2xl text-[#002D74]">S'inscrire</h2>
      <p class="text-xs mt-4 text-[#002D74]">Bienvenue chez GameHaven</p>

      <form method="post" enctype="multipart/form-data" class="flex flex-col gap-4">
        <input type="file" name="image">

        <input class="p-2 mt-8 rounded-xl border" type="text" name="nom" placeholder="Nom">
        <input class="p-2 rounded-xl border w-full" type="text" name="prenom" placeholder="Prenom">
        <input class="p-2 rounded-xl border w-full" type="date" name="date_de_naissance" placeholder="Date de naissance">
        <input class="p-2 rounded-xl border w-full" type="number" name="telephone" placeholder="Telephone">
        <label>
          <input type="radio" name="sexe" value="homme"> Homme
        </label>
        <label>
          <input type="radio" name="sexe" value="femme"> Femme
        </label>
        <input class="p-2 rounded-xl border w-full" type="email" name="courriel" placeholder="exemple01@gmail.com">
        <input class="p-2 rounded-xl border w-full" type="password" name="mot_de_passe" placeholder="mot de passe">
        <input class="p-2 rounded-xl border w-full" type="password" name="confmdp" placeholder="confirmer mot de passe">
        <input class="p-2 rounded-xl border w-full" type="text" name="rue" placeholder="rue">
        <input class="p-2 rounded-xl border w-full" type="text" name="ville" placeholder="ville">
        <input class="p-2 rounded-xl border w-full" type="text" name="province" placeholder="province">
        <input class="p-2 rounded-xl border w-full" type="text" name="code_postal" placeholder="postal">
        <input class="p-2 rounded-xl border w-full" type="text" name="numero" placeholder="numero">


        <select class="form-select p-2 mt-8 rounded-xl border" aria-label="Default select example" name="question" required>
          <?php foreach ($questions as $question) { ?>
            <option value="<?php echo $question['id_question']; ?>"><?php echo $question['question']; ?></option>
          <?php } ?>
        </select>

        <input class="p-2 rounded-xl border w-full" type="password" name="security_answer" placeholder="Reponse">

        <input type="submit" value="Suivant" name="btn-insc" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300">
      </form>







      <div class="mt-3 text-xs flex justify-between items-center text-[#002D74]">
        <p>Vous avez deja un compte?</p>
        <a href="CONNEXION.php" class="py-2 px-5 bg-white border rounded-xl hover:scale-110 duration-300">connexion</a>
      </div>
    </div>

    <!-- image -->
    <div class="md:block hidden w-1/2">
      <img class="rounded-2xl" src="https://images.unsplash.com/photo-1616606103915-dea7be788566?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1887&q=80">
    </div>
  </div>
</section>