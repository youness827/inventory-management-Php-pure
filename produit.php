<?php 
session_start();
$pageTitle='Gestion Produits';//title pages
   $novabar='';
    include("init.php");
    if(isset($_SESSION["nomUtilisateur_admin"])){ 
        
            /** Ajouter Cat*/


              //Insertion fournisseur
              if( isset($_POST["_addProd"])  ){
            
                //Function Check if exist  in database before insert
          if(!empty($_POST["designationArt"]) && !empty($_POST["qteArt"]) && !empty($_POST["valRadio"])){
                        
            if($_POST["selectFr"]!="Fournisseur..." && $_POST["selectCat"]!="Catégories..."){
                   
            
/*
                    if(isset($_POST["slice1"]) && !empty($_POST["slice1"]) && $_POST["slice1"]!="undefined" && is_numeric($_POST["slice1"]) ){
                                
                        for($i=$_POST["slice0"];$i<=$_POST["slice1"];$i++){
                            $allinvt = strval($i).$_POST["numinvtcomplet"];
                            $stmt=$Con->prepare("INSERT INTO
                            article(designation_art,qte_art,Type_Art,NumInventaire,num_fr,num_cat,alert)
                        VALUES 
                        (?,?,?,?,?,?,?)");
            $stmt->execute(array(htmlspecialchars(trim($_POST["designationArt"])),htmlspecialchars(trim($_POST["qteArt"])),htmlspecialchars(trim($_POST["valRadio"])),htmlspecialchars(trim($allinvt)),htmlspecialchars(trim($_POST["selectFr"])),htmlspecialchars(trim($_POST["selectCat"])),htmlspecialchars(trim($_POST["alertart"]))));

                                
                        }

                                 

                                         
                    }else{*/

$stmt=$Con->prepare("INSERT INTO
                    article(designation_art,qte_art,Type_Art,NumInventaire,num_fr,num_cat,alert)
                VALUES 
                (?,?,?,?,?,?,?)");
$stmt->execute(array(htmlspecialchars(trim($_POST["designationArt"])),htmlspecialchars(trim($_POST["qteArt"])),htmlspecialchars(trim($_POST["valRadio"])),htmlspecialchars(trim($_POST["numiinvt"])),htmlspecialchars(trim($_POST["selectFr"])),htmlspecialchars(trim($_POST["selectCat"])),htmlspecialchars(trim($_POST["alertart"]))));


$stmts=$Con->prepare("SELECT *FROM article 
ORDER BY code_art desc
LIMIT 1 ");
 $stmts->execute(array());
$rarticle=$stmts->fetch();

$mystmt=$Con->prepare("INSERT INTO bonentrer (DateEntrer,TypeBon,NuméroCM,id_fr ,if_art,qteentree ) values(?,?,?,?,?,?)");

$mystmt->execute(array( htmlspecialchars(trim($_POST["mydate"])) ,htmlspecialchars(trim($_POST["typecmd"])),htmlspecialchars(trim($_POST["textnumComm"])),htmlspecialchars(trim($_POST["selectFr"])),$rarticle["code_art"],htmlspecialchars(trim($_POST["qteArt"]))));

$count=$mystmt->rowCount();

if($count>0){

  correct_ms_int_upt_dlt("insert",$count,"produit",1);

           
       
    

  
}else{
error_messages("L'insertion de Produit incompléte!!!","produit",1); 
}
//}
            }else{
                echo "<script>alert('Choisir SVP un Fournisseurs/Catégories')</script>";

                $desig =htmlspecialchars(trim( $_POST["designationArt"]));
                $qteArt = htmlspecialchars(trim($_POST["qteArt"]));
                $numinvtes =htmlspecialchars(trim( $_POST["numiinvt"]));
                $alerart =htmlspecialchars(trim( $_POST["alertart"]));

            }
  
                         
             
                        }else{
                         
                      echo "<script>alert('Merci de remplir les champs * obligatoires');</script>";
                        $desig =htmlspecialchars(trim( $_POST["designationArt"]));
                        $qteArt = htmlspecialchars(trim($_POST["qteArt"]));
                        $numinvtes =htmlspecialchars(trim( $_POST["numiinvt"]));
                        $alerart =htmlspecialchars(trim( $_POST["alertart"]));
                     }
                     
                      }//end ajouter 

                /*End AJouter */



                if(isset($_POST["Supprimer"])) { //debut suprimer
                           
                    if(isset($_POST["check"])){
                            $stmt=$Con->prepare("DELETE FROM
                            article 
                            WHERE code_art = ?");
                            $stmt->execute(array(htmlspecialchars(trim($_POST["Supprimers"]))));
                            $count=$stmt->rowCount();
                            if($count>0){ 
                               
                            correct_ms_int_upt_dlt("delete",$count,"produit",1);
                            }  
                        }
                       else{
                            error_messages("La suppression de Article incompléte , ( Clicker Sur confirmation!!! )","Categorie",1); 
                        }
                    }// end supprimer 
        
        
        
        
                /*Modifier Catgeories*/
                if(isset($_POST["modifier"])) { 
                                   
                    if(isset($_POST["check"])){
                            $stmt=$Con->prepare("UPDATE article 
                            SET 
                            designation_art = ?,
                            qte_art = ? ,
                            Type_Art = ? ,
                            NumInventaire = ?,
                            num_fr = ?,
                            num_cat  = ?,
                            alert = ?
                            WHERE code_art  = ?");
                            $stmt->execute(array(htmlspecialchars(trim($_POST["designation"])),htmlspecialchars(trim($_POST["Quantité"])),htmlspecialchars(trim($_POST["Type"])),htmlspecialchars(trim($_POST["NumInvantaire"])),htmlspecialchars(trim($_POST["myselectedFr"])),htmlspecialchars(trim($_POST["myselectCat"])),htmlspecialchars(trim($_POST["alertalert"])),trim($_POST["Modifiers"])));
                            $count=$stmt->rowCount();
                            if($count>0){ 
                               
                            correct_ms_int_upt_dlt("update",$count,"produit",1);
                            }  
                        }
                       else{
                            error_messages("La Modification de Produit incompléte , ( Clicker Sur confirmation!!! )","produit",1); 
                        }
                    }// end modifier
         //Rechercehr
    if(isset($_POST["rechercherCat"])){ 
        if(!empty($_POST["inputRechercher"])){
            $trim = htmlspecialchars(trim($_POST["inputRechercher"]));
            $check = RechercheDatabase($Con,"article","designation_art",$trim);
            if($check){
              
              
                echo "<script>alert('Ce Produit Exist dans la base de données')</script>";
            }else{
                echo '<script>alert("Ce Produit n\'est Exist Pas dans la base de données")</script>';

            }
        }else{
            echo "<script>alert('Remplire Le champ de Recherche svp')</script>";

        }
} 
        
        ?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo $cssFile;?>art.css">
    </head>
    <body> 
    <?php 
 include($templates."navModeStock.php"); 
 

?>
        <br> <br> <br>
        <h4>Les informations concernant les Produits</h4> 
         <br> 


<div class="container"> 

 
    
  

         <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
         
        <div class="row">
            <section>
                <table id="text" class="table-striped" >
                <tr>
                        <td>Type de commande :</td>
                        <td> 
                        <select name="typecmd" id="myselectbon"> 
                      
                        <option>Bon Commande</option>
                        <option>Bon Marché</option>
                        </select>
                        </td>
                    </tr>
                <tr>
                    <td>N° Commande : <span style="color:red">*</span></td>                  
                      <td>
                          <input type="text" required id="tb_num_commande" name="textnumComm">
                      </td>
                      <input type="hidden" id="mydate" name="mydate">

                 </tr>

        
                    <tr>
                        <td id="td_">Designation : <span style="color:red">*</span> </td>
                        <td > <input type="text" required id="tb_designation" title="" name="designationArt" value="<?php if(isset($desig))echo $desig; ?>" ></td>
                    </tr>
        
                    <tr>
                        <td id="td_">Quantité  : <span style="color:red">*</span> </td>
                        <td> <input type="number" id="tb_qte" required  min="1" name="qteArt" value="<?php if(isset($qteArt))echo $qteArt;?>"> </td>
                    </tr>
                    <tr>
                        <td id="td_">Alert article:</td>
                        <td> <input type="number" id="tb_alert"   min="0" name="alertart" value="<?php if(isset($alerart))echo $alerart;?>"> </td>
                    </tr>
                    <tr>
                        <td id="td_">Type d'article <span style="color:red">*</span> </td>
                        <td>
                            <input type="radio" value="consomable" id="radio_consom"  name="article"> <label for="radio_consom" style="color: black;">Consommable</label>
                            <input type="radio" value="non consomable" id="radio_non_cosom" name="article" > <label for="radio_non_cosom" style="color: black;">Non-Consommable</label>
                            <input type="hidden" id="val" name="valRadio" >
                        </td>
                    </tr>
        
                    <tr>
                        <td id="td_">Numero d'invantaire :</td>
                        <td> <input type="text" id="tb_num" name="numINVT"  value="<?php if(isset($numinvtes))echo $numinvtes; ?>" >
                             <input type="hidden" id="hidNum" name="numiinvt" >
                             <input type="hidden" id="slice0" name="slice0">
                             <input type="hidden" id="slice1" name="slice1">
                             <input type="hidden" id="numinvtcomplet" name="numinvtcomplet">
                         </td>
                    </tr> 
                  
               
                    <tr>
                        <td id="td_">Catégorie : <span style="color:red">*</span> </td>
                        <td>
                            
                        
                            <select name="selectCat" id="bestselectcat">
                            <?php  
                                $stmt=$Con->prepare("SELECT *FROM categorie 
                                ORDER BY designation_categorie  ");
                                $stmt->execute(array());
                                $row=$stmt->fetchAll();
                                $count=$stmt->rowCount();
                                
                                if($count>0){
    
                                    foreach($row as $fr){  ?>
                            
                            <option value="<?php echo $fr["numCategorie"] ?>"><?php echo $fr["designation_categorie"]?></option>
                            <?php   } 
                              } 
                            ?>
                            
                            </select> 
                        
                        
                        
                        </td>
                    </tr> 
                    <tr>
                        <td id="td_">Fournisseur : <span style="color:red">*</span> </td>
                        <td>
                            
                        
                        <select name="selectFr" id="bestselectFr">
                        <?php  
                            $stmt=$Con->prepare("SELECT *FROM fournisseur 
                            ORDER BY Raison_Social_fr  ");
                            $stmt->execute(array());
                            $row=$stmt->fetchAll();
                            $count=$stmt->rowCount();
                            
                            if($count>0){

                                foreach($row as $fr){  ?>
                        
                        <option value="<?php echo $fr["num_fr"] ?>"><?php echo $fr["Raison_Social_fr"]?></option>
                        <?php   } 
                          } 
                        ?>
                        
                        </select> 
                    
                    
                    
                    </td>
                    </tr> 
                  
                </table>
            </section>
           
      
                    <!--RESULTAT TYPE D'ARTICLE-->
                <span id="type_article" hidden></span>
<br>
            <aside class="right">
                <table id="table_button">
                    <tr>
                        <td> 
                           
                        <input type="submit" name="_addProd" value="Ajouter" onclick="test()" id="button" onclick=""> 
                           
                    </td>
                    </tr> 
                  <!--
                    <tr>
                        <td> <input type="button" value="Modifier" id="button" onclick=""> </td>
                    </tr> 
                    
                    <tr>
                        <td> <input type="button" value="Supprimer" id="button" onclick=""> </td>
                    </tr>
                        -->
                   
                    <tr>
                        <td> <input type="button" data-toggle="modal" data-target="#exampleModal" value="Rechercher" id="button" onclick=""> </td>
                    </tr> 
                    <tr>
                        <td> 
                        <input type="button" onclick="anuller()" value="Annuler" id="button" >
                       </td>
                    </tr> 
                </table>
            </aside>
 
</div> 
            <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
       <!-- Modal Rechercher -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Produit: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Par Designation : </span>
  </div>
  <input type="text" class="form-control" id="rechercheInput"  name="inputRechercher" aria-describedby="basic-addon1">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit"  name="rechercherCat"class="btn btn-info" onclick="leaverequired()" >Rechercher</button>
      </div>
    </div>
  </div>
</div>
       </form>
       <br>
       <br>
<!--Rechercher-->
<form method="post" action="<?php $_SERVER["PHP_SELF"];?>"
        <table id="table_rechercher">
            <tr>
                <td>
                  <input type="submit" name="rechercher" onclick="leaverequired()" id="recher" class="rechercher" value="Designation :">
                  <select   name="selectRechercher" id="resarchProduit" style="width: 150px;font-weight:600;height:37px">
                        <?php  
                            $stmt=$Con->prepare("SELECT *FROM article 
                            ORDER BY designation_art ");
                            $stmt->execute(array());
                            $row=$stmt->fetchAll();
                            $count=$stmt->rowCount();
                            
                            if($count>0){

                                foreach($row as $fr){  ?>
                        
                        <option value="<?php echo $fr["code_art"] ?>"> <?php echo $fr["designation_art"]?> -- <?php echo $fr["NumInventaire"] ?> </option>
                        <?php   } 
                          } 
                        ?>
                        
                        </select> 
                   
                   <!-- <input type="text" id="rechercher" name="num_recherch" placeholder="Par : Numéro Produit ">-->
                </td>
          
                <td>
                  <input type="submit" name="rechercherbyNUMINVT"  onclick="leaverequired()" id="recher" class="rechercher" value="Numéro d'Inventaire :">
                  </td>
                  <td>
                    <input type="text" id="rechercherssssNUMINVT" name="rechercherbyNUMINVT_text" placeholder="Numéro d'Inventaire"  >
                </td>
            </tr>
        </table> 
         </form> 


        </div>
  
    <h3 style="color:royalblue">Produits:</h3>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-info" border="1">
<thead>
<tr class="table-light">
 <th scope="col">N° Produit</th>
 <th scope="col">Designation</th>
 <th scope="col">Quantité</th>
 <th scope="col">Alert</th>
 <th scope="col">Type</th>
 <th scope="col">NumInvantaire</th> 
 <th scope="col">Catégorie</th>
 <th scope="col">Fournisseur</th>
 <th scope="col" style="color:red" >Oppérations</th>
 <th scope="col" style="color:red">Confirmation</th>
</tr>
</thead>
<tbody> 
<?php
        if(isset($_POST["rechercher"]) || isset($_POST["rechercherbyNUMINVT"])  ){
           
            if((!empty($_POST["selectRechercher"] && $_POST["selectRechercher"]!="Produit...") || !empty($_POST["rechercherbyNUMINVT_text"]) )){
        if(isset($_POST["rechercher"])){
            $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
            $stmt->execute(array($_POST["selectRechercher"]));

        }else if(isset($_POST["rechercherbyNUMINVT"])){
            $stmt=$Con->prepare("SELECT *from article where NumInventaire = ? ");
            $stmt->execute(array($_POST["rechercherbyNUMINVT_text"]));

        }
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                if($count>0){

               foreach($rows as $row){
                   
                    ?> 
                    <tr  > 

                <td > <input type="text" size="9" value="<?php echo $row[0];?>" disabled="disabled"></td>
                <td > <input type="text" size="9" name="designation" value="<?php echo $row[1];?>" ></td>
                <td > <input type="text" size="10" name="Quantité" value="<?php echo $row[2];?>" ></td>
                <td > <input type="text" size="10" name="alertalert" value="<?php echo $row[7];?>" ></td>
                <td > <input type="text"size="10"  name="Type" value="<?php echo $row[3];?>" ></td>
                <td > <input type="text"size="10" name="NumInvantaire" value="<?php echo $row[4];?>" ></td>
                <td > 
               
                    <select name="myselectCat" style="width:200px;" id="myselect">  
                    <?php 
                    
                        $stmt=$Con->prepare("SELECT 
                                            *FROM categorie 
                                             ");
                        $stmt->execute(array());
                        $rrr = $stmt->fetchAll(); 
                        
                        foreach($rrr as $r){ 
                    ?> 
                     <option value="<?php echo $r["numCategorie"];?>" > <?php echo $r["designation_categorie"];?> </option> 
                     
                     <?php } ?>
                    </select>
                    <input type="hidden" size="10" id="mytextss" name="Catégorie" value="<?php echo $row[6];?>" >
                    
            
            </td>
                <td >
                <select name="myselectedFr" style="width:200px;" id="myselectfr">  
                    <?php 
                    
                        $stmt=$Con->prepare("SELECT 
                                            *FROM fournisseur 
                                             ");
                        $stmt->execute(array());
                        $rrr = $stmt->fetchAll(); 
                        
                        foreach($rrr as $r){ 
                    ?> 
                     <option value="<?php echo $r["num_fr"];?>" > <?php echo $r["Raison_Social_fr"];?> </option> 
                     
                     <?php } ?>
                    </select>
                
                
                 <input type="hidden"size="10" name="Fournisseur" id="mytextessFour" value="<?php echo $row[5];?>" >
   
                 
                 
                 </td>
                <td><input type="submit"    class="btnFr_modifier_supprimer" onclick="leaverequired()" name="Supprimer"value="Supprimer">
                 <input type="submit"    class="btnFr_modifier_supprimer"  onclick="leaverequired()" name="modifier"value="Modifier">
                </td>
                <td><input type="checkbox" id="checkfr" name="check"></td>
                <input type="hidden"  name="Supprimers" value="<?php echo $row[0];?>">
                <input type="hidden"  name="Modifiers" value="<?php echo $row[0];?>">
                    </tr>
                  
  <?php
         }    
        }
            }else{
                echo "<script>alert('choisir svp un produit!!');</script>";
            }
        }
  
  ?>
              

</tbody>
</table> 
</form>






















                            <script> 



                                   function convert(){
  let current_datetime = new Date()
  let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
  return formatted_date; 
}

                      today=convert();
                      mydate.value=today;
    var myselectbon =  document.getElementById("myselectbon");
                                    var option = document.createElement("option");
                                    option.text = "Type de Bon...";
                                    option.selected=true;
                                    myselectbon.add(option); 

    var x = document.getElementById("resarchProduit");
                                    var option = document.createElement("option");
                                    option.text = "Produit...";
                                    option.selected=true;
                                    x.add(option);

                var frfrfr =     document.getElementById("bestselectFr");
                                    var option = document.createElement("option");
                                    option.text = "Fournisseur...";
                                    option.selected=true;
                                    frfrfr.add(option);  

                var prprpr =     document.getElementById("bestselectcat");
                                    var option = document.createElement("option");
                                    option.text = "Catégories...";
                                    option.selected=true;
                                    prprpr.add(option); 

                                    document.getElementById("radio_consom").onclick=function(){            
                                    document.getElementById("tb_num").disabled = true; 
                                    document.getElementById("val").value=radio_consom.value;
                                    hidNum.value="";
                                        }


                                    document.getElementById("radio_non_cosom").onclick=function(){                
                                    document.getElementById("tb_num").disabled = false;
                                    document.getElementById("tb_num").required=true; 
                                    document.getElementById("val").value=radio_non_cosom.value;
                                  
                                 }
                                 function test(){
                                            if( document.getElementById("val").value==radio_non_cosom.value){
                                                hidNum.value= document.getElementById("tb_num").value;
                                            }
                                        }

                                 recher.onclick=function(){
                                    document.getElementById("tb_num").required=false; 
                                 }
                                 
                                    

                                 var myselectfr = document.getElementById("myselectfr");
                                var mytextfour = document.getElementById("mytextessFour");
                                myselectfr.value=mytextfour.value;
                                myselectfr.options.selected=true;
                                var myselect = document.getElementById("myselect");
                                var mytext = document.getElementById("mytextss");
                                myselect.value=mytext.value;
                                myselect.options.selected=true;

                                function  leaverequired(){
                                    tb_designation.required=false;
                                    tb_qte.required=false;
                                }
                                function anuller(){
                                    tb_designation.value="";
                                    tb_qte.value="";
                                    tb_num.value="";
                                 
                                    
                                   
                                   
                            
                                }

                                    
 
                                 </script>

                                

                                 

        <?php 
    }else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>