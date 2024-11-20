<?php
include './header.php';
$utilisateur = getutilisateurs();

?>

<body>
    <!--=============== HEADER ===============-->
    <header class="header">
        <nav class="nav container">


            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li>
                        <a href="./index.php" class="nav__link"><i class="bi bi-cart4"></i>
                            <p class="text text-primary">GH-</p>
                            <p class="text text-danger">shop</p>
                        </a>
                    </li>


                    <!--=============== NAV MENU ===============-->
                    <div class="nav__menu" id="nav-menu">
                        <ul class="nav__list">

                            <!--=============== DROPDOWN 2 ===============-->
                            <li class="dropdown__item">
                                <div class="nav__link dropdown__button">
                                    Magasin <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                                </div>

                                <div class="dropdown__container">
                                    <div class="dropdown__content">
                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="bi bi-shop"></i>
                                            </div>

                                            <span class="dropdown__title">decouvrir le magasin</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="./allproduit2.php" class="dropdown__link">Afficher tout les produits</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="bi bi-star-fill"></i>
                                            </div>

                                            <span class="dropdown__title">Les plus populaire</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="#" class="dropdown__link">Jeux soccer</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Jeux bataille</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Jeux enfants</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="ri-apps-2-line"></i>
                                            </div>

                                            <span class="dropdown__title">Autres</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="#" class="dropdown__link">jeux récents</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Notre équipe</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--=============== DROPDOWN 1 ===============-->
                            <li class="dropdown__item">
                                <div class="nav__link dropdown__button">
                                    catégories <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                                </div>

                                <div class="dropdown__container">
                                    <div class="dropdown__content">
                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="bi bi-playstation"></i>
                                            </div>

                                            <span class="dropdown__title">Play station</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="./allps5.php" class="dropdown__link">Play station 5</a>
                                                </li>
                                                <li>
                                                    <a href="./allps4.php" class="dropdown__link">Play station 4</a>
                                                </li>
                                                <li>
                                                    <a href="./allps3.php" class="dropdown__link">Play station 3</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="bi bi-xbox"></i>
                                            </div>

                                            <span class="dropdown__title">Xbox</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="./allxbox.php" class="dropdown__link">Xbox series X</a>
                                                </li>
                                                <li>
                                                    <a href="./allxbox.php" class="dropdown__link">Xbox series S</a>
                                                </li>
                                                <li>
                                                    <a href="./allxbox.php" class="dropdown__link">Xbox One S</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="bi bi-laptop"></i>
                                            </div>

                                            <span class="dropdown__title">PC-Gaming</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="./allpc.php" class="dropdown__link">Laptop</a>
                                                </li>
                                                <li>
                                                    <a href="./allpc.php" class="dropdown__link">Gaming Pc</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="bi bi-phone"></i>
                                            </div>

                                            <span class="dropdown__title">Téléphone</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="#" class="dropdown__link">Android </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Apple</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>



                            <!--=============== DROPDOWN 3 ===============-->
                            <li class="dropdown__item">
                                <div class="nav__link dropdown__button">
                                    Compagnie <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                                </div>

                                <div class="dropdown__container">
                                    <div class="dropdown__content">
                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="ri-community-line"></i>
                                            </div>

                                            <span class="dropdown__title">À propos</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="#" class="dropdown__link">À propos</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Support</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Contacter nous</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="dropdown__group">
                                            <div class="dropdown__icon">
                                                <i class="ri-shield-line"></i>
                                            </div>

                                            <span class="dropdown__title">Sécurité et qualité</span>

                                            <ul class="dropdown__list">
                                                <li>
                                                    <a href="#" class="dropdown__link">Cookie settings</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown__link">Privacy Policy</a>
                                                </li>
                                            </ul> 
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php if (isset($_SESSION['utilisateur']['id_utilisateur']) && isset($_SESSION['utilisateur']['description']) && $_SESSION['utilisateur']['description'] === 'admin') { ?>
                           <li class="text-info h5"> Bienvenue admin</li>
                                <?php } ?>
                        </ul>
                    </div>
        </nav>

        <?php
// var_dump($_SESSION['description']);
//    var_dump($_SESSION['description']); 
        //  var_dump($id_utilisateur);
       
        //  var_dump($_SESSION['Paniers']);
        // '. count($_SESSION['Paniers']).'

        if (isset($_SESSION['utilisateur'])) {
            $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
            $prenom = $_SESSION['utilisateur']['prenom'];
            $nom = $_SESSION['utilisateur']['nom'];
        ?>
            <a href="PANIER.php" class="btn btn-warning" style="width: auto; height: 40px; "><i class="bi bi-cart4"></i>&nbsp(<?php echo count($_SESSION['Paniers']) - 1; ?>)</i>
            </a>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" class="btn btn-danger" style="width: auto; height: 40px; "><i class="bi bi-heart-fill"></i>&nbsp(0)</i></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <li class="nav-item dropdown">
                <a class="nbtn btn-info dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" style="width: auto; height: 40px; border-radius: 20px;"> &nbsp;<?php echo $prenom ?> &nbsp;</a>
                <ul class="dropdown-menu">


                    <li><a class="dropdown-item" href="./infouser.php?id=<?= $id_utilisateur; ?>"><i class="bi bi-pencil-square"></i> &nbsp;Informations</a></li>
                    <li><a class="dropdown-item" href="./maincomd.php?id=<?= $id_utilisateur; ?>"><i class="bi bi-pencil-square"></i> &nbsp;Mes commandes</a></li>
                    <?php if (isset($_SESSION['utilisateur']['id_utilisateur']) && isset($_SESSION['utilisateur']['description']) && $_SESSION['utilisateur']['description'] === 'admin') { ?>
                        
                    
                       <li><a class="dropdown-item" href="../../projetPHP/produits.php">Gérer Produits</a></li> 
                       <li> <a class="dropdown-item" href="../../projetPHP/commandes.php">Gérer Commandes</a></li>
                      <li> <a class="dropdown-item" href="../../projetPHP/User.php">Gérer Utilisateurs</a></li> 
                   
                    <?php } ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="../../db/deconnexion.php"><i class="bi bi-box-arrow-right"></i> &nbsp; Deconnexion</a></li>
                </ul>&nbsp;&nbsp;&nbsp;&nbsp;
            </li>
            <?php
            //include './profile.php'; 
            ?>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php } else { ?>
            <a href="PANIER.php" class="btn btn-warning" style="width: auto; height: 40px; "><i class="bi bi-cart4"></i></i></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" class="btn btn-danger" style="width: auto; height: 40px; "><i class="bi bi-heart-fill"></i></i></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a href="../../db/CONNEXION.php" class="btn btn-success" style="width: auto; height: 40px;"><i class="bi bi-box-arrow-right"></i>&nbsp;connexion</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php } ?>









    </header>

    <!--=============== MAIN JS ===============-->
    <script src="./responsive-navigation-bar/assets/js/main.js"></script>
</body>

</html>