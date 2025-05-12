<?php

    // 1. connect to Database
    $database = connectToDB();

    // 2. get the data from the form 
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $id = $_POST["id"];

    // 3. check for error
    if ( empty( $password ) || empty( $confirm_password ) ) {
        $_SESSION["error"] = "Please fill up all the fields";
        header("Location: /manage-users-changepwd?id=" . $id); // pass in the id to the url
        exit;
    }
    else if ( $password !== $confirm_password ) {
        $_SESSION["error"] = "Password is not match";
        header("Location: /manage-users-changepwd?id=" . $id); // pass in the id to the url
        exit;
    }
    
    // 4. update password for the user
    $sql = "UPDATE users set password = :password WHERE id = :id";
    $query = $database->prepare( $sql );
    $query->execute([
        "password" => password_hash( $password, PASSWORD_DEFAULT ),
        "id" => $id
    ]);

    // 5. redirect
    $_SESSION["success"] = "User's password has been updated";
    header("Location: /manage-users");
    exit;