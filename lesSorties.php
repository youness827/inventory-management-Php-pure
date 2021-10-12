<?php 
session_start();
$pageTitle='Les Sorties';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  

       

        if($_SERVER["REQUEST_METHOD"]=="POST"){ 

                /*Produit info*/
             if (isset($_POST["selectproduit"])){
                    
                   if($_POST["selectproduit"]!="Produit..."){
                    $stmt=$Con->prepare("SELECT *from article where code_art = ? ");
                    $stmt->execute(array($_POST["selectproduit"]));
                    $rows = $stmt->fetch();
                    $count=$stmt->rowCount(); 
                    if($count>0){
                        $_POST["qtePro"]= htmlspecialchars(trim($rows["qte_art"]));
                        $_POST["produit"]=htmlspecialchars(trim($rows["designation_art"]));
                        $_POST["idproduitss"]=htmlspecialchars(trim($rows["code_art"]));
                        $_POST["type"]=htmlspecialchars(trim($rows["Type_Art"]));
                        $_POST["cat"]= htmlspecialchars(trim($rows["num_cat"]));
                        $_POST["nINVT"]=htmlspecialchars(trim($rows["NumInventaire"]));
                    }
                   
                       
            
         
                
            
                
                  }

               
            }
          
            if(isset($_POST["confirmation"])){
                   
                $stmt = $Con->prepare("SELECT *from article where code_art = ?");
                $stmt->execute(array(htmlspecialchars(trim($_POST["numeroProduittest"]))));
                $row=$stmt->fetch();
                $count=$stmt->rowCount();
                if($count>0){
                  if($row["Type_Art"]=="non consomable"){

                 
                
        
                      $stmt=$Con->prepare("INSERT INTO bonsorite (QteSorite,Date_Sorite,num_funct,code_art ) values (?,?,?,?)");
                      $stmt->execute(array(htmlspecialchars(trim($_POST["qtePro"])),htmlspecialchars(trim($_POST["datesrttest"])),htmlspecialchars(trim($_POST["idFonctionnairetest"])),htmlspecialchars(trim($_POST["numeroProduittest"]))));
                      
                      $count=$stmt->rowCount();
                      if($count>0){
                        correct_ms_int_upt_dlt("insert",$count,"lesSorties",1);

                      }else{
                        error_messages("L insertion de Sortie incompléte","lesSorties",1); 

                      }
                    }else if( $row["Type_Art"]=="consomable"){
                      if(isset($_POST["myqtesrt"])){
                        $_POST["qtesrtCtest"]=$_POST["myqtesrt"];
                      }
                      $stmt = $Con->prepare("UPDATE  article 
                      SET qte_art = qte_art - ?
                      where
                      code_art = ?");
                      $stmt->execute(array(htmlspecialchars(trim($_POST["qtesrtCtest"])),htmlspecialchars(trim($_POST["numeroProduittest"]))));
                      

                      $stmt=$Con->prepare("INSERT INTO bonsorite (QteSorite,Date_Sorite,num_funct,code_art ) values (?,?,?,?)");
                      $stmt->execute(array(htmlspecialchars(trim($_POST["qtesrtCtest"])),htmlspecialchars(trim($_POST["datesrttest"])),htmlspecialchars(trim($_POST["idFonctionnairetest"])),htmlspecialchars(trim($_POST["numeroProduittest"]))));
                      
                      $count=$stmt->rowCount();
                      if($count>0){
                        correct_ms_int_upt_dlt("insert",$count,"lesSorties",1);

                      }else{
                        error_messages("L insertion de Sortie incompléte","lesSorties",1); 

                      }
                    
                    }

                }else{

                }      
               
               
                
               
               
                

            }
                
          }
      
?>
 <!DOCTYPE html>
<html>
    <head>
        <title>Designation</title>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <link rel="stylesheet" href="<?php echo $cssFile;?>sort.css">
    </head>

    <body> 
    <?php 
 
 include($templates."navModeStock.php");

?>
<br>
    <br>  
    <div class="container">
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
       
            <h4 id="mytexth1"style="text-align:center">Les informations Concernant les Produits Sorties</h4>
        
       
          

          <div class="row">
            <section>
            
		    <table id="text" class="table table-striped">
        <p style="font-size:20px;font-weight:700;text-decoration:underline"> Les informations des Produits</p>

          
                <tr>
                    <td>Les produits :</td>
                   
                  
                  
                     <td colspan="3">
                         <div id="prod_">
                       
                         <select id="tb_produit" style="width:100%" onchange="this.form.submit()"  style="text-align: center;" name="selectproduit"  >
                        <?php  
                            $stmt=$Con->prepare("SELECT *FROM article 
                            ORDER BY designation_art ");
                            $stmt->execute(array());
                            $row=$stmt->fetchAll();
                            $count=$stmt->rowCount();
                            
                            if($count>0){

                                foreach($row as $fr){  ?>
                        
                        <option value="<?php echo $fr["code_art"] ?>"><?php echo $fr["designation_art"]?> -- <?php echo $fr["NumInventaire"] ?>  </option>
                        <?php   } 
                          } 
                        ?>
                        
                        </select> 
                        </div>
                     </td>
                </tr>
                <tr>
                     <td>Produit : <span style="color:red">*</span></td> <td colspan="3"><input  type="text" style="width:100%"  name="produit" value="<?php if(isset($_POST["produit"]))echo $_POST["produit"];?>"id="idProduitss"  readonly></td>

                </tr>
        
              <td><input type="hidden"  name="idproduitss" value="<?php if(isset($_POST["idproduitss"]))echo $_POST["idproduitss"];?>" id="numeroProduit" readonly></td>

               
                <tr>

                    <td>Quantité :</td> <td><input type="text"  name="qtePro" value="<?php if(isset($_POST["qtePro"]))echo $_POST["qtePro"];?>"id="tb_qte_stock"  readonly></td>
                    <td>Type :</td> <td> <input type="text" name="type" value="<?php if(isset($_POST["type"]))echo $_POST["type"];?>" id="tb_type"  readonly> </td>
                </tr>

                <tr> 
                    <td> Catégorie :</td> <td>
                    <input type="hidden" name="cat" value="<?php if(isset($_POST["cat"]))?>"  readonly>
                    


                        <?php 
                        if(isset($_POST["cat"])){
                           $stmt=$Con->prepare("SELECT *from categorie 
                           where numCategorie = ? 
                           LIMIT 1");
                           $stmt->execute(array($_POST["cat"]));
                           $ro = $stmt->fetch();
                           $count=$stmt->rowCount();
                            if(isset($ro["designation_categorie"])){
                              $_POST["thisCat"]= $ro["designation_categorie"];
                            }
                          
                          
                         
                       } 
                       ?>
                 <input type="text" id="tb_value_cat"  name="thisCat" value="<?php if(isset( $_POST["thisCat"]))echo  $_POST["thisCat"];?>"   readonly>
                        
                        </td>
                    <td>N°Inventaire :</td> <td> <input type="text"name="nINVT" value="<?php if(isset($_POST["nINVT"]))echo $_POST["nINVT"];?>"  id="tb_n_inventaire" readonly></td>
               

                </tr>
              
                <tr>
                  
                <td colspan="1">Qte Sortie(les Produit Consomable) :</td> <td colspan="3"> <input type="text" name="myqtesrt" id="qtesrtC" ></td>
</tr>
                </table>  
    
                      <br>
                <td> <!--<input type="submit" onclick="leaverequired()" value="Afficher Les Informations ( Produit Et Fonctioannaires )" name="info" id="button_afficher" > --></td>


            </section>
         
                <table id="table_sortie">
                    <br>
                    <tr>
                    <td> <input type="button" value="Valider"  id="button_valider" ></td>

                    
                        

                    </tr>
                
                </table>
                     

<!-- Modal -->
<form method="post" action="<?php $_SERVER['PHP_SELF']?>">

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <fieldset>

        <legend style="text-decoration:underline">Les Information du Produit : </legend>
      <table class="table table-striped"  border="2">
       <tr>
       <input type="hidden"  name="numeroProduittest" value="<?php if(isset($_POST["idproduitss"]))echo $_POST["idproduitss"];?>" id="numeroProduittest"  readonly>

       <td><h5>Désignation :</h5></td><td><input type="text" class="text-center"  name="produittest"   value="<?php if(isset($_POST["produit"]))echo $_POST["produit"];?>" id="idProduittest"  readonly></td>
       <td><h5>Quantité : </h5></td><td><input type="text"class="text-center"  readonly  value="<?php if(isset($_POST["qtePro"]))echo $_POST["qtePro"];?>" name="qteProtest" id="tb_qte_stocktest"  ></td>


       
       </tr> 
       <tr>
       
       <td><h5>Type :</h5></td><td><input type="text" class="text-center"  name="typetest"  id="tb_typetest"  value="<?php if(isset($_POST["type"]))echo $_POST["type"];?>"  readonly ></td>
       <td><h5>Catégorie :</h5></td><td><input type="text" class="text-center" name="catstest"  id="tb_categorietest" value="<?php if(isset( $_POST["thisCat"]))echo  $_POST["thisCat"];?>" readonly></td>


       
       </tr>  
       <tr>
       
       <td ><h5>   N°Inventaire :</h5></td><td colspan="3"><input style="width:100%" class="text-center" type="text" value="<?php if(isset($_POST["nINVT"]))echo $_POST["nINVT"];?>"  name="nINVTtest"  id="tb_n_inventairetest"  readonly></td>

       </tr>  

       
   <input style="width:100%" type="hidden"name="qtesrtCtest"  id="q" readonly>

   
        </table>
        </fieldset>

<fieldset >
        <legend style="text-decoration:underline" >Les Information du Fonctionnaire : </legend>
      <table class="table table-striped"   border="2px">
       <tr>
       <input type="hidden"  name="idFonctionnairetest"    id="idFonctionnairetest"  readonly>
       <td><h5>Nom Compléte  :</h5></td><td><input type="text"  class="text-center" name="nom_fnttest"  id="nom_fnttest"   readonly></td>
       <td><h5>Ser/Dépar  : </h5></td><td><input type="text" class="text-center" name="servicetest" id="serviceidtest"   readonly></td>


       
       </tr> 
     
       <tr>
       
       <td><h5>Email  :</h5></td><td><input  type="text"   class="text-center" name="emailtest"  id="emailtest"  readonly></td>
       <td><h5>Tel  : </h5></td><td><input type="text" class="text-center"   name="teltest" id="teltest"  readonly></td>


       
       </tr> 
        </table>
        </fieldset>
    
        <fieldset >
          
        <legend style="text-decoration:underline" >Les Information de Sortie : </legend>
      <table class="table table-striped"  border="2px">
       <tr>
       
       <td><h5>Date Sortie  : </h5></td><td><input type="text" style="width:100%"  name="datesrttest"  class="text-center" id="datesrttest"  readonly></td>


       
       </tr> 
        </table>
        </fieldset>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" name="confirmation" class="btn btn-info">Confirmer</button>
      </div>
    </div>
  </div>
</div>
</form>
<!--
            <aside class="right">
                <table id="text_fonct">
                   <p style="font-size:20px;font-weight:700;text-decoration:underline"> Les informations des Fonctionnaire</p>
             
                    
                        <tr>
                            <td>Fonctioannaires:</td>
                             <td  colspan="3">
                                
                      
                                 <select   id="tb_fonctionnaire" name="selectFr" tyle="text-align: center;" >
                        <?php  
                        
                            $stmt=$Con->prepare("SELECT *FROM fonctionnaire 
                            ORDER BY nom_fnt ");
                            $stmt->execute(array());
                            $row=$stmt->fetchAll();
                            $count=$stmt->rowCount();
                            
                            if($count>0){

                                foreach($row as $fr){  ?>
                        
                        <option value="<?php echo $fr["Num_Fonctionnaire"] ?>"><?php echo $fr["nom_fnt"]?>  </option>
                        <?php   } 
                          } 
                        ?>
                        
                        </select> 
                                 
                             </td>


                        </tr>
                
        
                    <input type="hidden" name="idFonctionnaire" id="idFonctionnaire" value="<?php if(isset($_POST["idFonctionnaire"]))echo $_POST["idFonctionnaire"];?>" class="tb_service" readonly></td>

                      
                        <tr>
                        <td>Nom : <span style="color:red">*</span></td> <td><input type="text" name="nom_fnt" id="nom_fnt" value="<?php if(isset($_POST["nom_fnt"]))echo $_POST["nom_fnt"];?>" class="tb_service" readonly></td>

                            <td>Ser/Dépar :</td> <td>
                                
                            
                            <input type="hidden" name="Service"  value="<?php if(isset($_POST["Service"]))?>"  class="tb_service"readonly>
                            <input type="text" id="mycatcatcat" >

<?php 
if(isset($_POST["Service"])){
   $stmt=$Con->prepare("SELECT *from departement 
   where NumDepartement = ? 
   LIMIT 1");
   $stmt->execute(array($_POST["Service"]));
   $ro = $stmt->fetch();
   $count=$stmt->rowCount();
 
       ?>
     <input type="hidden"  value="<?php if(isset($ro["Designation_dt"]))echo $ro["Designation_dt"];?>"  id="serviceid" class="tb_service"  readonly>

  <?php 
} ?> 
</td>


                        </tr>
                   
                        <tr>
                        <td>Email :</td> <td><input type="text" name="email" id="email" value="<?php if(isset($_POST["email"]))echo $_POST["email"];?>" class="tb_service" readonly></td>

                            <td>Tel :</td> <td ><input type="text"  name="tel" id="tel" value="<?php if(isset($_POST["tel"]))echo $_POST["tel"];?>" class="tb_service" readonly></td>
   
                        </tr>
                               
                        </table> 

            </aside>
-->
      
<?php 
include("myselectproduit.php");
?>

            </div> 
            </form>
            </div>
<script>


function convert(){
  let current_datetime = new Date()
  let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
  return formatted_date;
}
if(tb_type.value=="non consomable"){
  qtesrtC.disabled="disabled";
  qtesrtC.style.backgroundColor="rgb("+228+","+ 228+","+228+")";
}else{
  qtesrtC.enabled="enabled";
  qtesrtC.style.backgroundColor="#"+000000;

}

     var x = document.getElementById("tb_produit");
                                    var option = document.createElement("option");
                                    option.text = "Produit...";
                                    option.selected=true;
                                    x.add(option); 
                                     
                                   
                                  
                                    
                                    function  leaverequired(){
                                      mytb_qte_sortie.required=false;
                                } 
                              button_valider.onclick=function(){
                                idFonctionnairetest.value = idFonctionnaire.value
                                nom_fnttest.value= nom_fnt.value;
                                serviceidtest.value = serviceid.value;
                                emailtest.value =  email.value;
                                teltest.value = tel.value;
                                today=convert();
                                

                                datesrttest.value=today;
                                
                                button_valider.setAttribute("data-toggle", "modal");
                                button_valider.setAttribute("data-target", "#exampleModal");
                              
                                

                               
                                }

                             
</script>


<?php 
 
}else{
    header("location:index.php");
    exit();
}

include($templates."footer.php");
?>