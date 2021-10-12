<?php 
   include('connect.php');//onnection To dataBase gs_

    // Router Initi

    $templates = 'Gestion_Stock/includes/templates/';//path Templates
    $funct = 'Gestion_Stock/includes/functions/';//path functions
    $cssFile = 'Gestion_Stock/layouts/css/';//path css files
    $images = 'Gestion_Stock/layouts/images/';//path images 
    $js_Files ='Gestion_Stock/layouts/js/';

   //Includes This Files
   include($funct."functions.php");
    include($templates."header.php");
   

   
   if(!isset($novabar))
   {
    include($templates."nav.php");
   }






?> 
