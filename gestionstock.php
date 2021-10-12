<?php  
session_start();

 include('init.php'); 
 if(isset($_SESSION["nomUtilisateur_admin"])){ 
?> 

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $cssFile;?>ionicons.min.css">
    <title><?php  GestionTitlePage(); ?></title>
    <link rel="stylesheet" href="<?php echo $cssFile;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cssFile;?>styl.min.css">
    <link rel="stylesheet" href="<?php echo $cssFile;?>indexStylesss.css"> 

    
</head>
   

<body>
   <div class="wrapper">
       
       <!-- LANDING PAGE -->
       <div class="landing">
           <div class="landingText" data-aos="fade-up" data-aos-duration="2000">
               <h1>hy.<span style="color:#6C63FF;font-size: 3vw"> Gestion Stock.</span> </h1>
               <h3>Le stock est importante dans l'entreprise. fabriqué et stocké les produits avant de les vendre.</h3>
            <!--   <div class="btn">
                   <a href="createAccount.php">Créer un compte</a>
               </div>-->
           </div>
           <div class="landingImage" data-aos="fade-down" data-aos-duration="2000"> 
           <img src="<?php echo $images;?>bg_.png" alt="">
           </div>
               
       </div>


       
   </div>
   
   <footer>
       <?php 
        include("members.php");
       ?>
   </footer>


   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   <script>
           AOS.init();
   </script>
  
   <?php 
 }else{
     header("location:index.php");
     exit();
 }
    include($templates."footer.php"); 
 
?>