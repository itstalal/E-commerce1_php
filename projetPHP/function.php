<?php
require_once './gestion_utilisateurs.php';
include './config.php';

/**
 * fonction qui permet de se connecter la base de donnée
 *
 * @return mysqli | bool
 */
function connexionDB()
{
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn != true) {
        die('Erreur de connection avec la base de donnée : ' . mysqli_connect_error());
    } else {
        return $conn;
    }
}

function ajoutProduit($produit, $data)
{
    $nom = $produit['nom'];
    $prix_unitaire = $produit['prix_unitaire'];
    $quantite = $produit['quantite'];
    $courte_description = $produit['courte_description'];
    $description = $produit['description'];
    $id_style = $produit['style'];
    $consoles = $produit['console'];



    // select * from produit where id = select * from produit 

    $sql = "insert into Produit(nom,quantite,courte_description,descriptions,prix_unitaire,id_style) 
    values(?,?,?,?,?,?)";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'sisssi', $nom, $quantite, $courte_description, $description, $prix_unitaire, $id_style);
    // insert, update, delete le resultat c'est du type bool 
    $resultat = mysqli_stmt_execute($statment);
    if ($resultat) {
        $id_produit = mysqli_insert_id($connex);
        uplaodImage($data, $id_produit);
        foreach ($consoles as $console) {
            insertconsoleUtilisateur($console, $id_produit);
        }
        return true;
    }
    return $resultat;
}

function getProduits()
{
    $sql = "SELECT p.*,i.chemin, GROUP_CONCAT(c.nom SEPARATOR ', ') AS console,s.nom as style from produit p LEFT JOIN Image_produit i on p.id_produit = i.id_produit 
                                                           join console_produit cp on cp.id_produit = p.id_produit join console c on c.id_console=cp.id_console
                                                           join style s on s.id_style = p.id_style 
                                                           group by p.id_produit
                                                           order by id_produit  ";
    $connx = connexionDB();
    $resultats = mysqli_query($connx, $sql);
    $produits = [];

    // foreach ($resultats as $produit) {
    //    $produits[]=$produit;
    // }

    if (mysqli_num_rows($resultats) > 0) {
        while ($produit = mysqli_fetch_assoc($resultats)) {
            $produits[] = $produit;
        }
    }
    return $produits;
}

  
function getProduitById($id_produit)
{
    $sql = "SELECT p.*,i.chemin, GROUP_CONCAT(c.nom SEPARATOR ', ') AS console,s.nom as style from Produit p LEFT JOIN Image_produit i on p.id_produit = i.id_produit 
                                                           join console_produit cp on cp.id_produit = p.id_produit join console c on c.id_console=cp.id_console
                                                           join style s on s.id_style = p.id_style 
                                                           
                                                            where p.id_produit = ?";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_produit);
    $resultats = mysqli_stmt_execute($stmt);
    if ($resultats) {
        $resultats = mysqli_stmt_get_result($stmt);
        // var_dump($resultats);
        if (mysqli_num_rows($resultats) > 0) {
            // $produit = mysqli_fetch_assoc($resultats);
            // return $produit;
            return mysqli_fetch_assoc($resultats);
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function updateProduit($produit, $data)
{
    $id_produit = $produit['id_produit'];
    $nom = $produit['nom'];
    $prix_unitaire = $produit['prix_unitaire'];
    $quantite = $produit['quantite'];
    $courte_description = $produit['courte_description'];
    $description = $produit['description'];
    $id_style = $produit['style'];
    $consoles = $produit['console'];

    $sql = "update Produit set nom = ?, prix_unitaire = ?, quantite = ?, courte_description = ?,
    descriptions = ?,id_style= ?  where id_produit = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'ssissii', $nom, $prix_unitaire, $quantite, $courte_description, $description, $id_style, $id_produit);
    // insert, update, delete le resultat c'est du type bool 
    $resultat =  mysqli_stmt_execute($statment);
    if ($resultat) {
        deleteconsole($id_produit);
        foreach ($consoles as $console) {
            insertconsoleUtilisateur($console, $id_produit);
        }
        uplaodImag($data, $id_produit);
        return $resultat;
    }
}
function uplaodImag($data, $id_produit)
{

    if (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $data['image']['name'];
        $image_destination = 'images/' . basename($image_name);
        $from = $data['image']['tmp_name'];
        $image_type = strtolower(pathinfo($image_destination, PATHINFO_EXTENSION));
        if (in_array($image_type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            if (move_uploaded_file($from, $image_destination)) {
                $image = ['chemin' => $image_destination, 'id_produit' => $id_produit];
                if (!searchImage($id_produit)) {
                    ajoutImage_produit($image);
                } else updateImage($image);
                return true;
            } else {
                echo "Impossible de telecharger le fichier";
                return false;
            }
        } else {
            echo "Impossible de telecharger le fichier avec l'extension $image_type";
            return false;
        }
    }
    return false;
}
function searchImage($id_produit)
{
    $sql = "select i.chemin from image_produit i where id_produit=?";
    $connex = connexionDB();
    $stmt = mysqli_prepare($connex, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_produit);
    $resultats = mysqli_stmt_execute($stmt);
    if ($resultats) {
        $resultats = mysqli_stmt_get_result($stmt);
        // var_dump($resultats);
        if (mysqli_num_rows($resultats) > 0) {
            // $produit = mysqli_fetch_assoc($resultats);
            // return $produit;
            return mysqli_fetch_assoc($resultats);
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function deleteImage($id_produit)
{
    $sql = "delete from image_produit where id_produit = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_produit);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}




function updateImage($image)
{
    $id_produit = $image['id_produit'];
    $chemin = $image['chemin'];
    $sql = "update image_produit set chemin = ? where id_produit=?";
    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'si', $chemin, $id_produit);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}

function deleteProduit($id_produit)
{

    $sql = "delete from Produit where id_produit = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_produit);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}

/**
 * fonction pour deplacer une image
 * @param array $data
 * @return bool
 */
function uplaodImage($data, $id_produit)
{

    if (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $data['image']['name'];
        $image_destination = 'images/' . basename($image_name);
        $from = $data['image']['tmp_name'];
        $image_type = strtolower(pathinfo($image_destination, PATHINFO_EXTENSION));
        if (in_array($image_type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            if (move_uploaded_file($from, $image_destination)) {
                $image = ['chemin' => $image_destination, 'id_produit' => $id_produit];
                ajoutImage_produit($image);
                return true;
            } else {
                echo "Impossible de telecharger le fichier";
                return false;
            }
        } else {
            echo "Impossible de telecharger le fichier avec l'extension $image_type";
            return false;
        }
    }
    return false;
}


/**
 * fonction pour ajouter une image dans la bd
 *
 * @param array $image
 * @return bool
 */
function ajoutImage_produit($image)
{
    $chemin = $image['chemin'];
    $id_produit = $image['id_produit'];

    // select * from produit where id = select * from produit 

    $sql = "insert into Image_produit(chemin,id_produit) 
    values(?,?)";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'si', $chemin, $id_produit);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}


function connection($data)
{
    $couriel = $data["username"];
    $pass = $data["password"];

    $sql = "select u.*,r.description from utilisateur u,role r,role_utilisateur ru WHERE u.id_utilisateur= ru.id_utilisateur AND r.id_role=ru.id_role AND u.courriel=?";
    $connex = connexionDB();
    $stmt = mysqli_prepare($connex, $sql);
    mysqli_stmt_bind_param($stmt, "s", $couriel);
    $resultat = mysqli_stmt_execute($stmt);
    if ($resultat) {
        $resultat = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultat) > 0) {
            $resultat = mysqli_fetch_assoc($resultat);
            if (password_verify($pass, $resultat['mot_de_passe'])) {
                return $resultat;
            }
        }
    }

    return false;
}
function validateEmail($email)
{
    // Expression régulière pour valider une adresse email
    $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    // Vérifier si l'adresse email correspond à la regex
    if (preg_match($regex, $email)) {
        return true; // L'adresse email est valide
    } else {
        return false; // L'adresse email n'est pas valide
    }
}
function calculAge($date)
{
    //infos systeme pour la date du jour
    $date_sys = new DateTime();
    $mois_sys = (int)$date_sys->format('m');
    $annees_sys = (int)$date_sys->format('Y');

    // renseignement du concerne
    $tab_date = explode("-", $date);
    $annee = (int)$tab_date[0];
    $mois = (int)$tab_date[1];
    $age =  $annees_sys - $annee;
    if ($mois_sys < $mois) {
        $age -= 1;
    }
    return $age;
}

function verifierProduit($produits)
{
    foreach ($produits as $produit) {
        if ($produit['id_produit'] === $_GET['id']) {
            return true;
        }
    }
    return false;
}


function getconsole()
{
    $sql = "select* from console ";
    $connx = connexionDB();
    $resultats = mysqli_query($connx, $sql);
    $consoles = [];

    // foreach ($resultats as $produit) {
    //    $produits[]=$produit;
    // }

    if (mysqli_num_rows($resultats) > 0) {
        while ($console = mysqli_fetch_assoc($resultats)) {
            $consoles[] = $console;
        }
    }
    return $consoles;
}
function getstyle()
{
    $sql = "select* from style ";
    $connx = connexionDB();
    $resultats = mysqli_query($connx, $sql);
    $consoles = [];

    // foreach ($resultats as $produit) {
    //    $produits[]=$produit;
    // }

    if (mysqli_num_rows($resultats) > 0) {
        while ($console = mysqli_fetch_assoc($resultats)) {
            $consoles[] = $console;
        }
    }
    return $consoles;
}
function getstylebydesc($description)
{
    $sql = "select id_style from style where description=?";
    $conn = connexionDB();
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $description);
    $resultat = mysqli_stmt_execute($stmt);
    if ($resultat) {
        $resultat = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultat) > 0) {
            return mysqli_fetch_assoc($resultat);
        }
    }
    return false;
}
function insertconsoleUtilisateur($id_console, $id_produit)
{
    $sql = "insert into console_produit(id_console,id_produit)
          Values(?,?)";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $id_console, $id_produit);
    return mysqli_stmt_execute($stmt);
}

function deleteconsole($id_produit)
{
    $sql = "delete from console_produit where id_produit=?";
    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_produit);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}

function getcommandes()
{
    $sql = "SELECT* FROM commande ";
    $connx = connexionDB();
    $resultats = mysqli_query($connx, $sql);
    $commandes = [];
    if (mysqli_num_rows($resultats) > 0) {
        while ($commande = mysqli_fetch_assoc($resultats)) {
            $commandes[] = $commande;
        }
    }
    return $commandes;
}
function getcommandeById($id_commande)

{
    $sql = "SELECT C.id_commande,C.prix,C.etat,C.date_commane,u.id_utilisateur,U.nom,U.prenom,Pc.quantite,p.id_produit,p.nom,p.descriptions,p.prix_unitaire,A.rue,A.ville FROM commande C join utilisateur U on c.id_utilisateur=u.id_utilisateur join produit_commande Pc on Pc.id_commande= c.id_commande join produit p on p.id_produit=pc.id_produit join Adresse_utilisateur Au on Au.id_utilisateur=u.id_utilisateur join Adresse A on A.id_adresse=Au.id_Adresse where C.id_commande=?";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_commande);
    $resultats = mysqli_stmt_execute($stmt);
    if ($resultats) {
        $resultats = mysqli_stmt_get_result($stmt);
        $commandes = [];
        // var_dump($resultats);
        if (mysqli_num_rows($resultats) > 0) {
            while ($commande = mysqli_fetch_assoc($resultats)) {
                $commandes[] = $commande;
            }
            return $commandes;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function modifierStatutCommande($etat){
    $sql = "Update Commande(etat)
          Values(?)";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 's', $etat);
    return mysqli_stmt_execute($stmt);
}
function deleteProduit_commande($id_commande,$id_produit){
    $sql = "delete from Produit_commande where id_produit = ? and id_commande=?";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'ii', $id_produit,$id_commande);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}
function deletecommande($id_commande){
    $sql = "delete from commande where id_produit = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_commande);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}

     

function getcommandeByIduser($id_commande)

{
    $sql = "SELECT C.id_commande,C.prix,C.etat,C.date_commane,u.id_utilisateur,U.nom,U.prenom,Pc.quantite,p.id_produit,p.nom,p.descriptions,p.prix_unitaire,A.rue,A.ville FROM commande C join utilisateur U on c.id_utilisateur=u.id_utilisateur join produit_commande Pc on Pc.id_commande= c.id_commande join produit p on p.id_produit=pc.id_produit join Adresse_utilisateur Au on Au.id_utilisateur=u.id_utilisateur join Adresse A on A.id_adresse=Au.id_Adresse where U.id_utilisateur=?";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_commande);
    $resultats = mysqli_stmt_execute($stmt);
    if ($resultats) {
        $resultats = mysqli_stmt_get_result($stmt);
        $commandes = [];
        // var_dump($resultats);
        if (mysqli_num_rows($resultats) > 0) {
            while ($commande = mysqli_fetch_assoc($resultats)) {
                $commandes[] = $commande;
            }
            return $commandes;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
     ?>