<?php

try{
    $db= new PDO('mysql:host=localhost;dbname=db_webcom', "root","DZEmpirE3002");
       // $db= new PDO('mysql:host=localhost;dbname=memoire', "root","DZEmpirE3002");

   // $db2= new PDO('mysql:host="https://phpmyadmin.cluster030.hosting.ovh.net";dbname=lqpjitdebatim', "lqpjitdebatim",'lqpjitdebatim');
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);//les noms de champs seront en minuscule
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    /* Ip des utilisateurs */
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    } 

} catch(Exception $e){
    echo "<strong style='color:red;'>Une erreur s'est produite lors de la connection à la base données.</strong>";
    die();
}



?>