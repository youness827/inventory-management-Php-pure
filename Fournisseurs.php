<?php 
session_start();
$pageTitle='Gestion Fournisseur';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  

       

        if($_SERVER["REQUEST_METHOD"]=="POST"){ 

          
            
            
             
    
            
                     //Insertion fournisseur
                    if(isset($_POST["ajouter"])){
                            
                        

                        if(!empty($_POST["social__"])){
                        //Function Check if exist  in database before insert
                        
                    
                    $check=RechercheDatabase($Con,"fournisseur","Raison_Social_fr",trim($_POST["social__"]));
                                if($check==false){
                                        
                                $mysocial = htmlspecialchars(trim($_POST["social__"]));
                                $stmt=$Con->prepare("INSERT INTO
                                                        fournisseur (Raison_Social_fr,email_fr,tel_fr,Fax_fr,Rue_Fr,Ville_Fr,Res_Fr,Observation_fr)
                                                    VALUES 
                                                    (?,?,?,?,?,?,?,?)");
                                $stmt->execute(array(htmlspecialchars(trim($_POST["social__"])),htmlspecialchars(trim($_POST["email__"])),htmlspecialchars(trim($_POST["tel_fr__"])),htmlspecialchars(trim($_POST["fax_fr__"])),htmlspecialchars(trim($_POST["rue_fr__"])),htmlspecialchars(trim($_POST["ville_fr__"])),htmlspecialchars(trim($_POST["res_fr__"])),htmlspecialchars(trim($_POST["obsr_fr__"]))));
                                $count=$stmt->rowCount();
                                if($count>0){
                                    correct_ms_int_upt_dlt("insert",$count,"Fournisseurs",1);
                                }else{
                                    error_messages("L'insertion de Fournisseur incompléte!!!","Fournisseurs",1); 
                                 }  
                                }else if($check==true){
                                    echo "<script>alert('Ce Fournisseur Exist Déja dans la base de données');</script>";
                           

                                    $social__ = htmlspecialchars(trim($_POST["social__"]));
                                    $email__ = htmlspecialchars(trim($_POST["email__"]));
                                    $tel_fr__ =htmlspecialchars(trim( $_POST["tel_fr__"]));
                                    $res_fr__ = htmlspecialchars(trim($_POST["res_fr__"]));
                                    $fax_fr__ =htmlspecialchars(trim( $_POST["fax_fr__"]));
                                    $ville_fr__ = htmlspecialchars(trim($_POST["ville_fr__"]));
                                    $rue_fr__ = htmlspecialchars(trim($_POST["rue_fr__"]));
                                    $obsr_fr__ = htmlspecialchars(trim($_POST["obsr_fr__"]));
                                     }
                          
                             }else{
                                echo "<script>alert('Merci de remplir les champs * obligatoires');</script>";
                           

                                $social__ =htmlspecialchars(trim( $_POST["social__"]));
                                $email__ =htmlspecialchars(trim( $_POST["email__"]));
                                $tel_fr__ = htmlspecialchars(trim($_POST["tel_fr__"]));
                                $res_fr__ =htmlspecialchars(trim( $_POST["res_fr__"]));
                                $fax_fr__ = htmlspecialchars(trim($_POST["fax_fr__"]));
                                $ville_fr__ = htmlspecialchars(trim($_POST["ville_fr__"]));
                                $rue_fr__ =htmlspecialchars(trim( $_POST["rue_fr__"]));
                                $obsr_fr__ = htmlspecialchars(trim($_POST["obsr_fr__"]));

                            } 
                              }//end ajouter 

                         
                      if(isset($_POST["Supprimer"])) { //debut suprimer
                           
                    if(isset($_POST["check"])){
                            $stmt=$Con->prepare("DELETE FROM
                            fournisseur 
                            WHERE num_fr = ?");
                            $stmt->execute(array(htmlspecialchars(trim($_POST["Supprimers"]))));
                            $count=$stmt->rowCount();
                            if($count>0){ 
                               
                            correct_ms_int_upt_dlt("delete",$count,"Fournisseurs",1);
                            }  
                        }
                       else{
                            error_messages("La suppression de Fournisseur incompléte , ( Clicker Sur confirmation!!! )","Fournisseurs",1); 
                        }
                    }// end supprimer 
                    if(isset($_POST["modifier"])) { //debut modifier
                           
                        if(isset($_POST["check"])){ 
                            $email = htmlspecialchars(trim( $_POST["email"]));
                                $tel_fr = htmlspecialchars(trim($_POST["tel_fr"]));
                                $res_fr =htmlspecialchars(trim( $_POST["res_fr"]));
                                $fax_fr =htmlspecialchars(trim( $_POST["fax_fr"]));
                                $ville_fr =htmlspecialchars(trim( $_POST["ville_fr"]));
                                $rue_fr =htmlspecialchars(trim( $_POST["rue_fr"]));
                                $obsr_fr =htmlspecialchars(trim( $_POST["obsr_fr"]));
                                $raisonSocial_fr=htmlspecialchars(trim($_POST["social"]));
                                
                                $stmt=$Con->prepare("UPDATE fournisseur 
                                SET 
                                Raison_Social_fr=? , 
                                email_fr =   ? ,
                                tel_fr   =   ? ,
                                Fax_fr   =   ? ,
                                Rue_Fr   =   ? ,
                                Ville_Fr =   ? ,
                                Res_Fr   =   ? ,
                                Observation_fr = ?
                                WHERE num_fr = ?");
                                $stmt->execute(array($raisonSocial_fr,$email,$tel_fr,$fax_fr,$rue_fr,$ville_fr,$res_fr,$obsr_fr,$_POST["Modifiers"]));
                                $count=$stmt->rowCount();
                                if($count>0){ 
                                   
                                correct_ms_int_upt_dlt("update",$count,"Fournisseurs",1);
                                } else{
                                    echo "<script>Error Réessayer</script>";
                                } 
                            }
                           else{
                                error_messages("La Modification de Fournisseur incompléte , ( Clicker Sur confirmation!!! )","Fournisseurs",1); 
                            }
                        }// end supprimer






  //recherch
  if(isset($_POST["rechercherss"])){ 
            if(!empty($_POST["inputRechercher"])){
                $trim = htmlspecialchars(trim($_POST["inputRechercher"]));
                $check = RechercheDatabase($Con,"fournisseur","Raison_Social_fr",$trim);
                if($check){
                    echo "<script>alert('Ce Fournisseur Exist dans la base de données')</script>";
                }else{
                    echo '<script>alert("Ce Fournisseur n\'est Exist Pas dans la base de données")</script>';

                }
            }else{
                echo "<script>alert('Remplire Le champ de Recherche svp')</script>";

            }
    } 

   
        




        
        }
?>
<!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="<?php echo $cssFile;?>style_fichier_responsable.css">
    </head>
    <body> 
    <?php 
 
 include($templates."navModeStock.php");

?>
<br>
    <br> <br> <br>
        <h4>Les informations Concernant les Fournisseurs</h4>  
        
<br>
<div class="container"> 
 <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
        <table id="table" class="table table-striped">
       
            <tr id="tr">
                <td id="td">Raison social : <span style="color:red">*</span> </td>  <td id="td"><input type="text"  required name="social__" style="text-align:center;height:30px" value="<?php if(isset($social__))echo $social__; ?>" autocomplete="false"  id="tb_rason_social"></td>
                <td id="td">Email :    </td>    <td id="td"><input type="email"  placeholder="ex: test@gmail.com" name="email__" style="text-align:center;height:30px"  id="tb_email" value="<?php if(isset($email__))echo $email__; ?>"></td>
            </tr id="tr">

            <tr id="tr">
                <td id="td">N° Tel :  </td>  <td id="td"> <input type="tel" id="tb_tel" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}"  placeholder="ex: 00 00 00 00 00" title="Tel : 00 00 00 00 00" name="tel_fr__"  style="text-align:center;height:30px"   value="<?php if(isset($tel_fr__))echo $tel_fr__; ?>"> </td>
                <td id="td">Responsable : </td>   <td id="td">  <input type="text" id="tb_responsable" style="text-align:center;height:30px" name="res_fr__" value="<?php if(isset($res_fr__))echo $res_fr__; ?>"  > </td>
            </tr>

            <tr id="tr">
                <td id="td">Fax :   </td>  <td id="td"> <input type="tel"  id="tb_fax" style="text-align:center;height:30px" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}"  placeholder="ex: 00 00 00 00 00" title="Tel : 00 00 00 00 00" name="fax_fr__" value="<?php if(isset($fax_fr__))echo $fax_fr__; ?>"  > </td>
                <td id="td">Ville :</td>   <td id="td">  <input type="text" id="tb_ville" style="text-align:center;height:30px" name="ville_fr__"  value="<?php if(isset($ville_fr__))echo $ville_fr__; ?>"  > </td>
            </tr>

            <tr id="tr">
                <td id="td">Adresse :</td>  <td id="td">  <input type="text" id="tb_rue" style="text-align:center;height:30px"  name="rue_fr__" value="<?php if(isset($rue_fr__))echo $rue_fr__; ?>"   > </td>
                <td id="td">Observations :</td> <td id="td">  <input type="text" id="tb_observations" style="text-align:center;height:30px" name="obsr_fr__"  value="<?php if(isset($obsr_fr__))echo $obsr_fr__; ?>"  >  </td>
            </tr>

        </table>
      
 <br>
        <table id="table_button">
            <tr>
                <td>
                    <input type="submit" id="button" class="bttn"name="ajouter" value="Ajouter">
                    <input type="button" id="button" class="bttn"name="Rechercherss" data-toggle="modal" data-target="#exampleModal" value="Rechercher">
                    <input type="button" id="button" onclick="anuller()" name="Annuler"value="Annuler">
                    
                    
                </td>
            </tr>
        </table>
       
  <br> <br>
  
        <table id="table_rechercher">
            <tr>
                <td>
                  <input type="submit" name="rechercher"  id="button" class="rechercher" onclick="leaverequired()"  value="Raison Social : ">
                  
                  <select  id="myselectfr" name="selectFr" style="width: 150px;font-weight:600;height:37px">
                        <?php  
                            $stmt=$Con->prepare("SELECT *FROM fournisseur 
                            ORDER BY Raison_Social_fr ");
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

                    <!--<input type="text"  id="rechercherss"  name="num_fr"  placeholder="Par : Raison Social ">-->




                </td>
            </tr> 
            
        </table> 

<!-- Modal Rechercher -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fournisseur : </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Par Raison Social : </span>
  </div>
  <input type="text" class="form-control" id="rechercheInput" name="inputRechercher" aria-describedby="basic-addon1">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit"  name="rechercherss" onclick="leaverequired()"class="btn btn-info">Rechercher</button>
      </div>
    </div>
  </div>
</div>
<!--Rechercher-->
        <br> 
        </div>
   
        <h3 style="color:royalblue">Fournisseurs:</h3>
   
        <table style="text-align: center;"class="table table-info" border="1">
  <thead>
    <tr class="table-light">
      <th scope="col">Numéro Fournisseur</th>
      <th scope="col">Raison Social</th>
      <th scope="col">Email</th>
      <th scope="col">N° Tel</th>
      <th scope="col">Fax</th> 
      <th scope="col">Rue</th>
      <th scope="col">Ville</th>
      <th scope="col">Responsable</th> 
      <th scope="col">Observations</th> 
      <th scope="col" style="color:red" >Oppérations</th>
      <th scope="col" style="color:red">Confirmation</th>
    </tr>
  </thead>
  <tbody> 
  <?php  
    if(isset($_POST['rechercher'])){
      if(!empty($_POST['selectFr']) && $_POST['selectFr']!="Fournisseurs..."){
         
    $stmt=$Con->prepare("SELECT *FROM fournisseur where num_fr = ?");
    $stmt->execute(array($_POST['selectFr']));
    $row=$stmt->fetchAll();
    $count=$stmt->rowCount();
    
    
    if($count>0){

        foreach($row as $fr){  ?>
       
       <tr class="table-info">
      <td > <input type="text"  size="5" value="<?php echo $fr[0];?>" disabled="disabled"></td>
      <td > <input type="text" name="social" size="12" value="<?php echo $fr[1];?>" ></td>
      <td > <input type="text" name="email" size="12"  value="<?php echo $fr[2];?>" ></td>
      <td > <input type="text" name="tel_fr" size="12" value="<?php echo $fr[3];?>" ></td>
      <td > <input type="text" name="fax_fr" size="12" value="<?php echo $fr[4];?>" ></td>
      <td > <input type="text" name="rue_fr" size="12" value="<?php echo $fr[5];?>" ></td>
      <td > <input type="text" name="ville_fr" size="12" value="<?php echo $fr[6];?>" ></td>
      <td > <input type="text" name="res_fr" size="12" value="<?php echo $fr[7];?>" ></td>
      <td > <input type="text" name="obsr_fr" size="12" value="<?php echo $fr[8];?>" ></td>
      <td><input type="submit"  class="btnFr_modifier_supprimer" size="10"  onclick="leaverequired()" name="Supprimer"value="Supprimer">
      <input type="submit"  class="btnFr_modifier_supprimer"size="10"  onclick="leaverequired()" name="modifier"value="Modifier">
      </td>
     <td><input type="checkbox" id="checkfr" name="check"></td>
      <input type="hidden"  name="Supprimers" value="<?php echo $fr[0];?>">
      <input type="hidden"  name="Modifiers" value="<?php echo $fr[0];?>">
    </tr>
<?php 
 }
} } else{
    echo "<script>alert('choisir svp un Fournisseur!!');</script>";
}
  }
 ?>
          
  </tbody>
</table> 
        
  
     </form>  

     <script> 

    var x = document.getElementById("myselectfr");
                                    var option = document.createElement("option");
                                    option.text = "Fournisseurs...";
                                    option.selected=true;
                                    x.add(option);

                                    function  leaverequired(){
                                        tb_rason_social.required=false;
                                        tb_email.required=false;
                                        tb_tel.required=false;
                                        tb_fax.required=false;
                                }
                                function anuller(){
                                    tb_rason_social.value="";
                                    tb_email.value="";
                                    tb_tel.value="";
                                    tb_fax.value="";
                                    tb_responsable.value="";
                                    tb_ville.value="";
                                    tb_rue.value="";
                                    tb_observations.value="";
                                    option.text = "Fournisseurs...";
                                    option.selected=true;
                                    tb_rason_social.focus();

                                }
    </script> 

<?php 
    }else{
        header("location:index.php");
        exit();
    }
  
    include($templates."footer.php");
    

?>