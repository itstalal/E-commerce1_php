<?php
    include 'header.php';
    $produits = getProduits();
    $consoles = getconsole();
    $styles = getstyle();

    $id_produit = $_GET['id'];
    
    if(!verifierProduit($produits)){
        header('Location: produits.php');
    }
    $produit = getProduitById($id_produit);
    $consoles_choisit = explode(',',$produit['console']);

    
    if (isset($_POST['btn-mdp'])) {
        
        if(isset($_POST['chckmodifier'])){
          deleteImage($id_produit);
        }
        $_POST['id_produit'] = $id_produit;
       $resultat = updateProduit($_POST,$_FILES);
        if ($resultat) {
             header('Location: produits.php');
        } else {
        }
}
?>

<body class="container mt-5">
<h1 class="text-center text-primary">Modification de produit</h1>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= $produit['nom']; ?>">
    </div>
    <div class="mb-3">
        <label for="prix_unitaire" class="form-label">Prix unitaire</label>
        <input type="text" class="form-control" id="prix_unitaire" name="prix_unitaire"
               value="<?= $produit['prix_unitaire']; ?>">
    </div>
    <div class="mb-3">
        <label for="quantite" class="form-label">Quantite</label>
        <input type="number" min="0" class="form-control" id="quantite" name="quantite"
               value="<?= $produit['quantite']; ?>">
    </div>
    <div class="mb-3">
        <label for="quantite" class="form-label">image actuel  : </label>
        
        <img height="80px" width="80px" src=" <?php echo (isset($produit['chemin']) && !empty($produit['chemin'])) ?
                   "PROJET_Final_Php/".$produit['chemin'] : './images/image-back.png';?> "><br>
        <label for="">modifier l'image</label>
        <input type="checkbox" name="chckmodifier" id="check" width="20px" height="20px">
    </div>
    <div class="mb-3" id="img">
        <input type="file" class="form-control"  name="image" class="mb-3" >
    </div>
    <div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Courte description" name="courte_description" id="courte_description">
  <?= $produit['courte_description']; ?>
  </textarea>
        <label for="floatingTextarea">Courte description</label>
    </div>
    <div class="form-floating mb-3">
  <textarea class="form-control" placeholder="Description" name="description" id="description">
  <?= $produit['descriptions']; ?>
  </textarea>
        <label for="floatingTextarea">Description</label>
    </div>

    <div class="form-group">
        <label for="console_id">Consoles :</label>
        <select class="form-control" id="console" name="console[]" multiple required>
        <?php foreach($consoles as $console){
            ?>
            <option value="<?=$console['id_console'] ?>" <?php foreach($consoles_choisit as $c){if(trim($c)==trim($console['nom'])){echo "selected";}}?> > <?=$console['nom'] ?></option>
            <?php }?>
        </select>
    </div>

    <div class="form-group mb-3">
            <label> style :</label><br>
            <?php $i=0; foreach($styles as $style){?>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="console1" name="style" <?php if($style['nom']==$produit['style']){echo'checked';} ?> value="<?=$style['id_style']?>" required>
                <label class="form-check-label" for="console1"><?=$style['nom']?></label>
            </div>
    </div><?php }?> 

    <input type="submit" class="btn btn-primary" name="btn-mdp" value="Modifier un produit">
</form>

<script>
       var image =document.getElementById("img");
       var checkbox = document.getElementById("check");
       checkbox.addEventListener('change', function(){
            if (checkbox.checked) {
                image.style.display = 'flex'; 
            } else {
                image.style.display = 'none';
            }
        });
</script>
</body>
</html>