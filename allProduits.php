<?php


session_start();
$pageTitle='Tous Les Produits';//title pages
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
    width:150px;
   
       
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
<br> <br>
<fieldset style="background-color:whitesmoke">
<div class="container"> 
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

<br> <br> 
<h2 style="text-align:center">Les Produits</h2>
<h2 style="text-decoration:underline">Les Produits Consomable :</h2>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-striped" border="1">
<thead>
<tr class="table-light">
 
 <th scope="col">Designation</th>
 <th scope="col">Type</th>
 <th scope="col">NumInvantaire</th> 
 <th scope="col">Catégorie</th>
 

</tr>
</thead>
<tbody> 
<?php 
$stmt=$Con->prepare("SELECT *FROM article where Type_Art = ?");
        $stmt->execute(array("consomable"));
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                if($count>0){

               foreach($rows as $row){

               
                ?> 
                <tr class=" table-info"> 

            
            <td > <?php echo $row[1];?></td>
            <td > <?php echo $row[3];?></td>
            <td >
            
            
             <?php echo $row[4];?>
             
             
             
             </td>
        
            <td > <?php
              $cat= $row[6];
              $stmt=$Con->prepare("SELECT *from categorie where numCategorie = ? ");
              $stmt->execute(array($cat));
              $myrow = $stmt->fetch();
              echo $myrow[1];
            
            
            
            ?></td>
   
            
           <?php

               }
            }
            ?>
                  
</tbody>
   </table>



   <br> <br> <br> <br>

<h2 style="text-decoration:underline">Les Produits Non Consomable :</h2>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-striped" border="1">
<thead>
<tr class="table-light">

 <th scope="col">Designation</th>
 <th scope="col">Type</th>
 <th scope="col">NumInvantaire</th> 
 <th scope="col">Catégorie</th>


</tr>
</thead>
<tbody> 
<?php 
$stmt=$Con->prepare("SELECT *FROM article where Type_Art = ?");
        $stmt->execute(array("non consomable"));
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                if($count>0){

               foreach($rows as $row){
               
        
                     $mystring =  $row["NumInventaire"];
                      $indexof = strpos($mystring,"/");
                      $newstring = substr($mystring,0,$indexof ); 
                      $numinvtcomplet = substr($mystring,$indexof ); 
                      $numinvt =  explode("-", $newstring);
        
                     
        
                       if( !empty($numinvt[0]) && !empty($numinvt[1])&&is_numeric($numinvt[0]) && is_numeric($numinvt[1]) ){
        
                            for($i=$numinvt[0];$i<=$numinvt[1];$i++){

                              
                            

                ?> 
      <tr class=" table-info"> 

            
            <td > <?php echo $row[1];?></td>
            <td > <?php echo $row[3];?></td>
            <td >
            
            
             <?php echo $i.$numinvtcomplet;?>
             
             
             
             </td>
        
            <td >  <?php
              $cat= $row[6];
              $stmt=$Con->prepare("SELECT *from categorie where numCategorie = ? ");
              $stmt->execute(array($cat));
              $myrow = $stmt->fetch();
              echo $myrow[1];
            
            
            
            ?></td>
           
            </tr>
           <?php
                            } 
                           }else{?>

<tr class=" table-info"> 


<td > <?php echo $row[1];?></td>
<td > <?php echo $row[3];?></td>
<td >


 <?php echo $row[4];?>
 
 
 
 </td>

<td >  <?php
  $cat= $row[6];
  $stmt=$Con->prepare("SELECT *from categorie where numCategorie = ? ");
  $stmt->execute(array($cat));
  $myrow = $stmt->fetch();
  echo $myrow[1];



?></td>

</tr>

                           <?php

                           }
               }

            }
            ?>
                      
             <tr><td colspan="9"><input type="button" onclick="window.print()" style="width:100%;font-size:25px" value="Enregistrer" > </td></tr> 

</tbody>
   </table>


   </div>

</fieldset>
<?php 

}else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>