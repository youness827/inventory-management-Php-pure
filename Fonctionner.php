<?php 
session_start();
$pageTitle='Gestion Fonctionnair';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  

       

        if($_SERVER["REQUEST_METHOD"]=="POST"){ 

          
       
            
             
    
            
                     //Insertion fournisseur
                    if(isset($_POST["ajouter"])){
                            
                        

                        if(!empty($_POST["nomfon"])  && !empty( $_POST["selectServ"])  ){
                        //Function Check if exist  in database before insert
                        
            
                                        
                                
                                $stmt=$Con->prepare("INSERT INTO
                                                        fonctionnaire (nom_fnt,email_fnt,tel,Service)
                                                    VALUES 
                                                    (?,?,?,?)");
                                $stmt->execute(array(htmlspecialchars(trim($_POST["nomfon"])),htmlspecialchars(trim($_POST["emailfon"])),htmlspecialchars(trim($_POST["telfon"])),htmlspecialchars(trim($_POST["selectServ"]))));
                                $count=$stmt->rowCount();
                                if($count>0){
                                    correct_ms_int_upt_dlt("insert",$count,"Fonctionner",1);
                                }else{
                                    error_messages("L'insertion de Fonctionnair incompléte!!!","Fonctionner",1); 
                                 }  
                                
                          
                             }else{
                              echo "<script>alert('Merci de remplir les champs * obligatoires');</script>";
                              $nomfon = $_POST["nomfon"];
                      
                              $emailfon = $_POST["emailfon"];
                              $telfon = $_POST["telfon"];
                             
                            } 
                              }//end ajouter 
     
                         
                      if(isset($_POST["Supprimer"])) { //debut suprimer
                           
                    if(isset($_POST["check"])){
                            $stmt=$Con->prepare("DELETE FROM
                            fonctionnaire 
                            WHERE Num_Fonctionnaire = ?");
                            $stmt->execute(array($_POST["Supprimers"]));
                            $count=$stmt->rowCount();
                            if($count>0){ 
                               
                            correct_ms_int_upt_dlt("delete",$count,"Fonctionner",1);
                            }  
                        }
                       else{
                            error_messages("La suppression de Fournisseur incompléte , ( Clicker Sur confirmation!!! )","Fonctionner",1); 
                        }
                    }// end supprimer 
                    
                    if(isset($_POST["modifier"])) { //debut modifier
                           
                        if(isset($_POST["check"])){ 
                            $NomModifier = htmlspecialchars(trim($_POST["NomModifier"]));
                              
                                $EmailModifier =htmlspecialchars( trim($_POST["EmailModifier"]));
                                $TelModifier =htmlspecialchars( trim($_POST["TelModifier"]));
                                $myselectCat =htmlspecialchars( trim($_POST["myselectCat"]));
                             
                                
                                $stmt=$Con->prepare("UPDATE fonctionnaire 
                                SET 
                                nom_fnt = ?, 
                                email_fnt   =   ? ,
                                tel   =   ? ,
                                Service   =   ? 
                                WHERE Num_Fonctionnaire = ?");
                                $stmt->execute(array($NomModifier,$EmailModifier,$TelModifier,$myselectCat,$_POST["Modifiers"]));
                                $count=$stmt->rowCount();
                                if($count>0){ 
                                   
                                correct_ms_int_upt_dlt("update",$count,"Fonctionner",1);
                                } else{
                                    echo "<script>Error Réessayer</script>";
                                } 
                            }
                           else{
                                error_messages("La Modification de Fonctionnair incompléte , ( Clicker Sur confirmation!!! )","Fonctionner",1); 
                            }
                        }// end supprimer






  //recherch
  if(isset($_POST["rechercherFonctio"])){ 
            if(!empty($_POST["inputRechercher"])){
                                $stmt=$Con->prepare("SELECT * FROM
                                 fonctionnaire
                                 WHERE nom_fnt
                                  = ?

                                ");
                                $trim=htmlspecialchars(trim($_POST["inputRechercher"]));
                                $stmt->execute(array($trim));
                                $row=$stmt->fetch();
                                $count =$stmt->rowCount();
                                if($count>0){
                                    echo "<script>alert('Ce Fonctionnair Exist dans la base de données')</script>";

                                }else{
                                    echo '<script>alert("Ce Fonctionnair n\'est Exist Pas dans la base de données")</script>';

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

        <link rel="stylesheet" href="<?php echo $cssFile;?>fonctionnairr.css">
    </head>
    <body> 
    <?php 
 
 include($templates."navModeStock.php");

?>
<br>
    <br> <br> <br>
    <div class="container"> 
        <div class="header" id="myHeader">
            <h4>Les informations Concernant les Fonctionnaires</h4>
          </div>
        <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
        <div class="row">
            <section>
                <table id="text" class="table table-striped">
                 

                   <tr>
                        <td>
                             Nom Compléte :<span style="color:red">*</span>
                        </td>
                        <td>
                             <input type="text" id="tb_nom" name="nomfon" required value="<?php if(isset($nomfon))echo $nomfon;?>">
                        </td>
                        <td>
                             Tel : 
                        </td>

                        <td>
                             <input type="tel" id="tb_tel" name="telfon"  pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}"  placeholder="ex: 00 00 00 00 00" title="Tel : 00 00 00 00 00" value="<?php if(isset($telfon))echo $telfon;?>">
                        </td> 
                   </tr>
                   
                   <tr>
                        <td>
                           Email : 
                        </td>
                        <td>
                           <input type="email" id="tb_email" name="emailfon" placeholder="ex: test@gmail.com" value="<?php if(isset($emailfon))echo $emailfon;?>"  >
                        </td>

                        <td>
                           Service : <span style="color:red">*</span>
                        </td>
                        <td colspan="2">
                        <select id="tb_designation" name="selectServ">
                         
                                <?php  
                                  $stmt=$Con->prepare("SELECT *from departement 
                                   ORDER BY Designation_dt");
                                  $stmt->execute(array());
                                  $rows = $stmt->fetchAll();
                                  $count=$stmt->rowCount();
                                  if($count>0){
                                    foreach($rows as $row){
                                        ?>
                                         <option value="<?php echo $row["NumDepartement"] ?>"><?php echo $row["Designation_dt"] ?></option>
                                        
                                        <?php
                                    }
                                  }
                               

                                ?>

                           
                        </select>
                       </td>

                   </tr>
              
                </table>
            </section>
       
            <aside class="right">
                <table id="table_button tbale-responsive" class="table table-striped">
                    <tr>
                        <td> <input type="submit" value="Ajouter" name="ajouter"id="button" onclick=""> </td>
                   
                     <td>
                        <input type="button" id="button" onclick="" value="Rechercher" data-toggle="modal" data-target="#exampleModal">
                     </td>
                    
                        <td> <input type="button" onclick="anuller()" value="Annuler" id="button" onclick=""> </td>
                    </tr> 
                    
                </table>
            </aside>
                               
            </div>
    <br> 
  
  <table id="table_rechercher" >
      <tr>
          <td>
            <input type="submit" name="rechercher"  id="button" onclick="leaverequired()" class="rechercher" value="Nom Compléte : ">
            
            <select  id="myselectfr" name="selectFr" style="width: 150px;font-weight:600;height:37px">
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


              <!--<input type="text"  id="rechercherss"  name="num_fr"  placeholder="Par : Raison Social ">-->




          </td>
      </tr> 
      
  </table> 
      
    <!-- Modal Rechercher -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fonctionnair: </h5> <br>
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="input-group mb-3">
  <div class="input-group-prepend">
 
    <span class="input-group-text" id="basic-addon1">Par Nom Compléte : </span>
  </div> 
  <input type="text" class="form-control" id="rechercheInput" name="inputRechercher"  aria-describedby="basic-addon1">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit"  name="rechercherFonctio" onclick="leaverequired()" class="btn btn-info">Rechercher</button>
      </div>
    </div>
  </div>
</div>
<!--Rechercher-->
</div>
       
         <h3 style="color:royalblue">Fonctionner:</h3>
   <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
   <table style="text-align: center;" class="table table-info" border="1">
<thead>
<tr class="table-light">
 <th scope="col">N° Fonctionner</th>
 <th scope="col">Nom</th>
 <th scope="col">Email</th>
 <th scope="col">Tél</th>
 <th scope="col">Service</th>
 
 <th scope="col" style="color:red" >Oppérations</th>
 <th scope="col" style="color:red">Confirmation</th>
</tr>
</thead>
<tbody> 
<?php  
    if(isset($_POST['rechercher'])){
      if(!empty($_POST['selectFr']) && $_POST['selectFr']!="Fonctionnaire..."){
         
    $stmt=$Con->prepare("SELECT *FROM fonctionnaire where Num_Fonctionnaire = ?");
    $stmt->execute(array($_POST['selectFr']));
    $row=$stmt->fetchAll();
    $count=$stmt->rowCount();
    
    
    if($count>0){

        foreach($row as $fr){  ?>
       
       <tr class="table-info">
      <td > <input type="text"  size="12" value="<?php echo $fr[0];?>" disabled="disabled"></td>
      <td > <input type="text" name="NomModifier" size="12" value="<?php echo $fr[1];?>" ></td>
      <td > <input type="text" name="EmailModifier" size="12" value="<?php echo $fr[2];?>" ></td>
      <td > <input type="text" name="TelModifier" size="12" value="<?php echo $fr[3];?>" ></td>
      <td >
          
      <select name="myselectCat" style="width:200px;" id="myselect">  
                    <?php 
                    
                        $stmt=$Con->prepare("SELECT 
                                            *FROM departement 
                                             ");
                        $stmt->execute(array());
                        $rrr = $stmt->fetchAll(); 
                        
                        foreach($rrr as $r){ 
                    ?> 
                     <option value="<?php echo $r["NumDepartement"];?>" > <?php echo $r["Designation_dt"];?> </option> 
                     
                     <?php } ?>
                    </select>
      
      <input type="hidden" id="mytextessFour" name="serviceModifier" size="12" value="<?php echo $fr[4];?>" >
    
    
    </td>
      <td><input type="submit"  class="btnFr_modifier_supprimer" size="10" onclick="leaverequired()" name="Supprimer"value="Supprimer">
      <input type="submit"  class="btnFr_modifier_supprimer"size="10" onclick="leaverequired()" name="modifier"value="Modifier">
      </td>
     <td><input type="checkbox" id="checkfr" name="check"></td>
      <input type="hidden"  name="Supprimers" value="<?php echo $fr[0];?>">
      <input type="hidden"  name="Modifiers" value="<?php echo $fr[0];?>">
    </tr>
<?php 
 }
} } else{
    echo "<script>alert('choisir svp un Fonctionnair!!');</script>";
}
  }
 ?>
       
</tbody>
</table> 
</form>
   

         <script>
        


        var x = document.getElementById("myselectfr");
                                    var option = document.createElement("option");
                                    option.text = "Fonctionnaire...";
                                    option.selected=true;
                                    x.add(option);

          

                                    var myselectfr = document.getElementById("myselect");
                                var mytextfour = document.getElementById("mytextessFour");
                                myselectfr.value=mytextfour.value;
                                myselectfr.options.selected=true;


                           function  leaverequired(){
                            tb_nom.required=false;
                            tb_prenom.required=false;
                            
                                }

                                function anuller(){
                                  tb_nom.value="";
                                  tb_prenom.value="";
                                  tb_email.value="";
                                 

                                    option.text = "Fonctionnaire...";
                                    option.selected=true;
                                     tb_nom.focus();
                                   

                                }


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