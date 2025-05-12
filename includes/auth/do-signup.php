<?php

    // Connect to Database
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
        $_SESSION["error"] = "All the fields are required";
        // redirect back to signup page
        header("Location: /signup");
        exit;
    } else if ( $password !== $confirm_password ) {
        $_SESSION["error"] = "Your password is not match";
        // redirect back to signup page
        header("Location: /signup");
        exit;
    } else {
        // check and make sure the email provided is not already exists in the users table
        // get user data by email
        $user = getUserByEmail( $email ); 

        // check if the user exists
        if ( $user ) {
            $_SESSION["error"] = "The email provided already exists in our system";
            // redirect back to signup page
            header("Location: /signup");
            exit;
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

            // 7. set success message
            $_SESSION["success"] = "Account created successfully. Please login with your email and password";

            // 8. redirect to /login
            header("Location: /login");
            exit;
        }

    }