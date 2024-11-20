<?php 
session_start();
if(!isset($_GET['id']) || !is_numeric($_GET['id']) ){
    header('Location: ../../src/scroll_animation');
    exit();

}
else{

  require '../../db/fonction.php';
     $id_produit = $_GET['id'];
     $produits = getProduitById($id_produit);
}

 $kolo= $_SESSION['$utilisateur'];
                       

?>
<body>
   
    <?php    include './navbar.php'; echo '<br>'?>

<form method="post" enctype="multipart/form-data">
<section class="bg-gray-50 min-h-screen flex items-center justify-center">
 <!-- login container -->
 <div class="bg-white-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
   <!-- form -->
   <div class="md:w-1/2 px-8 md:px-16 text-center">
       <input type="hidden" name="id_produit" value="<?= $produits['nom']; ?>">
     <input type="text" class="font-bold text-2xl text-[#002D74]  " name="nom" value="<?= $produits['nom']; ?>" readonly><br> <br>
  
     <div  class="flex flex-col gap-4 text-center">
       <input type="text" class="text-center t" name="courte_description" value="<?= $produits['courte_description']; ?>" readonly> 
       <br>
       <div class="relative">
         <input type="text" class=" text-success text-center" name="prix_unitaire" value=" <?= $produits['prix_unitaire']; ?> $" readonly>
         
       </div>
   </div>
   
   
   <!-- <div class="text-center">
     <a type="number" class="btn btn-white"  onclick="decrement()" style="width: 35px;"><i class="bi bi-dash-circle-fill"></i></a>
        <input  type="text" id="counterInput" value="0" style="width: 35px;" name="quantite" readonly > 
        <script>
            
        </script>
     <a type="number" id="valeurQ" class="btn btn-white" onclick="increment()" style="width: 35px;" ><i class="bi bi-plus-circle-fill "></i></a>
    </div> -->

     <?= "<br><br>"; ?>

     <div class="ml-auto">
                           <a href="PANIER.php?action=ajouter&id=<?= $produits['id_produit']; ?>"  class="btn btn-white" name="ajouter"><i class="bi bi-bag-plus-fill"></i> &nbsp; Ajouter au panier</a>
                          
                       </div>
                       

     
   </div>

   <!-- image -->
   <div class="md:block hidden w-1/2">
     <img class="rounded-2xl" src="<?php 
       if(isset($produits['chemin']) && !empty($produits['chemin'])){
         echo $produits['chemin'];
       }else{
         echo "../upload/images/backolo.jpeg";
       }
       ?>">
   </div>
 </div>
</section>
</form>
 </body>



<script>


const counterInput = document.getElementById('counterInput');  
let count = 0;
let max_count= <?= $produits["quantite"]; ?>;
let showCount = getElementById("valeurQ");

function increment() {
  if(max_count>count){
      
      count++;
      counterInput.value = count;
    }
}

// Fonction pour décrémenter le compteur
function decrement() {
  if (count > 0) {
    count--;
    counterInput.value = count;
  }
}

</script>

<div class="container">

  <?php 
  echo "<br><br><br>";
  include './allproduits.php';
  ?>
</div>