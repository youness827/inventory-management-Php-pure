<?php 
     try{ 
    $Con = new PDO('mysql:host=localhost;dbname=radid_khomri;charset=utf8','root','');
     }catch(Exception $e){
         die('Erreur: '.$e->getMessage());

     }
   


?>