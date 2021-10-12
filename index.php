
<?php  
session_start();
$pageTitle='Connexion';//title pages
$novabar=''; //No Nav Bar in this Page From Init.php

include('init.php'); 


if(isset($_SESSION["nomUtilisateur_admin"])){ 

    header('location: gestionstock.php');
    exit();

}else{





    /*Check The Login */
if($_SERVER["REQUEST_METHOD"]=="POST"){
            $email=htmlspecialchars(trim($_POST['email']));
            $password=htmlspecialchars(trim($_POST['password']));
            $sha1_Pass=htmlspecialchars(trim(sha1($password)));//Password Screpting
          
            /*Select info Admin From DataBase */ 
          $stmt=$Con->prepare("select *from admin  where email_admin =? and  moteDePass_admin = ? LIMIT 1");
         $stmt->execute(array($email,$sha1_Pass));
         $rows=$stmt->fetch();
         $count=$stmt->rowCount(); 
         
            print_r($rows);

         if($count>0){ 
              
         
               $_SESSION["nomUtilisateur_admin"]=$rows["nomUtilisateur_admin"];
               $_SESSION["Id_admin"]=$rows["Id_admin"];

              header('location: gestionstock.php');
              exit();

         }else{ 
                    
                    //function libelle in funtion.php 
                    echo "<script>alert(' Admin n est Exist Pas');</script>";
                    $email=htmlspecialchars(trim($_POST['email']));
                   
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
    <link rel="stylesheet" href="<?php echo $cssFile;?>Login-Form-d.css">
  

    <style>
            *{
                overflow:hidden;
            }


    </style>
</head>
   

<body>


<div class="login-dark">
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>" >
            <h2 class="sr-only">Login Form</h2>

            <div id="myimg"><img width="150" height="150" src="./Gestion_Stock/layouts/images/unnamed.png" ></div>
         <br>
            <h3 style="text-align:center;color:#b1c1e8;font-weight:700;text-decoration:underline">Faculté Des Science El Jadida</h3>
            <br>
            <br>
            <br>
  
            <h5 style="text-align:center;color:#b1c1e8;text-decoration:underline;"> Formulaire De Connexion</h5>
            <br>
<br>
            <div class="form-group"><input class="form-control" type="email" name="email" value="<?php if(isset($email))echo $email; ?>" placeholder="Email" required="required" ></div>
            <div class="form-group"><input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Mote De passe " required="required"></div>
            <div class="form-group">
                <button class="btn btn-info btn-block" style="text-align:center;background-color:#2c498b5c;font-weight:700" type="submit">Connexion</button>
           
           </div>
            <a href="recovoirepsdw.php" type="submit" class="forgot">Mot de passe oublié ?</a> 
         
        </form>
    </div> 

    
<?php  
}
    include($templates."footer.php"); 
?>