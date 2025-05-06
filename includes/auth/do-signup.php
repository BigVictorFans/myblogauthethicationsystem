<?php
$database = connectToDB();


   // 3. get the data from the sign up form
   $name = $_POST["name"];
   $email = $_POST["email"];
   $password = $_POST["password"];
   $confirm_password = $_POST["confirm_password"];

   // 4. check for error
   if ( 
       empty( $name ) || 
       empty( $email ) || 
       empty( $password ) || 
       empty( $confirm_password )
   ) {
       echo "All the fields are required";
   } else if ( $password !== $confirm_password ) {
       echo "Your password is not match";
   } else {
       // check and make sure the email provided is not already exists in the users table
       // get user data by email
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

       // check if the user exists
       if ( $user ) {
           echo "The email provided already exists in our system";
       } else {
           // 6. create a user account
           // 6.1 SQL command
           $sql = "INSERT INTO users (`name`,`email`,`password`) VALUES (:name, :email, :password)";
           // 6.2 prepare
           $query = $database->prepare( $sql );
           // 6.3 execute
           $query->execute([
               "name" => $name,
               "email" => $email,
               "password" => password_hash( $password, PASSWORD_DEFAULT )
           ]);

           // 6. redirect to login.php
           header("Location: /login");
           exit;
       }

   }