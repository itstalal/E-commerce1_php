<?php


function getUtilidsateurs(){
        $sql = "SELECT u.*,i.chemin from Utilisateur u left join image_utilisateur i on u.id_utilisateur=i.id_utilisateur order by id_utilisateur";
        $connx = connexionDB();
        $resultats = mysqli_query($connx, $sql);
        $Users = [];
    
        // foreach ($resultats as $produit) {
        //    $produits[]=$produit;
        // }
    
        if (mysqli_num_rows($resultats) > 0) {
            while ($user = mysqli_fetch_assoc($resultats)) {
                $Users[] = $user;
            }
        }
        return $Users;
}
function getUtilidsateursByid($id_user)
{
    $sql = "select u.* from utilisateur u where u.id_utilisateur=?";
    $connex = connexionDB();
    $stmt = mysqli_prepare($connex, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
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
/**
 * fonction qui permet de faire la modification d'un
 * produit
 *
 * @param array $produit
 * @return bool
 *
 */


function DeleteUser($id_Utilisateur){
    $sql = "delete from utilisateur where id_utilisateur = ? ";

    $connex = connexionDB();
    // initialisation de la req avec la base de donnée
    $statment = mysqli_prepare($connex, $sql);
    // string s, int i, float | double d
    mysqli_stmt_bind_param($statment, 'i', $id_Utilisateur);
    // insert, update, delete le resultat c'est du type bool 
    return mysqli_stmt_execute($statment);
}





// function inscription($user,$data){
//     global $erreurs;
//     $nom  = $user['nom'];
//     $prenom  = $user['prenom'];
//     $date_naissance  = $user['date_naissance'];
//     $courriel  = $user['courriel'];
//     $mot_de_passe  = $user['mot_de_passe'];
//     $c_mot_de_passe  = $user['c_mot_de_passe'];
//     $telephone  = $user['telephone'];

//     if(isset($nom,$prenom,$date_naissance,$courriel,$mot_de_passe,$telephone,$c_mot_de_passe)){
//         if(empty($nom)){
//             $erreurs = 'Le nom est vide' ;
//             return false;
//         }
//         if($mot_de_passe === $c_mot_de_passe){
//             $utilisateur = getUtilisateurByEmail($courriel);
//             if($utilisateur){
//                return false;
//             }else{
//                 $sql = 'insert into Utilisateur(nom,prenom,date_naissance,courriel,
//                 mot_de_passe,telephone) value(?,?,?,?,?,?)';
//                 $connx = connexionDB();
//                 $stmtx = mysqli_prepare($connx,$sql);
//                 $mot_de_passe = password_hash($mot_de_passe,PASSWORD_DEFAULT);
//                 mysqli_stmt_bind_param($stmtx,'ssssss',$nom,$prenom,$date_naissance,
//                 $courriel,$mot_de_passe,$telephone);
//                 $resultat = mysqli_stmt_execute($stmtx);
//                 if($resultat){
//                     $id_utilisateur = mysqli_insert_id($connx);
                 
               
//                     uplaodImag_user($data,$id_utilisateur);
//                     $role = getRoleByDesc('client');
                    
//                     insertRoleUtilisateur($role['id_role'],$id_utilisateur);
//                     return true;

//                 }
//                 return false;
//             }
//         }else{
//             return false;
//         } 
//     }else{
//         return false;
//     }
// }
// function getRoleByDesc($description){
//     $sql = "select * from Role where description = ?";
//     $connx = connexionDB();
//     $stmt = mysqli_prepare($connx,$sql);
//     mysqli_stmt_bind_param($stmt,'s',$description);
//     $resultat= mysqli_stmt_execute($stmt);
//     if($resultat){
//         $resultat = mysqli_stmt_get_result($stmt);
//         if(mysqli_num_rows($resultat)>0){
//             return mysqli_fetch_assoc($resultat);
//         }
//         return false;
        
//     }
//     return false;
// }

// function getUtilisateurByEmail($email){
//     $sql = 'select * from Utilisateur where courriel = ?';
//     $connx = connexionDB();
//     $stmt = mysqli_prepare($connx,$sql);
//     mysqli_stmt_bind_param($stmt,'s',$email);
//     $resultat = mysqli_stmt_execute($stmt);
//     if($resultat){
//         $resultatData = mysqli_stmt_get_result($stmt);
//         if(mysqli_num_rows($resultatData) >= 0){
//             return mysqli_fetch_assoc($resultatData);
//         }else{
//             return false;
//         }
//     }else{
//         return false;
//     }
// }

// function insertRoleUtilisateur($id_role,$id_utilisateur){
//     $sql = "insert into Role_utilisateur(id_role,id_utilisateur) value(?,?)";
//     $connx = connexionDB();
//     $stmt = mysqli_prepare($connx,$sql);
//     mysqli_stmt_bind_param($stmt,'ii',$id_role,$id_utilisateur);
//     return mysqli_stmt_execute($stmt);
//  }


 function updateStaututUser($id_user,$id_role){
    $Sql = "update Role_utilisateur set id_role=?  where id_utilisateur = ?";
    $conn = connexionDB();
    $Statement = mysqli_prepare($conn,$Sql);
    mysqli_stmt_bind_param($Statement,'ii',$id_role,$id_user);
    return mysqli_stmt_execute($Statement);

 }


 function getdescriptionRole($id_user){
    $Sql = "select r.description from Role_utilisateur ru,utilisateur u ,Role r where ru.id_role=r.id_role and u.id_utilisateur=ru.id_utilisateur and u.id_utilisateur=? ";
    $conn = connexionDB();
    $Statement = mysqli_prepare($conn,$Sql);
    mysqli_stmt_bind_param($Statement,'i',$id_user);
    $resultat= mysqli_stmt_execute($Statement);
    if($resultat){
        $resultatData = mysqli_stmt_get_result($Statement);
        if(mysqli_num_rows($resultatData) >= 0){
            return mysqli_fetch_assoc($resultatData);
        }else{
            return false;
        }
    }else{
        return false;
    }
}


// function uplaodImag_user($data, $id_utilisateur)
// {

//     if (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
//         $image_name = $data['image']['name'];
//         $image_destination = '../upload/'.basename($image_name);
//         $from = $data['image']['tmp_name'];
//         $image_type = strtolower(pathinfo($image_destination, PATHINFO_EXTENSION));
//         if (in_array($image_type, ['jpg', 'jpeg', 'png', 'gif','webp'])) {
//             if (move_uploaded_file($from, $image_destination)) {
//                 $image = ['chemin' => $image_destination, 'id_utilisateur' => $id_utilisateur];
//                 ajoutImage_utilisateur($image);
//                 return true;
//             } else {
//                 echo "Impossible de telecharger le fichier";
//                 return false;
//             }

//         } else {
//             echo "Impossible de telecharger le fichier avec l'extension $image_type";
//             return false;
//         }
//     }
//     return false;

// }
// function ajoutImage_utilisateur($image)
// {
//     $chemin = $image['chemin'];
//     $id_utilisateur = $image['id_utilisateur'];

//     // select * from produit where id = select * from produit 

//     $sql = "insert into Image_utilisateur(chemin,id_utilisateur) 
//     values(?,?)";

//     $connex = connexionDB();
//     // initialisation de la req avec la base de donnée
//     $statment = mysqli_prepare($connex, $sql);
//     // string s, int i, float | double d
//     mysqli_stmt_bind_param($statment, 'si', $chemin,$id_utilisateur);
//     // insert, update, delete le resultat c'est du type bool 
//     return mysqli_stmt_execute($statment);

// }

     
?>