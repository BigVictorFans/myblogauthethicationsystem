<?php
   
function connectToDB(){
  //database info
  
  $host = "127.0.0.1";
  $database_name = "myblog";
  $database_user = "root";
  $database_password = "";


  //conect it to the database

  $database = new PDO(
   "mysql:host=$host;
   dbname=$database_name",
   $database_user, 
   $database_password
  );

  return $database;
}
?>