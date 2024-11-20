<?php  
if(!isset($_GET['id']) || !is_numeric($_GET['id']) ){
    header('Location: forgetmdp.php');
    exit();}
else{
    require_once './fonction.php';
    include 'header.php';

    $utilisateur = getUserById($_GET['id']);
    $id_question =$utilisateur['question'];
    $question= getquestionbyid($id_question);
    $reponses = $utilisateur['security_answer'];
    if(isset($_POST['btn-insc'])){
        if($reponses == $_POST['security_answer']){
           
       ?>
       <script>
        window.location.href="modifiermdp.php?id=<?php echo $utilisateur['id_utilisateur']; ?>";
       </script>
       <?php
        }
    }
 
}
    
       
?>

<section class="bg-gray-50 min-h-screen flex items-center justify-center">
  <!-- login container -->
  <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
    <!-- form -->
    <div class="md:w-1/2 px-8 md:px-16">
      <h2 class="font-bold text-2xl text-[#002D74]">Mot de passe oublié?</h2>


      <form method="post" class="flex flex-col gap-3">
        <input class="p-2  mt-8 rounded-xl border" type="text" name="question" value="<?php echo $question['question']; ?>" >
        <input class="p-2 mt-8 rounded-xl border" type="text" placeholder="Reponse"  name="security_answer">
       
        <input type="submit" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300 text-center" value="Suivant" name="btn-insc">
      </form>

    </div>

    <!-- image -->
    <div class="md:block hidden w-1/2">
      <img class="rounded-2xl" src="../src/scroll_animation/images/forgetpassword.png">
    </div>
  </div>
</section>



