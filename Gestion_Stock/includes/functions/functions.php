<?php 
      

      
 /*Function Let Title Dynamic  in pages */
                function GestionTitlePage() {
                                global $pageTitle;
                        if(isset($pageTitle)){
                            echo $pageTitle;

                        }else{
                            $pageTitle="Gestion Stock";
                            echo $pageTitle;
                        }

                }
            
  /*Function all correct in dataBase insert update delete  */
  /*version : v1.0*/ 
          function correct_ms_int_upt_dlt($opperation,$count,$directionPage,$seconde){
              
            
            echo"<div class='container'>"; 
            echo "<br><br><br><br><br><br>";
            if($opperation=="update"){
                echo "<div class='alert alert-success'>Cool:  $count  Ligne(s) bien Modifier</div>";
                echo "</div>";
            }else if($opperation=="insert"){
                echo "<div class='alert alert-success'>Coll:  $count Ligne(s) bien Insérer</div>";
                echo "</div>";
            }else if($opperation=="delete"){
                echo "<div class='alert alert-success'>Coll: $count  Ligne(s) bien supprimer</div>";
                echo "</div>";
            }
           echo "<div class='container'>";
            echo "<div class='alert alert-info'> Revenire a la page précédent aprés  $seconde Seconde</div>";
            echo "</div>";
            header("refresh:$seconde;url=$directionPage.php");
            exit();
          }

  /*Function Erros messages  in pages*/
  /*version:1.0*/ 
  function error_messages($typeErreur,$directionPage,$seconde){
            
    echo"<div class='container'>"; 
    echo "<br><br><br><br><br><br>";
    
        echo "<div class='alert alert-danger'>Error: $typeErreur</div>";
        echo "</div>";
  
    
   echo "<div class='container'>";
    echo "<div class='alert alert-info'> Revenire a la page précédent aprés  $seconde Seconde</div>";
    echo "</div>";
    header("refresh:$seconde;url=$directionPage.php");
    exit();
  }
  /*FONCTION RECHERCHE  EXIST  n'exit pas*/
  /**v:1.0*/

  function RechercheDatabase($Con,$table,$condition,$valCondition){

    $stmt=$Con->prepare("SELECT * FROM $table where $condition = ?");
    $stmt->execute(array($valCondition));
    $rows = $stmt->rowCount();
    if($rows>0){
        return true;
    }else{
        return false;
    }



  } 
 
?>