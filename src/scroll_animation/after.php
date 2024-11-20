<?php
include 'header.php';






if (isset($_GET['action']) && isset($_GET['id'])) {
    $id_produit = $_GET['id'];
    if ($_GET['action'] == 'ajouter') {
        ajouterProduit($id_produit);
    } elseif ($_GET['action'] == 'diminuer') {
        diminuerProduit($id_produit);
    }
    header("Location: panier.php");
    exit;
}


$produits = getProduits();

    $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur']; 
    $panier = isset($_SESSION['Paniers'][$id_utilisateur]) ? $_SESSION['Paniers'][$id_utilisateur] : [];




$message = "";
if (isset($_POST['commde'])) {
    $message = AJOUTER_COMMANDE();
}
?>

<head>
   
    <style>
        .container {
    width: 1400px;
    height: 650px;
}

.app-color-blue-1 {
    color: #346EE1;
}

.app-color-blue-3 {
    color: #A0B4D6;
}

.app-color-black {
    color: #3E4350;
}

.app-color-gray-1 {
    color: #949AA7;
}

.app-color-red {
    color: #949AA7;
}

.app-bg-blue-1 {
    background: #346EE1;
}

.app-bg-blue-2{
    background: #F5F9FC;
}

.app-button-shadow {
    box-shadow: 0px 5px 10px 0px rgb(145 167 210 / 25%);
}

.app-bg-blue-3 {
    background: #4A7AE5;
}

.app-bg-blue-4 {
    background: #518AEA;
}

.app-bg-white-1 {
    background: #F4F8F9;
}

.app-color-yellow-1 {
    color: #D7AC67;
}

.app-bg-yellow-2 {
    background: #FFF9EB;
}

.app-bg-yellow-3 {
    background: #FFBE4E;
}

.app-border-1 {
    border: 1px solid #F4F6F9;
}

.app-color-red-1 {
    color: #E0899C;
}

.app-bg-red-2 {
    background: #FEF5F6;
}

.app-color-green {
    color: #0CBDA8;
}

.active {
    position: relative;
    box-shadow: 6px -6px 11px 0 rgb(0 0 0 / 8%);
}

.active::before {
    position: absolute;
    content: '';
    width: 4px;
    height: 55%;
    background-color: #346EE1;
    top: 20px;
    left: 0;
}
    </style>
</head>
<body class="">
    
    <div class="" >
        
        <div class="flex flex-col app-bg-white-1 px-12 pb-10">
          
            
            <div class="flex flex-row bg-white p-10 relative" style="top: 100px;">
                
                 
    <?php 
    
    if (empty($panier)) { ?>

<div style="margin-left: 500px;" >
    <h5 class="text-center text-danger">Votre panier est vide.   </h5> 
    <a href="index.php" class="btn btn-info mt-3"  style=" right: -20px;">Consulter la liste des produits</a>

         </div>
    
    <?php } 
    
    else { ?>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left text-xs app-color-black pb-5">Titre</th>
                            <th class="text-left text-xs app-color-black pb-5">Quantité</th>
                            <th class="text-left text-xs app-color-black pb-5">Prix</th>
                            <th class="text-left text-xs app-color-black pb-5">Prix total</th>
                            <th class="text-left text-xs app-color-black pb-5">Actions</th>
                            
                           
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                $totalGeneral = 0;
                foreach ($panier as $id => $quantite) {
                    foreach ($produits as $produit) {
                        if ($produit['id_produit'] == $id) {
                            $total = $produit['prix_unitaire'] * $quantite;
                            $totalGeneral += $total;
                            $imagePath = !empty($produit['chemin']) ? $produit['chemin'] : './images/th.jpeg';
                            ?>
                        <tr class="app-border-1">
                           
                            <td>
                                <div class="flex flex-row items-center py-3">
                                    <div class="w-10 h-10 bg-yellow-50 rounded-full mr-5">
                                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>" style="width: 50px; height: auto;">
                                    </div>
                                    
                                </div>
                            </td>
                            <td>
                                <span class="font-semibold text-sm app-color-gray-1"><?= htmlspecialchars($produit['nom']); ?></span>    
                            </td>
                            <td>
                                <span class="font-semibold text-sm app-color-gray-1"><?= $quantite; ?></span>
                            </td>
                            <td>
                            <span class="font-semibold text-sm app-color-gray-1"><?= htmlspecialchars($produit['prix_unitaire']); ?>$</span>
                            </td>
                            <td>
                            <span class="font-semibold text-sm app-color-gray-1"><?= $total; ?>$</span>
                            </td>

        
                            <td>
                            
                                <a href="PANIER.php?action=diminuer&id=<?= $produit['id_produit']; ?>" class="btn btn-danger btn-sm">-</a>
                                <?php if($produit['quantite']>$quantite){ ?>
                                <a href="PANIER.php?action=ajouter&id=<?=  $produit['id_produit']; ?>" class="btn btn-success btn-sm">+</a>
                              <?php  }?>
                            </td>
                          </tr>
                          <?php
                        }
                    }
                }
                
                ?>
                 <tr>
                    <td colspan="3" class="text-right"><strong>Total Général:</strong></td>
                    <td colspan="2"><?= $totalGeneral; ?>$</td>
                </tr>
                    </tbody>
                </table>
                <div class="btn-center" >
                    <form action="checkout.php" method="post">
                        <input type="submit" value="Continuer vos achats"  class="btn btn-warning ">  
                    </form>
            <?php
            if (isset($_SESSION['utilisateur'])) {
                echo '<a href="#" class="btn btn-primary p-2 mt-3" name="commde">passer la commande.</a> ';;
            } else {
                echo ' <br> <a href="../../db/CONNEXION.php" class="btn btn-primary p-2 mt-3" name="commde">passer la commande</a>';
            }
            ?>
            </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
