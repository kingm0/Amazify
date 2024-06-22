<?php
// Database configuration
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "config.php";
session_start();
// Function to validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
$r="";
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate email and password
    if (isValidEmail($email) && !empty($password)) {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        
        // Execute the statement
        $stmt->execute();
        
        // Store the result
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Bind the result variables
            $stmt->bind_result($id, $name, $email, $hashedPassword);
            $stmt->fetch();
            
            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, start a new session
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $r=$email;
                // Redirect to welcome page
                header("Location: add-product-page/admin.php");
                exit;
            } else {
                // Password is incorrect
                echo "Invalid email or password.";
            }
        } else {
            // No user found with this email
            echo "Invalid email or password.";
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Invalid email or password.";
    }
    // $_SESSION['email']=$r;
}

// Close connection
$conn->close();
