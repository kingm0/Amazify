<?php
session_start();
require_once "../config.php"; // Adjust path as per your file structure

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../index.html"); // Redirect if not logged in
    exit;
}

// Fetch user data from the database
$email = $_SESSION['email'];
$sql = "SELECT name, email FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch product counts and calculate credibility score
$sql_products = "SELECT COUNT(*) as total, SUM(status = 'Verified') as verified FROM products WHERE user = ?";
$stmt_products = $conn->prepare($sql_products);
$stmt_products->bind_param("s", $email);
$stmt_products->execute();
$result_products = $stmt_products->get_result();
$product_counts = $result_products->fetch_assoc();
$stmt_products->close();

$total_products = $product_counts['total'];
$verified_products = $product_counts['verified'];
$credibility_score = ($total_products > 0) ? ($verified_products / $total_products) * 100 : 0;
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'/>
    <title>User Profile</title>
    <link rel='stylesheet' href='admin-styles.css'/>
    <style>
        .profile-container {
            background-color: #F6F7F8;
            border: 1px solid #D6D9DC;
            border-radius: 3px;
            width: 50%;
            padding: 40px;
            margin: 20px auto;
        }

        .profile-container h2 {
            font-size: 35px;
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-container p {
            font-size: 18px;
            margin: 10px 0;
        }
        .d1{
        display: inline-flex;
        
        }
         .profile-image {
            width: 150px;
            height: 150px;
            background-color: #ccc;
            border-radius: 50%;
            margin-bottom: 20px;
            margin-left:50%;
        }
                .profile-button {
    background-color: #007bff;
}

.profile-button:hover {
    background-color: #0056b3;
}

.profile-button:active {
    background-color: #004085;
}

        
    </style>
</head>
<body>
 <nav>
        <div class="left-links">
            <div class="pfp-placeholder">
                <img src="#" alt="Profile Picture">
            </div>
            <div class="full-name"><?php echo $_SESSION['email']; ?></div>
        </div>
        <div class="right-links">
          <button class="profile-button"><a href="user-profile.php">Profile</a></button>
            <button class="list-product-button"><a href="../add-product-page/add-product.html">List Product</a></button>
            <button class="logout-button"><a href="logout.php">Log Out</a></button>
        </div>
    </nav>
    <div class="profile-container">
        <h2>User Profile</h2>
        </div>
            <div class="profile-container d1">
            <div class="d2">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Credibility Score:</strong> <?php echo number_format($credibility_score, 2); ?>%</p>
        <p><strong>Products Listed:</strong> <?php echo $total_products; ?></p>
        </div>
                <div class="profile-image d1"></div>

    </div>
</body>
</html>

