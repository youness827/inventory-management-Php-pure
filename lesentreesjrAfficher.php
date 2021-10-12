<?php


session_start();
$pageTitle='Journal Des Entrees';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  
        if($_SERVER["REQUEST_METHOD"]=="POST"){ 
              
                    

       

            
      

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <style>
    #imlogo{
       float:right;
    width:350px
       
    }
    

   
       
    </style>
</head>
<body>
<?php 
 
 include($templates."navModeStock.php");

?> 

<br> <br>
<form action="" method="POST">
<fieldset style="background-color:whitesmoke"> 
<div class="container"> 
<img id="imlogo" src="Gestion_Stock/layouts/images/faculté.jfif">
<br><br>
<h2>Université Chouaib Doukkali</h2>
<h2>Faculté des Sciences</h2> 
<br>
<h4>El Jadida Le : <script>
let today = new Date().toLocaleDateString()
document.write(today)</script></h4>
<br>
<h2 style="text-align:center;text-decoration:underline"> Journal Bon des Entrees </h2>
<br><br>
<h4> <span  style="text-decoration:underline;font-size:25px;font-weight:600" >Entre :</span>  <?php $newDate = date("d-m-Y", strtotime($_POST["datefirst"])); echo $newDate;?>  <span  style="text-decoration:underline;font-size:25px;font-weight:600" >Et :</span>  <?php $newDate = date("d-m-Y", strtotime($_POST["datesecond"])); echo $newDate;?></h4>
<br> <br>

  
<h3 style="text-align:center"><span style="text-decoration:underline;font-size:25px;font-weight:600;text-align:center">Les Produits Entree  :</span> </h3>
   
   <table style="text-align: center;" class="table table-striped" border="1">
<thead>
<tr class="table-light">

 <th scope="col">Date Entrer</th>
 <th scope="col">Type Commande </th>
 <th scope="col">Numéro Bon</th>
 <th scope="col">Fournisseur</th>
 <th scope="col">Produit</th>
    </tr>
</thead>
<tbody> 
<?php 
$total=0;
      $stmt=$Con->prepare("SELECT *FROM bonentrer where  DateEntrer Between ? and ? ");
    $stmt->execute(array($_POST["datefirst"],$_POST["datesecond"]));
    $row=$stmt->fetchAll();
    $count=$stmt->rowCount();
    
    
    if($count>0){

        foreach($row as $fr){ $total=$total+1; ?>
       
       <tr class="table-info">
      
      <td > <?php 
      
      
      $newDate = date("d-m-Y", strtotime($fr[1])); echo $newDate;?>
      
      </td>
      <td > <?php 
          echo $fr[2];
      
       ?></td>
      

      <td > <?php 
          echo $fr[3];
      
       ?></td>
  <td > <?php 
    $stmt=$Con->prepare("SELECT *from fournisseur where num_fr = ? ");
    $stmt->execute(array($fr[4]));
    $myrow = $stmt->fetch();
    $count=$stmt->rowCount();
   
    echo $myrow["Raison_Social_fr"];
       
      
       ?></td> 
        
      <td >
      
       <?php
       
       $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[5]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["designation_art"];
       
       
       ?>
      
      </td>
      
      
      
    </tr>
<?php 
 
}
    }else{ 

      echo "<script>alert('aucune résultat trouvé')</script>";
   
  
    }
            ?>      

 <tr> <td colspan="9">  <input type="button" onclick="window.print()" style="width:100%;font-size:25px" value="Enregistrer" ></td> </tr>

</tbody>
   </table>           

</div>
</fieldset> 


<?php 
     }else{
      header("location:lesentreeJr.php");
      exit();
     }
}else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>