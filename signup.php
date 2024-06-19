<?php
require_once "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $username = $password = $confirm_password = $address = $gender = $age = "";
$name_err = $username_err = $password_err = $confirm_password_err = $address_err = $gender_err = $age_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if name is empty
    if (empty(trim($_POST['name']))) {
        $name_err = "Name cannot be blank";
    } else {
        $name = trim($_POST['name']);
    }

    // Check if username is empty
    if (empty(trim($_POST['username']))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute the statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST['username']);
                }
            } 
        }
    }
    mysqli_stmt_close($stmt);

    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank.";
        // echo "$password_err";
    } else if (strlen(trim($_POST['password'])) < 8) {
        $password_err = "Password must be at least 8 characters.";
        // echo "$password_err";
    } else {
        $password = trim($_POST['password']);
    }

    // Check for confirm password field
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
        // echo "$confirm_password_err";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            // echo "$confirm_password_err";
        }
    }

    // Check if address is empty
    if (empty(trim($_POST['address']))) {
        $address_err = "Address cannot be blank";
        // echo "$address_err";
    } else {
        $address = trim($_POST['address']);
    }

    // Check if gender is selected
    if (empty($_POST['gender'])) {
        $gender_err = "Please select gender";
        // echo "$gender_err";
    } else {
        $gender = $_POST['gender'];
    }

    // Check if age is empty
    if (empty(trim($_POST['age']))) {
        $age_err = "Age cannot be blank";
        // echo "$age_err";
    } else {
        $age = trim($_POST['age']);
    }

    // If there were no errors, go ahead and insert into database
    if (empty($name_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($address_err) && empty($gender_err) && empty($age_err)) {
        $sql = "INSERT INTO users (name, username, password, address, gender, age) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_username, $param_password, $param_address, $param_gender, $param_age);

            // Set parameters
            $param_name = $name;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_address = $address;
            $param_gender = $gender;
            $param_age = $age;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.html");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Box icons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>
    <!-- Boxicons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <!-- Glide js -->
    <link rel="preconnect" href="https://fonts.googleapis.com">  
     <!-- google fonts-->
    <link rel="stylesheet" href="./css/styles.css" />
    <title>Amazify</title>
  </head>

  <body>
   <!-- Navigation -->
   <header class="header" id="header">
      <!--Nav 1 -->
      <div class="top-nav">
        <div class="container d-flex">
          <p> </p>
          <ul class="d-flex">
            <li><a href="about.html">About Us</a></li>
            <li><a href="contact.html">Terms</a></li>
            <li><a href="contact.html">Contact Us</a></li>
          </ul>
        </div>
      </div>
   <!-- Navigation -->
   <div class="navigation">
    <div class="nav-center container d-flex">
    <a href="index.html" class="logo"><h1>Amazify</h1></a>

      <ul class="nav-list d-flex">
        <li class="nav-item">
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="product2.html" class="nav-link">Check Product</a>
        </li>
        <li class="nav-item">
        <a href="product.html" class="nav-link">Shop</a>
      </li>
        <li class="nav-item">
          <a href="about.html" class="nav-link">About Us</a>
        </li>
        <li class="nav-item">
          <a href="contact.html" class="nav-link">Contact Us</a>
        </li>
      </ul>

      <div class="icons d-flex">
        <a href="login.html" class="icon">
          <i class="bx bx-user"></i>
        </a>
        <a href="" class="icon">
          <i class="bx bx-search"></i>
        </a>
        <div class="icon" >
          <i class="bx bx-heart"></i>
          <span class="d-flex">0</span>
        </div>
        <a href="cart.html" class="icon">
          <i class="bx bx-cart"></i>
          <span class="d-flex">0</span>
        </a>
      </div>

      <div class="hamburger">
        <i class="bx bx-menu-alt-left"></i>
      </div>
    </div>
  </div>
    <!-- Sign Up -->
    <div class="container">
      <div class="login-form">
        <form action="signup.php" method="post">
          <h1>Sign Up</h1>
          <p>
            Please fill in this form to create an account.
          </p>

      <label for="name">Name</label>
      <input type="text" placeholder="Enter your full name" name="name" required />

      <label for="age">Age</label>
      <input type="number" placeholder="Enter your age" name="age" required />

      <div class="gender-container">
        <label style="margin-right: 10px;">Gender</label>
        <input type="radio" id="male" name="gender" value="male" required> <label for="male" style="margin-right: 10px;">Male</label>
        <input type="radio" id="female" name="gender" value="female" required> <label for="female" style="margin-right: 10px;">Female</label>
        <input type="radio" id="other" name="gender" value="other" required> <label for="other">Other</label>
      </div>
            <label for="address">Address</label>
      <input type="text" placeholder="Enter your address" name="address" required />
      <div style="text-align: center ; color: red;">
              <?php 
              if($address_err)
              echo $address_err; ?>

          </div>

      <label for="phone">Phone Number</label>
      <input type="tel" placeholder="Enter your phone number" name="phone" required />

          <label for="email">Email</label>
          <input type="text" placeholder="abc@gmail.com" name="username" required />

          <label for="psw"></label>
          <input
            type="password"
            placeholder="Enter Password"
            name="password"
            required
          />
          <div style="text-align: center ; color: red;">
              <?php 
              if($password_err)
              echo $password_err; ?>
          </div>
          <label for="psw-repeat"></label>
          <input
            type="password"
            placeholder="Confirm Password"
            name="confirm_password"
            required
          />
          <div style="text-align: center ; color: red;">
              <?php 
              if($confirm_password_err)
              echo $confirm_password_err; ?>

          </div>
          <label>
            <input
              type="checkbox"
              checked="checked"
              name="remember"
              style="margin-bottom: 15px"
            />
            Remember me? <p class="forgot">Already a User? <a href="login.html">Login</a></p>
          </label>

          <p>
            By creating an account you agree to our
            <a href="terms.xml">Terms & Privacy</a>.
          </p>

          <div class="buttons">
            <button type="button" class="cancelbtn">Cancel</button>
            <button type="submit" class="signupbtn">Sign Up</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <div class="row">
        <div class="col d-flex">
          <h4>INFORMATION</h4>
          <a href="about.html">About Us</a>
          <a href="contact.html">Contact Us</a>
          <a href="terms.html">Term & Conditions</a>
        </div>
        <div class="col d-flex">
          <h4>USEFUL LINK</h4>
          <a href="">Online Store</a>
          <a href="">Customer Services</a>
          <a href="">FAQs</a>
          <a href="">Top Brands</a>
        </div>
        <div class="col d-flex">
          <span><i class='bx bxl-facebook-square'></i></span>
          <span><i class='bx bxl-instagram-alt' ></i></span>
          <span><i class='bx bxl-github' ></i></span>
          <span><i class='bx bxl-twitter' ></i></span>
          <span><i class='bx bxl-pinterest' ></i></span>
        </div>
      </div>
    </footer>
  

    <!-- Custom Script -->
    <script src="./js/index.js"></script>
  </body>
</html>