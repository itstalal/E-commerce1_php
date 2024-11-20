<?php 
require_once './fonction.php';
include 'header.php';
$error ="";
// if(isset( $_SESSION['utilisateur'])){
// echo "";
// }
if(isset($_POST['btn-conn'])){
  $email = $_POST['courriel'];
  $utilisateur = getUtilisateurByEmail($email);
    if($utilisateur){
      // $_SESSION['utilisateur']= $utilisateur;
?>
    <script>
      window.location.href="recupmdp.php?id=<?php echo $utilisateur['id_utilisateur']; ?>";
    </script>
<?php
     
    }
    else
      $error = "Couriel n'existe pas";
      echo $error;
 }

?>
<section class="bg-gray-50 min-h-screen flex items-center justify-center">
  <!-- login container -->
  <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
    <!-- form -->
    <div class="md:w-1/2 px-8 md:px-16">
      <h2 class="font-bold text-2xl text-[#002D74]">Mot de passe oublié?</h2>


      <form method="post" class="flex flex-col gap-4">
        <input class="p-2 mt-8 rounded-xl border" type="email" name="courriel" placeholder="Email">
       
        <input type="submit" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300 text-center" value="réinitialiser le mot de passe" name="btn-conn">
      </form>


      <div class="mt-3 text-xs flex justify-between items-center text-[#002D74]">
        <a href="CONNEXION.php" class="py-2 px-5 ml-6 bg-white border rounded-xl hover:scale-110 duration-300">Connexion</a>
      </div>
    </div>

    <!-- image -->
    <div class="md:block hidden w-1/2">
      <img class="rounded-2xl" src="../src/scroll_animation/images/forgetpassword.png">
    </div>
  </div>
</section>
