<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: User.php');
    exit();

} else {
    include 'header.php';
    $id_User = $_GET['id'];

    $resultat =  DeleteUser($id_User);
    if ($resultat) {
        ?>
        <script>
            window.location.href = "User.php";
        </script>
        <?php
    } else {

    }

}


?>