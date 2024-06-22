<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
<<<<<<< HEAD
header("Location: ../login/login.html");
=======
header("Location: ../index.html");
>>>>>>> 9d47b56 (changed file location)
exit;
