<?php 

    
    if(isset($_SESSION["nomUtilisateur_admin"])){  

       

        if($_SERVER["REQUEST_METHOD"]=="POST"){ 

                /*Produit info*/
             if ($_POST["selectFr"]){
                    
                   if($_POST["selectFr"]!="Fonctionnaire..."){
                    $selectFr=$_POST["selectFr"];
               
                   
                           
                    $stmt=$Con->prepare("SELECT *from fonctionnaire where Num_Fonctionnaire = ? ");
                    $stmt->execute(array($selectFr));
                    $rows = $stmt->fetch();
                    $count=$stmt->rowCount();
                    if($count>0){
                      $_POST["idFonctionnaire"]=htmlspecialchars(trim($rows["Num_Fonctionnaire"]));
                        $_POST["nom_fnt"]= htmlspecialchars(trim($rows["nom_fnt"]));
                        $_POST["Service"]= htmlspecialchars(trim($rows["Service"]));
                        $_POST["email"]=htmlspecialchars(trim( $rows["email_fnt"]));
                        $_POST["tel"]= htmlspecialchars(trim($rows["tel"]));
                    }
                   
                       
            
         
                
            
                
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    </head>

    <body> 

<br>
    <br> 
    <div class="container">

            <aside class="right">
                <table id="text_fonct" class="table table-striped">
                   <p style="font-size:20px;font-weight:700;text-decoration:underline"> Les informations des Fonctionnaire</p>
             
                    
                        <tr>
                            <td>Fonctioannaires:</td>
                             <td  colspan="3">
                                
                      
                                 <select  onchange="this.form.submit()" style="width:100%" id="tb_fonctionnaire" name="selectFr" tyle="text-align: center;" >
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

<?php 
if(isset($_POST["Service"])){
   $stmt=$Con->prepare("SELECT *from departement 
   where NumDepartement = ? 
   LIMIT 1");
   $stmt->execute(array($_POST["Service"]));
   $ro = $stmt->fetch();
   $count=$stmt->rowCount();
   if(isset($ro["Designation_dt"])){
    $_POST["thisdt"]= $ro["Designation_dt"];
  }

       ?>
     <input type="hidden"  value="<?php if(isset($ro["Designation_dt"]))echo $ro["Designation_dt"];?>"  id="serviceid" class="tb_service"  readonly>

  <?php 
} ?> 
                 <input type="text" id="tb_value_cat"  name="thisdt" value="<?php if(isset( $_POST["thisdt"]))echo  $_POST["thisdt"];?>"   readonly>

</td>


                        </tr>
                   
                        <tr>
                        <td>Email :</td> <td><input type="text" name="email" id="email" value="<?php if(isset($_POST["email"]))echo $_POST["email"];?>" class="tb_service" readonly></td>

                            <td>Tel :</td> <td ><input type="text"  name="tel" id="tel" value="<?php if(isset($_POST["tel"]))echo $_POST["tel"];?>" class="tb_service" readonly></td>
   
                        </tr>
                               
                        </table> 

            </aside>
            
      


    
            </div>
<script>



     
                                     
                                    var y = document.getElementById("tb_fonctionnaire");
                                    var option = document.createElement("option");
                                    option.text = "Fonctionnaire...";
                                    option.selected=true;
                                    y.add(option); 
                                   
                                   
                                    
  
                             
</script>


<?php 
 
}else{
    header("location:index.php");
    exit();
}

include($templates."footer.php");
?>