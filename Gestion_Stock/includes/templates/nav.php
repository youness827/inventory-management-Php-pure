<div class="nav">
            <div class="logo"> 
               <img src="<?php echo $images;?>hy.png" >
            </div>
              
            <div class="links">
                <a href="modeStock.php" class="mainlink">

                
              
              <?php 
  $stmt=$Con->prepare("SELECT *FROM article e1 
  where e1.code_art=e1.code_art
  and e1.qte_art<=e1.alert and e1.Type_Art=?");
  $stmt->execute(array("consomable"));
          $rows = $stmt->fetchAll();
          $count=$stmt->rowCount();
                  ?>
  
  <span class="text">Mode Stock &nbsp;<span data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Vous avez une pénurie de produit" style="color:#ff0000;backgroud-color:"><?php echo $count;?></span></span>
             <?php
  
                 
              
              ?>
  
        

                </a>
               
                
                <a href="LogOut.php">Se Déconnecter </a>
            </div>
        </div>  

       