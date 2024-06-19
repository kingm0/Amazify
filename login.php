<?php
require_once "config.php";
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header("location: index.php");
    exit;
}


$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $username_err = "Please enter username or password..";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }
    
    if (empty($username_err)) {
        $sql = "SELECT id, name, username, password, address, gender, age FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $name, $username, $hashed_password, $address, $gender, $age);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, set session variables
                        session_start();
                        $_SESSION["user_id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["name"] = $name;
                        $_SESSION["address"] = $address;
                        $_SESSION["gender"] = $gender;
                        $_SESSION["age"] = $age;
                        $_SESSION["loggedin"] = true;

                        // Redirect user to profile page
                        // header("location: profile.php");
                        // exit;
                    } else {
                        // Password is incorrect
                        $password_err = "Invalid password";
                        if($password_err){
                            header("location: incorrect_pass.html");
                         }
                    }
                }
            } else {
                // Username not found
                $username_err = "Username not found";
                if($password_err){
                    header("location: incorrect_pass.html");
                 }
            }
        } else {
            // Error executing SQL statement
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
