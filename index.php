<?php

// file: api/index.php
session_start(); // Add this to the top of the file

/**
 * Quick and dirty login function with hard coded credentials (admin/admin)
 * This is just an example. Do not use this in a production environment
 */
function login() {
    if(!empty($_POST['email']) && !empty($_POST['password'])) {
        // normally you would load credentials from a database. 
        // This is just an example and is certainly not secure
        if($_POST['email'] == 'admin' && $_POST['password'] == 'admin') {
            $user = array("email"=>"admin", "firstName"=>"Clint", "lastName"=>"Berry", "role"=>"user");
            $_SESSION['user'] = $user;
            echo json_encode($user);
        }
        else {
            echo '{"error":{"text":"You shall not pass..."}}';
        }
    }
    else {
        echo '{"error":{"text":"Username and Password are required."}}';
    }
}

function logout() {
    unset($_SESSION['user']);
    echo '{"200":"OK"}';
}

/**
 * Authorise function
 */
function authorize($role = "user") {
   
        
        // First, check to see if the user is logged in at all
        if(!empty($_SESSION['user'])) {
            // Next, validate the role to make sure they can access the route
            // We will assume admin role can access everything
            if($_SESSION['user']['role'] == $role || 
                $_SESSION['user']['role'] == 'admin') {
                //User is logged in and has the correct permissions... Nice!
                return true;
            }
            else {
                // If a user is logged in, but doesn't have permissions, return 403
                header('HTTP/1.0 403 Forbidden');
                die();
            }
        }
        else {
            // If a user is not logged in at all, return a 401
            header("HTTP/1.1 401 Unauthorized");
            die();
   
        }
   return true;
}