<?php

session_start();
$pageTitle='Gestion Categorie';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  


       //Insertion fournisseur
       if(isset($_POST["ajouter_cat"])){ 
    if (!isset($_GET['name'])|| $_GET['name']=="null"){ 
        ?>
    <script >
                var loc = location.href;
                var name = prompt("Entre Une Catégorie: *","");  
                if (name == "") {
                    location.reload();        
                } else {
                        location.href ="?name="+name;
                } 
      </script>
      <?php
      
        }
    }   

     if(isset($_GET['name'])&& $_GET['name']!="null"){
       // check if cate exist in dataBase
        $check=RechercheDatabase($Con,"categorie","designation_categorie",htmlspecialchars(trim($_GET['name'])));
                if($check==false){
                    $stmt=$Con->prepare("INSERT INTO
                    Categorie(designation_categorie)
            values (?)");
            $stmt->execute(array(htmlspecialchars(trim($_GET['name']))));
            $count=$stmt->rowCount();
            if($count>0){ 

            correct_ms_int_upt_dlt("insert",$count,"categorie",1);
            } 
            else{

            error_messages("L'Insertion de Categorie incompléte","Categorie",1); 
            }
                }else{
                    error_messages("Cette Catégorie Exist Déja a La Base De données!!","categorie",1);

                }
                        
    }


        if(isset($_POST["Supprimer"])) { //debut suprimer
                           
            if(isset($_POST["check"])){
                    $stmt=$Con->prepare("DELETE FROM
                    categorie 
                    WHERE numCategorie = ?");
                    $stmt->execute(array($_POST["Supprimers"]));
                    $count=$stmt->rowCount();
                    if($count>0){ 
                       
                    correct_ms_int_upt_dlt("delete",$count,"categorie",1);
                    }  
                }
               else{
                    error_messages("La suppression de Categorie incompléte , ( Clicker Sur confirmation!!! )","Categorie",1); 
                }
            }// end supprimer 




        /*Modifier Catgeories*/
        if(isset($_POST["modifier"])) { 
                           
            if(isset($_POST["check"])){
                    $stmt=$Con->prepare("UPDATE categorie 
                    SET 
                    designation_categorie=?
                    WHERE numCategorie = ?");
                    $stmt->execute(array(htmlspecialchars(trim($_POST["designation"])),$_POST["Modifiers"]));
                    $count=$stmt->rowCount();
                    if($count>0){ 
                       
                    correct_ms_int_upt_dlt("update",$count,"Categorie",1);
                    }  
                }
               else{
                    error_messages("La Modification de Catégorie incompléte , ( Clicker Sur confirmation!!! )","Categorie",1); 
                }
            }// end modifier
        //Rechercehr
    if(isset($_POST["rechercherCat"])){ 
                if(!empty($_POST["inputRechercher"])){
                  $trim = htmlspecialchars(trim($_POST["inputRechercher"]));
                    $check = RechercheDatabase($Con,"categorie","designation_categorie",$trim);
                    if($check){
                        echo "<script>alert('Cette Catégorie Exist dans la base de données')</script>";
                    }else{
                        echo '<script>alert("Cette Catégorie n\'est Exist Pas dans la base de données")</script>';
    
                    }
                }else{
                    echo "<script>alert('Remplire Le champ de Recherche svp')</script>";
    
                }
        } 

?>

<!DOCTYPE html>
<html>
<head> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo $cssFile;?>designatins.css">
    </head>
    <body> 
    <?php 
 
 include($templates."navModeStock.php");

?> 
  <br> <br>  <br> <br>
<div class="container" >
        <div class="header" id="myHeader">
            <h4>Les informations Concernant les Catégories
</h4> 
            
          </div>
        
        <div class="row">
            <section>
                <table id="text" class="table-striped">
                    <tr>
                        <td id="td_">N° Catégorie : </td>
                        <td> <input type="text" disabled id="tb_n_designation" > </td>
                    </tr>

                    <tr>
                        <td>Designation : </td>
                        <td>
                        <select id="tb_designation">
                            <option hidden>Désignation ...</option>
                                <?php  
                                  $stmt=$Con->prepare("SELECT *from categorie 
                                  ORDER BY designation_categorie");
                                  $stmt->execute(array());
                                  $rows = $stmt->fetchAll();
                                  $count=$stmt->rowCount();
                                  if($count>0){
                                    foreach($rows as $row){
                                        ?>
                                         <option value="<?php echo $row["numCategorie"] ?>"><?php echo $row["designation_categorie"] ?></option>
                                        
                                        <?php
                                    }
                                  }
                               

                                ?>

                           
                        </select>
                        </td>
                    </tr>
                </table>
            </section>
            <form  action="<?php $_SERVER["PHP_SELF"];?>"  method="post">
            <aside class="right"> 
                <table id="table_button" >
                    <tr>
                        <td> <input type="submit" value="Ajouter" name="ajouter_cat"  id="button" > </td>
                    </tr>
                    <tr>
                        <td> <input type="button" value="Rechercher" name="rechercher_cat" data-toggle="modal" data-target="#exampleModal" id="button" > </td>
                    </tr>
                </table>
           
            </aside> 
            </form>
            </div>


       <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
         <table id="table_rechrcher" style="font-size: large;">
                   <tr>
                         <td style=" border: black solid 1px;  border-radius: 8px;">
                   
                         <select id="searchCattt" name="selectRechercher" style="width: 150px;font-weight:600;height:37px">
                        <?php  
                            $stmt=$Con->prepare("SELECT *FROM categorie 
                            ORDER BY designation_categorie ");
                            $stmt->execute(array());
                            $row=$stmt->fetchAll();
                            $count=$stmt->rowCount();
                            
                            if($count>0){

                                foreach($row as $fr){  ?>
                        
                        <option value="<?php echo $fr["numCategorie"] ?>"> <?php echo $fr["designation_categorie"]?></option>
                        <?php   } 
                          } 
                        ?>
                        
                        </select> 



                         </td>
                    </tr>
                       <tr>
                     <td>
                        <input type="submit" id="butt_rechercher" name="recherch_cat_btn" value="Designations : ">
                     </td>
                     </tr>
          

         </table>
       </form>

       <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
       <!-- Modal Rechercher -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Categories: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Par Designation : </span>
  </div>
  <input type="text" class="form-control" id="rechercheInput" name="inputRechercher" aria-describedby="basic-addon1">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit"  name="rechercherCat"class="btn btn-info">Rechercher</button>
      </div>
    </div>
  </div>
</div>
<!--Rechercher-->
</div>
     
         <h3 style="color:royalblue">Catégorie:</h3>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-info" border="1">
<thead>
<tr class="table-light">
 <th scope="col">N° Catégorie</th>
 <th scope="col">Designation</th>
 <th scope="col" style="color:red" >Oppérations</th>
 <th scope="col" style="color:red">Confirmation</th>
</tr>
</thead>
<tbody> 
  <?php
        if(isset($_POST["recherch_cat_btn"])){
           
            if(!empty($_POST["selectRechercher"] && $_POST["selectRechercher"]!="Categories...") ){
        $stmt=$Con->prepare("SELECT *from categorie where numCategorie = ? ");
        $stmt->execute(array($_POST["selectRechercher"]));
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                if($count>0){

               foreach($rows as $row){
                    ?> 
                    <tr class="table-info" > 

                <td > <input type="text" value="<?php echo $row[0];?>" disabled="disabled"></td>
                <td > <input type="text" name="designation" value="<?php echo $row[1];?>" ></td>
                <td><input type="submit"  class="btnFr_modifier_supprimer" name="Supprimer"value="Supprimer">
                 <input type="submit"  class="btnFr_modifier_supprimer"  name="modifier"value="Modifier">
                </td>
                <td><input type="checkbox" id="checkfr" name="check"></td>
                <input type="hidden"  name="Supprimers" value="<?php echo $row[0];?>">
                <input type="hidden"  name="Modifiers" value="<?php echo $row[0];?>">
                    </tr>
                    <?php
              
  ?>
  <?php
         }    
        }
            }else{
                echo "<script>alert('Choisir Une Categories svp');</script>";
            }
        }
  
  ?>
</tbody>
</table> 
   
   </form>
          
         <script>
                  



                    var tb_n_designation = document.getElementById("tb_n_designation");
                    var tb_designation  = document.getElementById("tb_designation");
                    tb_designation.onchange=function(){
                        tb_n_designation.value=" Numéro de Catégorie sélectionné : "+tb_designation.value;
                    }  
                    
                    var x = document.getElementById("searchCattt");
                                    var option = document.createElement("option");
                                    option.text = "Categories...";
                                    option.selected=true;
                                    x.add(option);

            window.onscroll = function() {myFunction()};
            var header = document.getElementById("myHeader");
            var sticky = header.offsetTop;
            function myFunction() {
              if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
              } else {
                header.classList.remove("sticky");
              }
            }

            
            </script> 
        
<?php 
    }else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>