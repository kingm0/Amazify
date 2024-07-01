<?php
session_start();
require_once "../config.php"; // Adjust path as per your file structure

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../index.html"); // Redirect if not logged in
    exit;
}

// Fetch products from the database
$sql = "SELECT id, title, price, description, images, status, created_at FROM products WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']); // Assuming 'email' is used to identify the user
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Count verified and rejected products
$sql_verified = "SELECT COUNT(*) as verified_count FROM products WHERE user = ? AND status = 'Verified'";
$stmt_verified = $conn->prepare($sql_verified);
$stmt_verified->bind_param("s", $_SESSION['email']);
$stmt_verified->execute();
$result_verified = $stmt_verified->get_result();
$verified_count = $result_verified->fetch_assoc()['verified_count'];
$stmt_verified->close();

$sql_rejected = "SELECT COUNT(*) as rejected_count FROM products WHERE user = ? AND status = 'Rejected'";
$stmt_rejected = $conn->prepare($sql_rejected);
$stmt_rejected->bind_param("s", $_SESSION['email']);
$stmt_rejected->execute();
$result_rejected = $stmt_rejected->get_result();
$rejected_count = $result_rejected->fetch_assoc()['rejected_count'];
$stmt_rejected->close();

$total_products = count($products);
$verified_percentage = ($total_products > 0) ? ($verified_count / $total_products) * 100 : 0;
$rejected_percentage = ($total_products > 0) ? ($rejected_count / $total_products) * 100 : 0;
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'/>
    <title>Amazify: List Your Products</title>
    <link rel='stylesheet' href='admin-styles.css'/>
    <style>
        .image-placeholder img {
            width: 100px;
            height: 100px;
        }
        .appeal-button {
            background-color: red;
            color: white;
            border: 2px solid black;
            padding: 10px;
            cursor: pointer;
            height: 40px;
            width: 80px;
            font-weight: 700;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            align-self: flex-end;
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
.btn2{
margin-bottom: 10px;
height: 50px;
}

    </style>
</head>
<body>
    <nav>
        <div class="left-links">
            <div class="pfp-placeholder">
                <img src="./svg/pfp.svg" alt="Profile Picture">
            </div>
            <div class="full-name"><?php echo $_SESSION['email']; ?></div>
        </div>
        <div class="right-links">
          <button class="profile-button"><a href="user-profile.php">Profile</a></button>
            <button class="list-product-button"><a href="../add-product-page/add-product.html">List Product</a></button>
            <button class="logout-button"><a href="logout.php">Log Out</a></button>
        </div>
    </nav>

    <header class='header'>
        <h1>Welcome To Amazify!</h1>
        <p><em>Check out the status of your product listings here.</em></p>
        <p>Your Verified Products: <?php echo number_format($verified_percentage, 2); ?>%</p>
        <p>Your Rejected Products: <?php echo number_format($rejected_percentage, 2); ?>%</p>
    </header>

    <section class="products">
        <?php foreach ($products as $product): ?>
            <div class="card" data-id="<?php echo $product['id']; ?>">
                <div class="image-placeholder">
                    <img src="<?php echo $product['images']; ?>" alt="Product Image">
                </div>
                <div class="information">
                    <h2 class="product-title"><?php echo $product['title']; ?></h2>
                    <p class="product-price">₹ <?php echo $product['price']; ?></p>
                    <p class="product-description"><?php echo $product['description']; ?></p>
                    <p class="product-status product-<?php echo strtolower($product['status']); ?>"><?php echo $product['status']; ?></p>
                </div>
                <div class="button-container">
                    <?php if (strtolower($product['status']) == 'rejected'): ?>
                        <button class="appeal-button" style="background-color: #e74c3c" onclick="appealProduct(<?php echo $product['id']; ?>)">Appeal</button>
                    <?php endif; ?>
                    <img class="delete-button btn2" src="./svg/pencil.svg" alt="Delete Button">
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <script>
        function appealProduct(productId) {
            // Implement the appeal functionality here
            alert('Appeal for product ID: ' + productId);
        }
    </script>
    <script src="./admin-main.js"></script>
</body>
</html>

