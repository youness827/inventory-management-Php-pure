<?php


session_start();
$pageTitle='Journal Des Sorties';//title pages
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
    width:350px;
       
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
<h2 style="text-align:center;text-decoration:underline"> Journal Bon des Sorties </h2>
<br><br>
<h4> <span  style="text-decoration:underline;font-size:25px;font-weight:600" >Entre :</span>  <?php $newDate = date("d-m-Y", strtotime($_POST["datefirst"])); echo $newDate;?>  <span  style="text-decoration:underline;font-size:25px;font-weight:600" >Et :</span>  <?php $newDate = date("d-m-Y", strtotime($_POST["datesecond"])); echo $newDate;?></h4>
<br> <br>

  
<h3 style="text-align:center"><span style="text-decoration:underline;font-size:25px;font-weight:600;text-align:center">Les Produits Sorties  :</span> </h3>
   
   <table style="text-align: center;" class="table table-striped" id="tableresultat" border="1">
<thead>
<tr class="table-light">

 <th scope="col">Date Sortie</th>
 <th scope="col">N Invantaire </th>
 <th scope="col">Produit</th>
 <th scope="col">Fonctionnaire</th>
 
    </tr>
</thead>
<tbody> 
<?php 
$total=0;
      $stmt=$Con->prepare("SELECT *FROM bonsorite where  Date_Sorite Between ? and ? ");
    $stmt->execute(array($_POST["datefirst"],$_POST["datesecond"]));
    $row=$stmt->fetchAll();
    $count=$stmt->rowCount();
    
    
    if($count>0){

        foreach($row as $fr){ $total=$total+1; 
          $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
          $stmt->execute(array($fr[4]));
          $test = $stmt->fetch();
          $count=$stmt->rowCount();

             $mystring =  $test["NumInventaire"];
              $indexof = strpos($mystring,"/");
              $newstring = substr($mystring,0,$indexof ); 
              $numinvtcomplet = substr($mystring,$indexof ); 
              $numinvt =  explode("-", $newstring);

             

               if( !empty($numinvt[0]) && !empty($numinvt[1])&&is_numeric($numinvt[0]) && is_numeric($numinvt[1]) ){

                    for($i=$numinvt[0];$i<=$numinvt[1];$i++){


                    

                 ?>
                  <tr class="table-info">

      <td > <?php 
      
      
      $newDate = date("d-m-Y", strtotime($fr[2])); echo $newDate;?>
      
      </td>
      <td >  
      <?php
        echo $i.$numinvtcomplet;
      ?>
      <td >
      
       <?php
       
       $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[4]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["designation_art"];
       
       
       ?>
      
      </td>
      <td >
      
      <?php
      
      $stmt=$Con->prepare("SELECT *from fonctionnaire where Num_Fonctionnaire = ? ");
      $stmt->execute(array($fr[3]));
      $myrow = $stmt->fetch();
      $count=$stmt->rowCount();
     
      echo $myrow["nom_fnt"];
      
      
      ?>
     
     </td>
      
      
    </tr>
                 <?php
            }

            }else{

             
        ?>


       <tr class="table-info">
  
      <td > <?php 
      
      
      $newDate = date("d-m-Y", strtotime($fr[2])); echo $newDate;?>
      
      </td>
      <td > <?php $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[4]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["NumInventaire"];
       ?></td>
            <input type="hidden" id="NumInventaire_test_" value="<?php if(isset($myrow["NumInventaire"]))echo $myrow["NumInventaire"];?>">

      <td >
      
       <?php
       
       $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[4]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["designation_art"];
       
       
       ?>
      
      </td>
      <td >
      
      <?php
      
      $stmt=$Con->prepare("SELECT *from fonctionnaire where Num_Fonctionnaire = ? ");
      $stmt->execute(array($fr[3]));
      $myrow = $stmt->fetch();
      $count=$stmt->rowCount();
     
      echo $myrow["nom_fnt"];
      
      
      ?>
     
     </td>
      
      
    </tr>
<?php 
   }
}
    }else{ 

      echo "<script>alert('aucune résultat trouvé')</script>";
   
  
    }
            ?>      


</tbody>
   </table>           

</div>
</fieldset> 
<hr>
<fieldset style="background-color:whitesmoke"> 
<div class="container"> 
<img id="imlogo" src="../YY_HH_GS/Gestion_Stock/layouts/images/faculté.jfif">
<br><br>
<h2>Université Chouaib Doukkali</h2>
<h2>Faculté des Sciences</h2> 
<br>
<h4>El Jadida Le : <script>
let today = new Date().toLocaleDateString()
document.write(today)</script></h4>
<br>
<h2 style="text-align:center;text-decoration:underline"> Journal Des Bons des Sorties </h2>
<br><br>
<h4> <span  style="text-decoration:underline;font-size:25px;font-weight:600" >Entre :</span>  <?php $newDate = date("d-m-Y", strtotime($_POST["datefirst"])); echo $newDate;?>  <span  style="text-decoration:underline;font-size:25px;font-weight:600" >Et :</span>  <?php $newDate = date("d-m-Y", strtotime($_POST["datesecond"])); echo $newDate;?></h4>
<br> <br>

  
<h3 style="text-align:center"><span style="text-decoration:underline;font-size:25px;font-weight:600;text-align:center">Les Produits Sorties  :</span> </h3>
   
   <table style="text-align: center;" class="table table-striped" id="tableresultat" border="1">
<thead>
<tr class="table-light">

 <th scope="col">Date Sortie</th>
 <th scope="col">N Invantaire </th>
 <th scope="col">Produit</th>
 
 
    </tr>
</thead>
<tbody> 
<?php 
$total=0;
      $stmt=$Con->prepare("SELECT *FROM bonsorite where  Date_Sorite Between ? and ? ");
    $stmt->execute(array($_POST["datefirst"],$_POST["datesecond"]));
    $row=$stmt->fetchAll();
    $count=$stmt->rowCount();
    
    
    if($count>0){

        foreach($row as $fr){ $total=$total+1; 
          $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
          $stmt->execute(array($fr[4]));
          $test = $stmt->fetch();
          $count=$stmt->rowCount();

             $mystring =  $test["NumInventaire"];
              $indexof = strpos($mystring,"/");
              $newstring = substr($mystring,0,$indexof ); 
              $numinvtcomplet = substr($mystring,$indexof ); 
              $numinvt =  explode("-", $newstring);

             

               if( !empty($numinvt[0]) && !empty($numinvt[1])&&is_numeric($numinvt[0]) && is_numeric($numinvt[1]) ){

                    for($i=$numinvt[0];$i<=$numinvt[1];$i++){


                    

                 ?>
                  <tr class="table-info">

      <td > <?php 
      
      
      $newDate = date("d-m-Y", strtotime($fr[2])); echo $newDate;?>
      
      </td>
      <td >  
      <?php
        echo $i.$numinvtcomplet;
      ?>
      <td >
      
       <?php
       
       $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[4]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["designation_art"];
       
       
       ?>
      
      </td>
  
      
      
    </tr>
                 <?php
            }

            }else{

             
        ?>


       <tr class="table-info">
  
      <td > <?php 
      
      
      $newDate = date("d-m-Y", strtotime($fr[2])); echo $newDate;?>
      
      </td>
      <td > <?php $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[4]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["NumInventaire"];
       ?></td>
            <input type="hidden" id="NumInventaire_test_" value="<?php if(isset($myrow["NumInventaire"]))echo $myrow["NumInventaire"];?>">

      <td >
      
       <?php
       
       $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
       $stmt->execute(array($fr[4]));
       $myrow = $stmt->fetch();
       $count=$stmt->rowCount();
      
       echo $myrow["designation_art"];
       
       
       ?>
      
      </td>
     
      
      
    </tr>
<?php 
   }
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

<script>
 

/*
var strings = NumInventaire_test_.value;
    var indexof = strings.indexOf("/");
    var newstring = strings.substring(0,indexof);
    var numinvtcomplet = strings.substring(indexof);
    var slice = newstring.split("-");
    slice[0];
      slice[1];
*/
</script>

<?php 
  }else{
    header("location:sortiesjr.php");
    exit();
  }  
}else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>