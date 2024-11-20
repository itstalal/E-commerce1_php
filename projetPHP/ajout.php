<?php
include 'header.php';
$consoles = getconsole();
$styles = getstyle();
// var_dump(connexionDB());
if (isset($_POST['btn-ajout'])) {
    var_dump($_POST);
  $resultat = ajoutProduit($_POST, $_FILES);
    
    if ($resultat) {
        ?>
        <script>
            window.location.href = "produits.php";
        </script>
        <?php

    } else {
        echo "Erreur";
    }
}


?>


<body class="container mt-5">
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom">
    </div>
    <div class="mb-3">
        <label for="prix_unitaire" class="form-label">Prix unitaire</label>
        <input type="text" class="form-control" id="prix_unitaire" name="prix_unitaire">
    </div>
    <div class="mb-3">
        <label for="quantite" class="form-label">Quantite</label>
        <input type="number" min="0" class="form-control" id="quantite" name="quantite">
    </div>
    <div class="mb-3">
        <label for="quantite" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Courte description" name="courte_description"
                  id="courte_description"></textarea>
        <label for="floatingTextarea">Courte description</label>
    </div>
    <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Description" name="description" id="description"></textarea>
        <label for="floatingTextarea">Description</label>
    </div>


    
    <div class="form-group">
        <label for="console_id">Consoles :</label>
        <select class="form-control" id="console" name="console[]" multiple required>
        <?php foreach($consoles as $console){?>
            <option value="<?=$console['id_console'] ?>"><?=$console['nom'] ?></option>
            <?php }?>
        </select>
    </div>

    <div class="form-group mb-3">
            <label> style :</label><br>
            <?php $i=0; foreach($styles as $style){?>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="console1" name="style" value="<?=$style['id_style']?>" required>
                <label class="form-check-label" for="console1"><?=$style['nom']?></label>
            </div>
    </div><?php }?>

    <input type="submit" class="btn btn-primary" name="btn-ajout" value="Ajouter un produit">
</form>


</body>
</html>