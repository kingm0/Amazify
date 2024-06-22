<?php
// Database configuration
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
<<<<<<< HEAD
require_once "/opt/lampp/htdocs/Amazify/config.php";
=======
require_once "../config.php";
>>>>>>> 9d47b56 (changed file location)
session_start();
// Function to make

// Function to validate email format
function isValidEmail($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['full-name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validate name, email, and password
  if (!empty($name) && isValidEmail($email) && !empty($password)) {
      // Hash the password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Prepare and bind
      $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $hashedPassword);

      // Execute and check for errors
      if ($stmt->execute()) {
<<<<<<< HEAD
          echo "Signup successful! You can now <a href='../login/login.html'>login</a>.";
=======
          echo "Signup successful! You can now <a href='../index.html'>login</a>.";
>>>>>>> 9d47b56 (changed file location)
      } else {
          if ($stmt->errno == 1062) { // Duplicate entry error code
              echo "Error: This email is already registered.";
          } else {
              echo "Error: " . $stmt->error;
          }
      }

      // Close statement
      $stmt->close();
  } else {
      echo "Invalid name, email, or password.";
  }
}