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

/* 
    Get user data by email
    Input: email
    Output: user
*/
function getUserByEmail( $email ) {

  // connect to database
  $database = connectToDB();

  // 5.1 SQL
  $sql = "SELECT * FROM users WHERE email = :email";
  // 5.2 prepare
  $query = $database->prepare( $sql );
  // 5.3 execute
  $query->execute([
      "email" => $email
  ]);
  // 5.4 fetch
  $user = $query->fetch(); // return the first row of the list 

  return $user;
}

function isUserLoggedIn() {
  return isset( $_SESSION["user"] );
}

/* 
    check if current user is an admin
*/
function isAdmin() {
  // check if user session is set or not
  if ( isset( $_SESSION["user"] ) ) {
      // check if user is an admin
      if ( $_SESSION["user"]['role'] === 'admin' ) {
          return true;
      } 
  } 
  return false;
}

/* 
    check if current user is an editor or admin
*/
function isEditor() {
  return isset( $_SESSION["user"] ) && ( $_SESSION["user"]['role'] === 'admin' || $_SESSION["user"]['role'] === 'editor' ) ? true : false;
}