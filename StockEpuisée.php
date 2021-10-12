<?php


session_start();
$pageTitle='Stock Epuisée';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <style>
    #imlogo{
       float:right;
    width:150px
       
    }
   
          


   
    *{
    
        font-size:16px
    }
   
    </style>
</head>
<body>
<?php 
 
 include($templates."navModeStock.php");

?> 
<br> <br> <br><br><br> <br> <br>

<div class="container"> 
 <fieldset style="background-color:whitesmoke"> 
 
 <legend> <h3 style="color:red;text-decoration:underline">Rupture De Stock:</h3> </legend>


<img id="imlogo" src="Gestion_Stock/layouts/images/unnamed.png">
<br><br>
<h2>Université Chouaib Doukkali</h2>
<h2>Faculté des Sciences</h2> 

<h4>El Jadida</h4>
<br><br>
<h5 id="date"> 
La Date:
<script>
let today = new Date().toLocaleDateString()
document.write(today)</script>
</h5>

<br> <br> <br> 

<h2>Les Produits:</h2>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-striped" border="1">
<thead>
<tr class="table-light">
 <th scope="col">N° Produit</th>
 <th scope="col">Designation</th>
 <th scope="col">Type</th>
 <th scope="col">NumInvantaire</th> 
 <th scope="col">Catégorie</th>
 <th scope="col" style="color:red" >En Stock</th>
 <th scope="col" style="color:red" >Alert</th>

</tr>
</thead>
<tbody> 
<?php 
$stmt=$Con->prepare("SELECT *FROM article e1 
where e1.code_art=e1.code_art
and e1.qte_art<=e1.alert and e1.Type_Art=?");
$stmt->execute(array("consomable"));
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                if($count>0){

               foreach($rows as $row){
                ?> 
                <tr class=" table-info"> 

            <th > <?php echo $row[0];?></th>
            <th > <?php echo $row[1];?></th>
            <th > <?php echo $row[3];?></th>
            <th >
            
            
             <?php 
             echo $row[4];?>
             
             
             
             </th>
        
            <th > <?php
              $cat= $row[6];
              $stmt=$Con->prepare("SELECT *from categorie where numCategorie = ? ");
              $stmt->execute(array($cat));
              $myrow = $stmt->fetch();
              echo $myrow[1];
            
            
            
            ?></th>
            <th > <?php echo $row[2];?></th>
            <th > <?php echo $row[7];?></th>
            
           <?php

               }
            }
            ?>
                  
                 <tr> <td colspan="7">  <input type="button" onclick="window.print()" style="width:100%;font-size:25px" value="Enregistrer" ></td> </tr>
</tbody>
   </table>



   

   </fieldset>
   </div>
<?php 

}else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>