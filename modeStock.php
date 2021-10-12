
<?php 

session_start(); 

$pageTitle='ModeStock';//title pages
$novabar=''; //No Nav Bar in this Page From Init.php
include('init.php');
if(isset($_SESSION["nomUtilisateur_admin"])){ 

?>

   
<?php 
 
 include($templates."navModeStock.php");

?>
<div class="containersss">
  <span class="text1">Bienvenue <?php echo $_SESSION["nomUtilisateur_admin"] ?> </span>
  <span class="text2">En Gestion de Stock</span>
</div>
<?php 
}else{
    header("location:index.php");
    exit();
}
 include($templates."footer.php");
  ?>
