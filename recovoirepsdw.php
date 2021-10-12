
<?php  
session_start(); 

$pageTitle='Nouveau Mote de Passe';//title pages
$novabar=''; //No Nav Bar in this Page From Init.php

include('init.php');

if(!(isset($_SESSION["nomUtilisateur_admin"]))){

     if($_SERVER["REQUEST_METHOD"]=="POST"){
   if(isset($_POST["submitConfirmer"])){


   $userName=htmlspecialchars(trim($_POST['username']));
   $email=htmlspecialchars(trim( $_POST['email']));
   $password_N=htmlspecialchars(trim($_POST['password_N']));
   $password_N_C=htmlspecialchars(trim($_POST['password_N_C']));
   $varPass = htmlspecialchars(trim(sha1($password_N)));
    /*Check if exist from database*/
    $stmt=$Con->prepare("SELECT 
                        *from admin  
                        where 
                         email_admin=?
                         and 
                          nomUtilisateur_admin=? LIMIT 1"
                         ); 
    $stmt->execute(array($email,$userName));
    $rows=$stmt->fetch();
    $count=$stmt->rowCount(); 
     if($count>0){
                    
       

               
            if($password_N_C==$password_N)
              {
                $stmt=$Con->prepare("UPDATE admin  
                                    set moteDePass_admin =?
                                    where  
                                    email_admin=?
                                    and 
                                    nomUtilisateur_admin=? 
                                    ");
                $stmt->execute(array($varPass,$email,$userName));
               $count=$stmt->rowcount();
                         if($count>0){
                            //function libelle in funtion.php 
                          correct_ms_int_upt_dlt("update",$count,"index",1);
                         }
                
              }else { 
                  //function libelle in funtion.php 
                echo "<script>alert(' Ressaisir votre mot de passe');</script>";
                $userNames=htmlspecialchars(trim($_POST['username']));
                $emails=htmlspecialchars(trim( $_POST['email']));
               
                }

            
         } else {  
             //function libelle in funtion.php 
             echo "<script>alert(' Admin n est Exist Pas');</script>";
             $userNames=htmlspecialchars(trim($_POST['username']));
             $emails=htmlspecialchars(trim( $_POST['email']));

          }
        
    
   }
}

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
    <link rel="stylesheet" href="<?php echo $cssFile;?>Contact-Form-Cleanss.css">

    
</head>
   

<body>
<div class="contact-clean">
        <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
            <h2 class="text-center">Recevoir un Nouveau Mot de Passe</h2>

          
                         <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="Nom d'utilisateur" value="<?php if(isset($userNames))echo $userName; ?>" required="Required">
            </div>
            
            <div class="form-group">
                <input class="form-control is-invalid" type="email" name="email" placeholder="Email" required="Required" value="<?php if(isset($emails))echo $emails; ?>" autocomplete="none">
                <small class="form-text text-danger"> S'il vous plaît entrer une adresse email valide</small>
            </div>  
            
            <div class="form-group">
                <input class="form-control" type="password" id="password_N" name="password_N"  placeholder="Nouveau mote de passe!!!" required="Required">
            </div>
            
            <div class="form-group">
                <input class="form-control" type="password" id="password_N_C" name="password_N_C"  placeholder="Confirmer mote de pass" required="Required">
            </div>
            <div class="form-group">
            <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">
                        Si Tous Les Informations Sont Correct <strong>S'il vous plaît cocher cette case</strong>
                        </label>
                        </div> 
             </div>
            <div class="form-group">
                <button  class="btn btn-primary" name="submitConfirmer" type="submit">Confirmer</button>
               
            </div>

              <div class="form-group btnanulle">
                 <a href="index.php" class="btn btn-primary"  type="button">Annuler</a>
            </div>

            
        </form>
    </div> 
    
    <?php 

    
}else{
    header("Location:gestionstock.php");
    exit();
}
    include($templates."footer.php");
?>