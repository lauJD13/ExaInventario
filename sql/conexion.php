<?php 
   $host = "localhost";
   $usuario = "root";
   $contraseña = "";
   $db = "inventarioexa";

     try{

       $pdo = new  PDO("mysql:host=$host;dbname=$db;charset=utf8",$usuario,$contraseña);
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);


         } catch(PDOException $e){
             echo "Error en la conexión: " . $e->getMessage();
        }

?>