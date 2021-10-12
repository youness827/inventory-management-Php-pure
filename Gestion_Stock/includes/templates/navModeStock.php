<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $cssFile;?>ionicons.min.css">
    <title><?php  GestionTitlePage(); ?></title>
    <link rel="stylesheet" href="<?php echo $cssFile;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cssFile;?>styl.min.css">
    <link rel="stylesheet" href="<?php echo $cssFile;?>styless.css">
  


  <style>
    *{
      font-family:Arial;
      font-size:17px
    }
   
    .navbar{
      background-color: #001e4f;
    }
    .nav-link,.navbar-brand{
      color: whitesmoke;
      font-size: 150%;
      text-align:center
      
    }
    .navbar-nav > li{
  margin-left:40px;
  margin-right:40px;
  text-align:center
}
    .nav-link:hover,.navbar-brand:hover{
      color: #46487a;
    }

    .dropdown-menu{
      background-color: #dad8fc;
      font-size: 125%;
    }


  </style>
    
</head>


<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="gestionstock.php">Accueil</a>
  <button class="navbar-toggler" style=" background-color: rgb(255, 255, 255);" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span  class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
      <?php 
$stmt=$Con->prepare("SELECT *FROM article e1 
where e1.code_art=e1.code_art
and e1.qte_art<=e1.alert and e1.Type_Art=?");
$stmt->execute(array("consomable"));
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                ?>
        <a class="nav-link" href="StockEpuisée.php">Rupture de stock <span data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Vous avez une pénurie de produit"  style="color:#f6ff00"><?php echo $count;?></span> <span class="sr-only">(current)</span></a>
      </li>
  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Gestion
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="produit.php">Produits</a>
          <a class="dropdown-item" href="Fournisseurs.php">Fournisseurs</a>
          <a class="dropdown-item" href="categorie.php">Catégorie</a>  
          <a class="dropdown-item" href="Fonctionner.php">Fonctionnaire</a>
          <a class="dropdown-item" href="service.php">Département Ou Service</a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" href="lesSorties.php">Les sorties <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Les listes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="allproduits.php">Produits</a>
          <a class="dropdown-item" href="allfonctionaires.php">Fonctionnaire</a>
          <a class="dropdown-item" href="allFournisseurs.php">Fournisseurs</a>
          <a class="dropdown-item" href="depSer.php">Département Ou Service</a>  
          <a class="dropdown-item" href="allCat.php">Catégorie</a>  
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Journal
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        
          <a class="dropdown-item" href="journalFonctionnaires.php">Fonctionnaire</a>
          <a class="dropdown-item" href="lesentreeJr.php">Des entrees</a>
          <a class="dropdown-item" href="sortiesjr.php">Des sorties</a>  
          
          <a class="dropdown-item" href="produitjr.php">Produits</a>  
      </li>

 
    </ul>
 
  </div>
</nav>


<!--

    <div class="wrapper">
      <div class="navbar">
        <ul>
        <li><a href="gestionstock.php" class="a_parent">
            <div class="wrap">
              
              <span class="text">Accueil</span>
            </div>
          </a>
         </li>

          <li><a href="StockEpuisée.php" class="a_parent">
            <div class="wrap">
              
            <?php 
$stmt=$Con->prepare("SELECT *FROM article e1 
where e1.code_art=e1.code_art
and e1.qte_art<=e1.alert and e1.Type_Art=?");
$stmt->execute(array("consomable"));
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
                ?>

<span class="text">Rupture De Stock <span data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Vous avez une pénurie de produit"  style="color:#f6ff00"><?php echo $count;?></span></span>
           <?php

               
            
            ?>

              





            </div>
          </a>
         </li>



          <li><a href="#" class="a_parent">
            <div class="wrap">
              <span class="text">Gestion</span>
            </div>
            </a>
            <div class="dd_menu">
              <ul>
                <li>
                  <a href="produit.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                       Produits
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="Fournisseurs.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                       Fournisseurs
                      </span>
                    </div>
                  </a>
                </li>
             
                <li>
                  <a href="categorie.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                        Catégorie 
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="Fonctionner.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                       Fonctionnaire
                      </span>
                    </div>
                  </a>
                </li> 
                <li>
                  <a href="service.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Départe/Servi
                      </span>
                    </div>
                  </a>
                </li>
              </ul>
            </div> 
          </li>






          
                
          <li><a href="lesSorties.php"class="a_parent">
            <div class="wrap">
              <span class="text">Les Sorties</span>
            </div>
            </a>      
          </li>
          

          <li><a href="#" class="a_parent">
            <div class="wrap">
              <span class="text">Les listes</span>
            </div>
            </a>
            <div class="dd_menu">
              <ul>
                <li>
                  <a href="allproduits.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Produits
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="allfonctionaires.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                     Fonctionnaires
                      </span>
                    </div>
                  </a>
                </li>
             
                <li>
                  <a href="allFournisseurs.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                       Fournisseurs
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="depSer.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Départ/Serv
                      </span>
                    </div>
                  </a>
                </li> 
                <li>
                  <a href="allCat.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Catégories
                      </span>
                    </div>
                  </a>
                </li>
              </ul>
            </div> 
          </li>

          <li><a href="#" class="a_parent">
            <div class="wrap">
              <span class="text">Journal</span>
            </div>
            </a>
            <div class="dd_menu">
              <ul>
                <li>
                  <a href="journalFonctionnaires.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Fonctionnaires
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="lesentreeJr.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Des Entree
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="sortiesjr.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                      Des Sorties
                      </span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="produitjr.php" class="dd_menu_a">
                    <div class="wrap">
                      <span class="text">
                    Produits
                      </span>
                    </div>
                  </a>
                </li> 
              
              </ul>
            </div> 
          </li>


    </div>

-->

