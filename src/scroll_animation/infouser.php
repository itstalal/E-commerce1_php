
<?php 
// var_dump($_POST);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../db/fonction.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id']) ){
    header('location: index.php');
    exit();

}else{
    
    $utilisateur = getUserById($_GET['id']);
    // var_dump($utilisateur);
   

    if(isset($_POST['btn-update'])){
       $_POST['id_utilisateur']=$_GET['id'];
       

       if(isset($_POST['chckmodifier'])){
        deleteImage($utilisateur['id_utilisateur']);
       }
           $resultat= updateUser($_POST,$_FILES);
       
       $mot_de_pass=$_POST['nouveau'];
       $c_mdp=$_POST['c_nouveau'];
       $old_mdp= $_POST['mot_de_passe'];
       if(password_verify($old_mdp,$utilisateur['mot_de_passe'])){
       if($mot_de_pass==$c_mdp){
       if(verifier_mdp($mot_de_pass)){
        $mot_de_pass=password_hash($mot_de_pass,PASSWORD_DEFAULT);

      $sql= "UPDATE utilisateur set mot_de_passe = ? where id_utilisateur=?";
      $conn= connexionDB();
      $statment = mysqli_prepare($conn,$sql);
      mysqli_stmt_bind_param($statment,'si',$mot_de_pass,$_GET['id']);
      // insert/update/delete le resultat c'est du type bool
      $result = mysqli_stmt_execute($statment);
     

      if(!$result){
        
         ?>
         <script>
            window.location.href="index.php";
         </script>
         
         <?php
      }
      else{
        header('Location: ../../db/deconnexion.php');
      }
     
  }
}
       }
       if($resultat){
        ?>
        <script>
            window.location.href="index.php";
         </script>
         

        <?php
        exit();
       }
       if($result){
        header('Location: ../../db/deconnexion.php');
       }
    }
}
  
   


//UPDATE MDP
 ?>
 <head>
    <style>
        .ui-w-80 {
    width : 80px !important;
    height: auto;
}

.btn-default {
    border-color: rgba(24, 28, 33, 0.1);
    background  : rgba(0, 0, 0, 0);
    color       : #4E5155;
}

label.btn {
    margin-bottom: 0;
}

.btn-outline-primary {
    border-color: #26B4FF;
    background  : transparent;
    color       : #26B4FF;
}

.btn {
    cursor: pointer;
}

.text-light {
    color: #babbbc !important;
}

.btn-facebook {
    border-color: rgba(0, 0, 0, 0);
    background  : #3B5998;
    color       : #fff;
}

.btn-instagram {
    border-color: rgba(0, 0, 0, 0);
    background  : #000;
    color       : #fff;
}

.card {
    background-clip: padding-box;
    box-shadow     : 0 1px 4px rgba(24, 28, 33, 0.012);
}

.row-bordered {
    overflow: hidden;
}

.account-settings-fileinput {
    position  : absolute;
    visibility: hidden;
    width     : 1px;
    height    : 1px;
    opacity   : 0;
}

.account-settings-links .list-group-item.active {
    font-weight: bold !important;
}

html:not(.dark-style) .account-settings-links .list-group-item.active {
    background: transparent !important;
}

.account-settings-multiselect~.select2-container {
    width: 100% !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.material-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.material-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.dark-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(255, 255, 255, 0.03) !important;
}

.dark-style .account-settings-links .list-group-item.active {
    color: #fff !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4E5155 !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
 </head>
<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
        Paramètres du compte
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Changer mot de passe</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Info</a>
                        <!-- <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-social-links">Social links</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-connections">Connections</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-notifications">Notifications</a> -->
                    </div>
                </div>
                <div class="col-md-9" >
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="<?php 
       if(isset($utilisateur['chemin']) && !empty($utilisateur['chemin'])){
         echo $utilisateur['chemin'];
       }else{
         echo "./images/hj.jpeg";
       }
       ?>"  class="d-block ui-w-80"> &nbsp;                                
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <form  method="post" enctype="multipart/form-data">

                                    <!-- <input type="checkbox" name="chckmodifier"  class="btn btn-danger" value="option1">Supprimer<br> -->
                                    <input type="checkbox" name="chckmodifier" id="check" width="20px" height="20px" value="option2">
                                        <label for="">Voulez vous modifier l'image?</label><br>
                                    
                                <div class="form-group" id="img">
                                    <input type="file" name="image" >
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Prenom</label>
                                    <input type="text" class="form-control mb-1" name="prenom" value="<?= $utilisateur['prenom']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="nom" value="<?= $utilisateur['nom']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Courriel</label>
                                    <input type="text" class="form-control mb-1" name="courriel" value="<?= $utilisateur['courriel']; ?>">
                                    
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Votre ancien mot de passe</label>
                                    <input type="password" class="form-control" name="mot_de_passe">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input type="password" name="nouveau" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirmer votre mot de passe</label>
                                    <input type="password" name="c_nouveau" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                <!-- <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <textarea class="form-control"
                                        rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                                </div> -->
                                <div class="form-group">
                                    <label class="form-label">date de naissance</label>
                                    <input type="date" class="form-control" name="date_naissance" value="<?php echo $utilisateur['date_naissance']; ?>" placeholder="YYYY-MM-DD">
                                </div>
                                <!-- <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <select class="custom-select">
                                        <option>USA</option>
                                        <option selected>Canada</option>
                                        <option>UK</option>
                                        <option>Germany</option>
                                        <option>France</option>
                                    </select>
                                </div> -->
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Contacts</h6>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="telephone" value="<?php echo $utilisateur['telephone']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">genre</label><br>
                                    <select class="custom-select" name="sexe">
                                        <option>
                                            <?php if($utilisateur['sexe']=="homme"){
                                                echo "femme";
                                            } else if($utilisateur['sexe']=="femme"){
                                                 echo "homme"; }
                                                 else{
                                                    echo "homme";
                                                    echo " <option>femme</option>";
                                                 }
                                                 ?>
                                                 
                                        </option>
                                        <option selected><?php echo $utilisateur['sexe']; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="tab-pane fade" id="account-social-links">
                           <!--  <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" value="https://twitter.com/user">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" value="https://www.facebook.com/user">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Google+</label>
                                    <input type="text" class="form-control" value>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control" value>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" value="https://www.instagram.com/user">
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="tab-pane fade" id="account-connections">
                            <div class="card-body">
                                <button type="button" class="btn btn-twitter">Connect to
                                    <strong>Twitter</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <h5 class="mb-2">
                                    <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i
                                            class="ion ion-md-close"></i> Remove</a>
                                    <i class="ion ion-logo-google text-google"></i>
                                    You are connected to Google:
                                </h5>
                                <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-facebook">Connect to
                                    <strong>Facebook</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-instagram">Connect to
                                    <strong>Instagram</strong></button>
                            </div>
                        </div> -->
                        <!-- <div class="tab-pane fade" id="account-notifications">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Activity</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone comments on my article</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone answers on my forum
                                            thread</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone follows me</span>
                                    </label>
                                </div> -->
                            <!-- </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Application</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">News and announcements</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly product updates</span>
                                    </label>
                                </div>
                                
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly blog digest</span>
                                    </label>
                                </div> -->
                            </div>
                        </div>
                    </div>
                                    </div>
            </div>
        </div>
        <div class="text-right mt-3">
            <input type="submit" name="btn-update" class="btn btn-primary" value="sauvegarder">&nbsp;
            <a href="./index.php"  class="btn btn-default">Annuler</a>
        </div>
        </form>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>
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
