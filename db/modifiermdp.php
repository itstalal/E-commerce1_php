<?php  
// if(!isset($_GET['id']) || !is_numeric($_GET['id']) ){
//     header('Location: modifi.php');
//     exit();}
// else{
    require_once './fonction.php';
    include 'header.php';
    if(isset($_POST['btn-insc'])){
        $_POST['id_utilisateur']=$_GET['id'];
        $mot_de_pass=$_POST['nouveau'];
        $c_mdp=$_POST['c_nouveau'];
        if($mot_de_pass==$c_mdp){

          if(verifier_mdp($mot_de_pass)){
                $mot_de_pass=password_hash($mot_de_pass,PASSWORD_DEFAULT);
  
              $sql= "UPDATE utilisateur set mot_de_passe = ? where id_utilisateur=?";
              $conn= connexionDB();
              $statment = mysqli_prepare($conn,$sql);
              mysqli_stmt_bind_param($statment,'si',$mot_de_pass,$_GET['id']);
              // insert/update/delete le resultat c'est du type bool
              $result = mysqli_stmt_execute($statment);
             
      
              if($result){
                  header('Location: CONNEXION.php');
              }
             
          }
        }

        else{
            echo"entrer un mot de passe valide";
        }
        }

        
        
       
   
    // if(isset($_POST['btn-insc'])){
    //    if(!$Update){
    //     echo "Vueillez rentrer un mot de passe valide";
    //    }

       
?>

<!-- <body class="container">
    
<h5 class="text-center">Modifier le mot de passe</h5>

<form method="post">

<div class="mb-3">
    <label>nouveau mot de passe</label>
    <input type="password" class="form-control" id="prixunitaire" aria-describedby="emailHelp" name="nouveau">
  </div> 
<br>
  <input type="submit" value="Modifier" name="btn-insc" class="btn btn-primary container">
</form>
</body> -->

<section class="bg-gray-50 min-h-screen flex items-center justify-center">
  <!-- login container -->
  <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
    <!-- form -->
    <div class="md:w-1/2 px-8 md:px-16">
                 <h2 class="font-bold text-2xl text-[#002D74]">Saisir un nouveau mot de passe</h2>


       <form method="post" class="flex flex-col gap-2">
         <input class="p-2 mt-8 rounded-xl border" type="password" name="nouveau" placeholder="Nouveau mot de passe">
         <input class="p-2 mt-8 rounded-xl border" type="password" name="c_nouveau" placeholder="Confirmer le mot de passe">
       
         <input type="submit" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300 text-center" value="réinitialiser le mot de passe" name="btn-insc">
       </form>

    </div>

    <!-- image -->
    <div class="md:block hidden w-1/2">
      <img class="rounded-2xl" src="../src/scroll_animation/images/forgetpassword.png">
    </div>
  </div>
</section>