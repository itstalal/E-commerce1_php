<?php
 include 'header.php';
 $produits = getProduitsbypsv();

 ?>

<body>
    <!-- title -->

 <?php
 include './navbar.php';
 echo"<br><br><br><br><br><br>"; ?>
<h1 class="text-primary text-left fs-1"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jeux PS5</h1>
    
    <section  id="Projects"
    class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
    <?php foreach ($produits as $produit) {  ?>
    <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
            <a href="voirproduit.php?id=<?= $produit['id_produit']; ?>">
                <img src="<?php 
        if(isset($produit['chemin']) && !empty($produit['chemin'])){
          echo $produit['chemin'];
        }else{
          echo "../upload/images/backolo.jpeg";
        }
        ?>" height="auto";
                    alt="Product" class=" w-72 object-cover rounded-t-xl" />
                <div class="px-4 py-3 w-72">
                    <span class="text-gray-400 mr-3 uppercase text-xs">Brand</span>
                    <p class="text-lg font-bold text-black truncate block capitalize"> <?= $produit['nom']; ?></p>
                    <div class="flex items-center">
                        <p class="text-lg font-semibold text-success cursor-auto my-3 "> <?= $produit['prix_unitaire']; ?>$</p>
                        
                        <div class="ml-auto">
                            <a href="PANIER.php?action=ajouter&id=<?= $produit['id_produit']; ?>" class="btn btn-white"><i class="bi bi-bag-plus-fill"></i></a>
                           
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </section>
   


 


</body>

</html>
