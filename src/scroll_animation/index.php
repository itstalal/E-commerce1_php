
<?php
include './header.php';
?>
<body>
    <main>
      
            
             <?php include './navbar.php'; echo '<br>'?>
        <!-- </header> -->
        <section class="banner">
            <div class="content">
                <h1 class="left">GameHaven</h1>
<!--                
                <div class="image">
                   <img src="images/v" alt="">
                   <a class="btn btn-warning btn-lg" href="./MAGASIN.php" style="left: 200px; position:absolute; bottom: 45px;"><i class="bi bi-bag-plus-fill"> SHOP NOW</i></a>
                   <h2 style="left: 80px; position:absolute; top: 20px; color:gray; " >Reduction de <br><p style="color:red;">75%</p> 
                      Soldes d'été 2024</h2>
                    

                </div> -->
                <img style="width: 100%; height:auto;" src="../../upload/images/ps5_slim.webp" alt="">
            </div>
        </section>


        <br><br>
            
            <h1 class="autoShow font-bold text-4xl mb-4 text-center">Games from PlayStation Studios</h1>
        

       
        <div class="container-fluid" style="display: flex;
            justify-content: center; 
            align-items: center; 
            width: 300px; 
            margin-left: auto; 
            ">
            <?php include './allproduits.php'; ?>
        </div>
       <?php echo "<br><br>" ?> <br>


           
           
            
           <?php echo "<br> <br>" ; ?>

            <div class="auto-show">
                <?php include './movepic.php'; ?>
            </div>
        </section>
    </main>

</body>
</html>