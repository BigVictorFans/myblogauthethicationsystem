<?php

    // 1. connect to database
    $database = connectToDB();

    // 2. get all the data from the form using $_POST
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = isset($_POST["password"]) ? $_POST["password"] : ""; 
    $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : ""; 
    $role = isset($_POST["role"]) ? $_POST["role"] : ""; 

    /*
        3. error checking
        - make sure all the fields are not empty 
        - make sure the password is match 
        - make sure the email provided does not exist in the system
    */
    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $_SESSION["error"] = "All fields are required";
        header("Location: /manage-users-add");
        exit;
    } else if ( $password !== $confirm_password ) {
        $_SESSION["error"] = "Password does not match";
        header("Location: /manage-users-add");
        exit;
    } else {
        $user = getUserByEmail ($email);
        if ($user) {
            // TODO: email provided does not exist in the system
            $_SESSION["error"] = "Email provided does not exist in the system";
            // Redirect
            header("Location: /manage-users-add");
            exit;
        } 
    }
    
    // 4. create the user account. You need to assign the role to the user
    /*
        role options:
        - user
        - editor
        - admin

    */
        //step 1 recipe
        $sql = "INSERT INTO users (`name`, `email`, `password`, `role`) VALUES (:name, :email, :password, :role)";
        //step 2 prepare
        $statement = $database->prepare($sql);
        //step 3 let them cook
        $statement->execute([ // add more
            "email" => $email,
            "name" => $name,
            "password" => password_hash( $password, PASSWORD_DEFAULT ),
            "role" => $role,
        ]);
        
        //step 4 display success message
        $_SESSION["success"] = "users account has been created";


    // 5. Redirect back to the /manage-users page
    header("Location: /manage-users"); 
    exit; // meow :3
?>