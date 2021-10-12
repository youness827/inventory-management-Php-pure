<?php 
session_start();
$pageTitle='Gestion Des Entrées ';//title pages
   $novabar='';

    include("init.php");
    
    if(isset($_SESSION["nomUtilisateur_admin"])){  

       

      

          if(isset($_POST["valider"])){
           

            if($_POST["typecmd"]!="Type de Bon..." && $_POST["selectFr"]!="Fournisseurs..." && $_POST["selectproduit"]!="Produits..."){
              $stmt=$Con->prepare("INSERT INTO bonentrer (DateEntrer,TypeBon,NuméroCM,id_fr ,if_art,qteentree ) values(?,?,?,?,?,?)");
          
              $stmt->execute(array( htmlspecialchars(trim($_POST["mydate"])) ,htmlspecialchars(trim($_POST["typecmd"])),htmlspecialchars(trim($_POST["textnumComm"])),htmlspecialchars(trim($_POST["selectFr"])),htmlspecialchars(trim($_POST["selectproduit"])),htmlspecialchars(trim($_POST["tb_qteentree"]))));
              $count=$stmt->rowCount();
              if($count>0){
                correct_ms_int_upt_dlt("insert",$count,"lesentrer",1);
              }else{
                echo "<script>Erreur</script>";
              }
            }else{
              echo "<script>alert('Choisir SVP  Type de Bon/Fournisseurs/Produits')</script>";



              
            }
          
          
         
         
          }

          
         ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Les entres</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo $cssFile;?>les_enrtees_style.css">
    </head>
    <body> 
    <?php 
 
 include($templates."navModeStock.php");

?>
<br>
    <br> <br> <br>
        <div class="header" id="myHeader">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                 <h4>Les informations Concernant les Produits Entrer </h4>
                  <table id="text">                  

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
                 </tr>
                 <tr>
                    <td>Qte Entree : <span style="color:red">*</span></td>                  
                      <td>
                          <input type="number" required id="tb_qteentree" min="1" name="tb_qteentree">
                      </td>
                 </tr>
                       <tr>
                           <td>Les Fournisseurs :</td>
                             <td >
                               <div id="prod_">
                               <select name="selectFr" id="myselectselectfr">
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
                             </div>
                           </td>
                         </tr>

                         <tr>
                            <td>Produits :</td>
                    
                   
                              <td >
                                <div id="prod_">
                                <select id="tb_produit"  style="text-align: center;" name="selectproduit"  >
                        <?php  
                            $stmt=$Con->prepare("SELECT *FROM article 
                            ORDER BY designation_art ");
                            $stmt->execute(array());
                            $row=$stmt->fetchAll();
                            $count=$stmt->rowCount();
                            
                            if($count>0){

                                foreach($row as $fr){  ?>
                        
                        <option value="<?php echo $fr["code_art"] ?>"><?php echo $fr["designation_art"]?>  </option>
                        <?php   } 
                          } 
                        ?>
                        
                        </select> 
                              </div>
                            </td>
 
                         </tr>
                         <input type="hidden" id="mydate" name="mydate">
                      </table>   
            </div> 
            <table id="table_button">
                <tr>
                    <td> <input type="submit" value="Valider" id="button" name="valider" > </td>
                    <td> <input type="reset" value="Annuler" id="button" onclick=""> </td>
                </tr>
            </table>
</form>

            <script>
           var myselectbon =  document.getElementById("myselectbon");
                                    var option = document.createElement("option");
                                    option.text = "Type de Bon...";
                                    option.selected=true;
                                    myselectbon.add(option); 

           var fournisseur =  document.getElementById("myselectselectfr");
                                    var option = document.createElement("option");
                                    option.text = "Fournisseurs...";
                                    option.selected=true;
                                    fournisseur.add(option); 
            var tb_produit = document.getElementById("tb_produit");
                                    var option = document.createElement("option");
                                    option.text = "Produits...";
                                    option.selected=true;
                                    tb_produit.add(option); 
          
            function convert(){
  let current_datetime = new Date()
  let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
  return formatted_date; 
}

                      today=convert();
                      mydate.value=today;
            </script>


<?php 
}else{
    header("location:index.php");
    exit();
}

include($templates."footer.php");


?>