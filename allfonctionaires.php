<?php


session_start();
$pageTitle='Tous Les Fonctionnaires';//title pages
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


<h2 style="text-align:center">Les Fonctionnaires</h2>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-striped" border="1">
<thead>
<tr class="table-light">
<th scope="col">N° Fonctionner</th>
 <th scope="col">Nom</th>
 <th scope="col">Email</th>
 <th scope="col">Tél</th>
 <th scope="col">Service</th>
    </tr>
</thead>
<tbody> 
<?php 

      $stmt=$Con->prepare("SELECT *FROM fonctionnaire ");
    $stmt->execute(array());
    $row=$stmt->fetchAll();
    $count=$stmt->rowCount();
    
    
    if($count>0){

        foreach($row as $fr){  ?>
       
       <tr class="table-info">
      <td > <?php echo $fr[0];?></td>
      <td > <?php echo $fr[1];?></td>
      <td > <?php echo $fr[2];?></td>
      <td > <?php echo $fr[3];?></td>
      <td >
      
       <?php
        
        $frs= $fr[4];
              $stmt=$Con->prepare("SELECT *from departement where NumDepartement = ? ");
              $stmt->execute(array($frs));
              $myrow = $stmt->fetch();
              echo $myrow[1];
       
      
       ?>
       
       </td>
 
    </tr>
<?php 
 
}
    }
            ?>      
<tr> <td colspan="9">  <input type="button" onclick="window.print()" style="width:100%;font-size:25px" value="Enregistrer" ></td> </tr>

</tbody>
   </table>

</fieldset> 

<?php 

}else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>