<?php
include 'config.php';

function connexionDB()
{
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die('erreur de connexion avec la base de donnes' . mysqli_connect_error());
    } else {
        return $conn;
    }
}

// fonction pour l'inscription
function Inscription($utilisateur, $data)
{
    $nom = $utilisateur['nom'];
    $prenom = $utilisateur['prenom'];
    $date_de_naissance = $utilisateur['date_de_naissance'];
    $courriel = $utilisateur['courriel'];
    $mot_de_passe = $utilisateur['mot_de_passe'];
    $telephone = $utilisateur['telephone'];
    $confmdp = $utilisateur['confmdp'];
    $security_answer = $utilisateur['security_answer'];
    $genre = $utilisateur['sexe'];
    $id_question = $utilisateur['question'];


    if (verifier_mdp($mot_de_passe)) {

        if (nom_prenom($nom) && nom_prenom($prenom)) {

            if (date_naissance($date_de_naissance)) {

                if (filter_var($courriel, FILTER_VALIDATE_EMAIL)) {

                    if ($confmdp === $mot_de_passe) {

                        $utilisateur = getUtilisateurByEmail($courriel);
                        if ($utilisateur) {
                            return false;
                        } else {

                            $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                            $sql = "INSERT INTO utilisateur(nom,prenom,date_naissance,courriel,mot_de_passe,telephone,security_answer,question,sexe)
                                         values(?,?,?,?,?,?,?,?,?)";

                            $conn = connexionDB();
                            $statment = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($statment, 'sssssssis', $nom, $prenom, $date_de_naissance, $courriel, $mot_de_passe, $telephone, $security_answer, $id_question, $genre);
                            // insert/update/delete le resultat c'est du type bool
                            $resultat = mysqli_stmt_execute($statment);
                            if ($resultat) {
                                $role = getRoleByDesc('client');
                                $id_utilisateur = mysqli_insert_id($conn);
                                uplaodImag_user($data, $id_utilisateur);
                                insertRoleUtilisateur($role['id_role'], $id_utilisateur);
                                return true;
                            }
                        }
                        return false;
                    }
                }
            }
        }
    } else {
        echo "";
    }
}


function getUtilisateurByEmail($email)
{
    $sql = 'SELECT u.* , r.description
           FROM utilisateur u
           JOIN role_utilisateur ru ON u.id_utilisateur = ru.id_utilisateur
           JOIN role r ON ru.id_role = r.id_role
           WHERE courriel = ? ';
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    $resultat = mysqli_stmt_execute($stmt);

    if ($resultat) {
        $resultatData = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultatData) >= 0) {
            return mysqli_fetch_assoc($resultatData);
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * fonction qui permet l'insertion dans la table Role_Utilisateur
 * @param int $id_role
 * @param int $id_utilisateur
 * 
 * @return bool
 */

function insertRoleUtilisateur($id_role, $id_utilisateur)
{
    $sql = "insert into role_utilisateur(id_role,id_utilisateur) value(?,?)";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $id_role, $id_utilisateur);
    return mysqli_stmt_execute($stmt);
}


/**
 * fonction qui me retourne role en fonction de la description
 * @param string $description
 * @return array | bool
 */
function getRoleByDesc($description)
{
    $sql = "select * from role where description = ?";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 's', $description);
    $resultat = mysqli_stmt_execute($stmt);
    if ($resultat) {
        $resultat = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultat) > 0) {
            return mysqli_fetch_assoc($resultat);
        }
        return false;
    }
    return false;
}


//fonction pour la verification de la date de naissance dans l'inscription
function date_naissance($date)
{
    // creation d'un objet date a partir de la date de naisance
    $objdate = new DateTime($date);
    // creation d'un objet date pour la date actuel
    $date_actuel = new DateTime();

    // le calcule de la difference
    $age = $date_actuel->diff($objdate)->y;
    // verification de l'age
    if ($age >= 16 && $age < 100) {
        return $age;
    }
}

// fonction pour verifier le nom et le prenom dans l'inscription
function nom_prenom($name)
{
    return strlen($name) > 4;
}
//fonction verifier que le mot de passe contient une lettre majuscule et un nombre
function verifier_mdp($mdp)
{
    return preg_match('/[A-Z]/', $mdp) && preg_match('/[0-9]/', $mdp);
}


function uplaodImag_user($data, $id_utilisateur)
{

    if (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $data['image']['name'];
        $image_destination = '../../upload/' . basename($image_name);
        $from = $data['image']['tmp_name'];
        $image_type = strtolower(pathinfo($image_destination, PATHINFO_EXTENSION));
        if (in_array($image_type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            if (move_uploaded_file($from, $image_destination)) {
                $image = ['chemin' => $image_destination, 'id_utilisateur' => $id_utilisateur];
                ajoutImage_utilisateur($image);
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
function ajoutImage_utilisateur($image)
{
    $chemin = $image['chemin'];
    $id_utilisateur = $image['id_utilisateur'];

    // select * from produit where id = select * from produit 

    $sql = "insert into image_utilisateur(chemin,id_utilisateur) 
    values(?,?)";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'si', $chemin, $id_utilisateur);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}

function deleteImage($id_utilisateur)
{
    $sql = "delete from image_utilisateur where id_utilisateur = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_utilisateur);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}


function getquestion()
{
    $sql = "select * from question";
    $conn = connexionDB();
    $resultat = mysqli_query($conn, $sql);
    $questions = [];
    if (mysqli_num_rows($resultat) > 0) {

        while ($question = mysqli_fetch_assoc($resultat)) {
            $questions[] = $question;
        }
    }
    return $questions;
}

//fonction getquestionbyid
function getquestionbyid($id_question)
{
    $sql = "SELECT * FROM question  WHERE id_question = ?";
    $conn = connexionDB();
    $statment = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($statment, 'i', $id_question);
    $result = mysqli_stmt_execute($statment);
    if ($result) {

        $result =  mysqli_stmt_get_result($statment);

        if (mysqli_num_rows($result) > 0) {
            $question = mysqli_fetch_assoc($result);
            return $question;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//fonction getreponse_idqst by email
function getreponsebyEmail($email)
{
    $sql = 'SELECT security_answer
           FROM utilisateur 
           WHERE courriel = ? ';
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    $resultat = mysqli_stmt_execute($stmt);
    if ($resultat) {
        $resultatData = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultatData) >= 0) {
            return mysqli_fetch_assoc($resultatData);
        } else {
            return false;
        }
    } else {
        return false;
    }
}
// user
function getutilisateurs()
{
    $sql = "select * from utilisateur";
    $conn = connexionDB();
    $resultat = mysqli_query($conn, $sql);
    $utilisateurs = [];
    if (mysqli_num_rows($resultat) > 0) {
        while ($utilisateur = mysqli_fetch_assoc($resultat)) {
            $utilisateurs[] = $utilisateur;
        }
    }
    return $utilisateurs;
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

function getUserById($id_utilisateurs)
{
    $sql = "SELECT u.* , i.chemin FROM utilisateur u 
    left join image_utilisateur i on u.id_utilisateur=i.id_utilisateur
     WHERE u.id_utilisateur=? ";
    $conn = connexionDB();
    $statment = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($statment, 'i', $id_utilisateurs);
    $result = mysqli_stmt_execute($statment);
    if ($result) {

        $result =  mysqli_stmt_get_result($statment);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            return $user;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


//verification de produit
function verifierProduit($produits)
{
    foreach ($produits as $produit) {
        if ($produit['id_produit'] === $_GET['id']) {
            return true;
        }
    }
    return false;
}


function updateUser($utilisateur, $data)
{
    $id_utilisateurs = $utilisateur['id_utilisateur'];
    $nom = $utilisateur['nom'];
    $prenom = $utilisateur['prenom'];
    $date_naissance = $utilisateur['date_naissance'];
    $courriel = $utilisateur['courriel'];
    // $mot_de_passe=$utilisateur['mot_de_passe'];
    $telephone = $utilisateur['telephone'];
    $genre = $utilisateur['sexe'];

    $sql = "UPDATE utilisateur set nom=? ,prenom=? ,date_naissance=? ,courriel=? , telephone = ? , sexe = ? where id_utilisateur=?";

    $conn = connexionDB();
    $statment = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($statment, 'ssssssi', $nom, $prenom, $date_naissance, $courriel, $telephone, $genre, $id_utilisateurs);
    // insert/update/delete le resultat c'est du type bool
    $result = mysqli_stmt_execute($statment);

    // mysqli_stmt_close($statment);
    // mysqli_close($conn);
    // uplaodImage($data,$id_utilisateurs);
    uplaodImag_user($data, $id_utilisateurs);
    return $result;
}




// produits:

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
    $sql = "SELECT p.*,i.chemin, GROUP_CONCAT(c.nom SEPARATOR ', ') AS console,s.nom as style from Produit p LEFT JOIN Image_produit i on p.id_produit = i.id_produit 
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
        $image_destination = '../upload/images' . basename($image_name);
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
function ajoutImage_produit($image)
{
    $chemin = $image['chemin'];
    $id_produit = $image['id_produit'];

    // select * from produit where id = select * from produit 

    $sql = "insert into image_produit(chemin,id_produit) 
    values(?,?)";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'si', $chemin, $id_produit);
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

///

function diminuerProduit($id_produit)
{
    global $id_utilisateur;
    if (isset($_SESSION['Paniers'][$id_utilisateur][$id_produit])) {
        $_SESSION['Paniers'][$id_utilisateur][$id_produit]--;
        if ($_SESSION['Paniers'][$id_utilisateur][$id_produit] <= 0) {
            unset($_SESSION['Paniers'][$id_utilisateur][$id_produit]);
        }
    }
}


function AJOUTER_PANIER($id_produit, $quantite)
{
    if (!isset($_SESSION['Panier'])) {
        $_SESSION['Panier'] = array();
    }

    if (isset($_SESSION['Panier'][$id_produit])) {
        $_SESSION['Panier'][$id_produit] += $quantite;
    } else {
        $_SESSION['Panier'][$id_produit] = $quantite;
    }
}

function ajouterProduit($id_produit)
{
    global $id_utilisateur;
    if (isset($_SESSION['Paniers'][$id_utilisateur][$id_produit])) {
        $_SESSION['Paniers'][$id_utilisateur][$id_produit]++;
    } else {
        $_SESSION['Paniers'][$id_utilisateur][$id_produit] = 1;
    }
}


function CALCULER_PRIX_TOTAL_PANIER()
{
    $conn = connexionDB();
    $prix_total = 0;

    foreach ($_SESSION['Paniers'] as $id_produit => $quantite) {
        $sql = "SELECT prix_unitaire FROM produit WHERE id_produit = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die('Erreur de préparation de la requête : ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, 'i', $id_produit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $prix_total += $row['prix_unitaire'] * $quantite;
    }

    return $prix_total;
}


function AJOUTER_COMMANDE()
{
    if (isset($_SESSION['utilisateur'])) {
        $conn = connexionDB();
        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
        $prix = CALCULER_PRIX_TOTAL_PANIER();
        $quantite = array_sum($_SESSION['Paniers']);


        $sql = "INSERT INTO commande (id_utilisateur, quantite, prix) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die('Erreur de préparation de la requête : ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, 'idd', $id_utilisateur, $quantite, $prix);
        mysqli_stmt_execute($stmt);

        $id_commande = mysqli_insert_id($conn);

        foreach ($_SESSION['Paniers'] as $id_produit => $quantite) {
            $sql_insert = "INSERT INTO produit_commande (id_commande, id_produit,  quantite) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            if (!$stmt_insert) {
                die('Erreur de préparation de la requête : ' . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt_insert, 'iii', $id_produit, $id_commande, $quantite);
            mysqli_stmt_execute($stmt_insert);
        }

        unset($_SESSION['Paniers']);
    } else {
        return "L'utilisateur n'est pas connecté";
    }
}

function sauvegarder_panier($id_utilisateur, $panier)
{
    $conn = connexionDB();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    foreach ($panier as $id_produit => $quantite) {
        $sql = "REPLACE INTO panier_sauvegarde (id_utilisateur, id_produit, quantite) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $id_utilisateur, $id_produit, $quantite);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}


function charger_panier($id_utilisateur)
{
    $conn = connexionDB();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT id_produit, quantite FROM panier_sauvegarde WHERE id_utilisateur = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_utilisateur);
    mysqli_stmt_execute($stmt);
    $resultat = mysqli_stmt_get_result($stmt);
    $_SESSION['Paniers'] = array();

    while ($row = mysqli_fetch_assoc($resultat)) {
        $id_produit = $row['id_produit'];
        $quantite = $row['quantite'];
        $_SESSION['Paniers'][$id_produit] = $quantite;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// cmd

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
    $sql = "SELECT C.id_commande,C.prix,C.etat,C.date_commane,U.nom,u.prenom,Pc.quantite,p.id_produit,p.nom,p.descriptions,p.prix_unitaire,A.rue,A.ville FROM commande c join utilisateur u on c.id_utilisateur=u.id_utilisateur join produit_commande Pc on Pc.id_commande= c.id_commande join produit p on p.id_produit=pc.id_produit join Adresse_utilisateur Au on Au.id_utilisateur=u.id_utilisateur join Adresse A on A.id_adresse=Au.id_Adresse where C.id_commande=?";

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

function modifierStatutCommande($etat)
{
    $sql = "Update Commande(etat)
          Values(?)";
    $connx = connexionDB();
    $stmt = mysqli_prepare($connx, $sql);
    mysqli_stmt_bind_param($stmt, 's', $etat);
    return mysqli_stmt_execute($stmt);
}
function deleteProduit_commande($id_commande, $id_produit)
{
    $sql = "delete from Produit_commande where id_produit = ? and id_commande=?";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'ii', $id_produit, $id_commande);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}
function deletecommande($id_commande)
{
    $sql = "delete from commande where id_produit = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_commande);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}



function getProduitsbypsv()
{
    $sql = "SELECT p.*,i.chemin FROM produit p
LEFT JOIN image_produit i on p.id_produit = i.id_produit 
join console_produit cp on cp.id_produit = p.id_produit 
join console c on c.id_console=cp.id_console WHERE c.nom = 'PS5' ";
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

function getProduitsbypsiv()
{
    $sql = "SELECT p.*,i.chemin FROM produit p
LEFT JOIN image_produit i on p.id_produit = i.id_produit 
join console_produit cp on cp.id_produit = p.id_produit 
join console c on c.id_console=cp.id_console WHERE c.nom = 'PS4' ";
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

function getProduitsbypsiii()
{
    $sql = "SELECT p.*,i.chemin FROM produit p
LEFT JOIN image_produit i on p.id_produit = i.id_produit 
join console_produit cp on cp.id_produit = p.id_produit 
join console c on c.id_console=cp.id_console WHERE c.nom = 'PS3' ";
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

function getProduitsbyxbox()
{
    $sql = "SELECT p.*,i.chemin FROM produit p
LEFT JOIN image_produit i on p.id_produit = i.id_produit 
join console_produit cp on cp.id_produit = p.id_produit 
join console c on c.id_console=cp.id_console WHERE c.nom = 'XBOX' ";
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


function getProduitsbyPC()
{
    $sql = "SELECT p.*,i.chemin FROM produit p
LEFT JOIN image_produit i on p.id_produit = i.id_produit 
join console_produit cp on cp.id_produit = p.id_produit 
join console c on c.id_console=cp.id_console WHERE c.nom = 'gaming pc' ";
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
        uplaodImage($data, $id_produit);
        return $resultat;
    }
}


function updatestatutcmd($produit)
{
    $id_commande = $produit['id_commande'];
    $nom = $produit['etat'];


    $sql = "update commande set etat = ?
    where id_commande = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'si', $nom, $id_commande);
    // insert, update, delete le resultat c'est du type bool 
    $resultat =  mysqli_stmt_execute($statment);
    return $resultat;
}



function getOrderDetailsFromPayPal($orderID)
{
    $clientID = 'your-client-id';
    $secret = 'your-secret';
    $url = "https://api.paypal.com/v2/checkout/orders/{$orderID}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic " . base64_encode("$clientID:$secret")
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) {
        return false;
    }

    return json_decode($response, true);
}

function calculateExpectedAmount()
{
    $total = 0;
    foreach ($_SESSION['Paniers'] as $item) {
        $total += $item['prix'] * $item['quantite'];
    }
    return number_format($total, 2, '.', '');
}

function saveOrderToDatabase($detailscommande)
{
    $id_utilisateur = $_SESSION['utilisateur']['id'];
    $amount = $detailscommande['purchase_units'][0]['amount']['value'];
    $quantite = count($_SESSION['Paniers']);

    $sql = "INSERT INTO commande (quantite, prix, date_commande, id_utilisateur) VALUES (?, ?, NOW(), ?)";
    $conn = connexionDB();
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $quantite, $amount, $id_utilisateur);
    $resultat = mysqli_stmt_execute($stmt);

    return $resultat;
}
function updateEtat($produit)
{
    $id_commande = $produit['id_commande'];
    $nom = $produit['etat'];


    $sql = "update commande set etat = ?
    where id_commande = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'si', $nom, $id_commande);
    // insert, update, delete le resultat c'est du type bool 
    $resultat =  mysqli_stmt_execute($statment);
    return $resultat;
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
function insertAdresse($adresse)
{


    $rue = $adresse['rue'];
    $province = $adresse['province'];
    $cdp = $adresse['code_postal'];
    $numero = $adresse['numero'];
    $ville = $adresse['ville'];


    // select * from produit where id = select * from produit 

    $sql = "insert into adresse(rue,code_postale,province,ville,numero) 
    values(?,?,?,?,?)";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'sssss', $rue, $cdp, $province, $ville, $numero);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}
function getIdAdrese($adresse)
{
    $rue = $adresse['rue'];
    $province = $adresse['province'];
    $cdp = $adresse['code_postal'];
    $numero = $adresse['numero'];
    $ville = $adresse['ville'];

    $sql = "select id_adresse from adresse where rue='" . $rue . "' and province='" . $province . "' and code_postale='" . $cdp . "'";

    $conn = connexionDB();
    $resultat = mysqli_query($conn, $sql);
    $questions = [];
    if (mysqli_num_rows($resultat) > 0) {

        $questions = mysqli_fetch_assoc($resultat);
    }
    return $questions;
}


function insertUtilisateur_addresse($tab)
{
    $id_utilisateur = $tab['id_utilisateur'];
    $id_adresse = $tab['id_adresse'];





    // select * from produit where id = select * from produit 

    $sql = "insert into adresse_utilisateur(id_adresse,id_utilisateur) 
    values(?,?)";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'ii', $id_adresse, $id_utilisateur);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}
