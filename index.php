<?php
    // start session
    session_start();

    require "includes/functions.php";

    /*
      Decide what page to load depending on the url the user visit

      localhost:9000/auth/login -> includes/auth/do_login.php
      localhost:9000/auth/signup -> includes/auth/do_signup.php
      localhost:9000/task/add -> includes/task/add_task.php
      localhost:9000/task/complete -> includes/task/complete_task.php
      localhost:9000/task/delete -> includes/task/delete_task.php
    */
    // global variable $_SERVER
    $path = $_SERVER["REQUEST_URI"];

    // once you figure out the path, then we need to load relevent content based on the path
    switch ($path) {
      // pages routes
      case '/login':
        require "pages/login.php";
        break;
      case '/signup':
        require "pages/signup.php";
        break;
      case '/logout':
        require "pages/logout.php";
        break;
      case '/auth/login':
        require "includes/auth/do-login.php";
        break;
      case '/auth/signup':
        require "includes/auth/do-signup.php";
        break;
      case '/post':
        require "includes/auth/post.php";
        break;
      case '/manage-users':
        require "includes/pages/manage-users.php";
        break;
      case '/manage-users-add':
        require "includes/pages/manage-users-add.php";
        break;
      case '/manage-users-edit':
        require "includes/pages/manage-users-edit.php";
        break;
      case '/task/delete':
        require "includes/task/delete_tasks.php";
        break;
      
      default:
        require "pages/home.php";
        break;
    }
?>