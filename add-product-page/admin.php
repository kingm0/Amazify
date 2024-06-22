<?php
session_start();
require_once "/opt/lampp/htdocs/Amazify/config.php"; // Adjust path as per your file structure

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login-page/login.html"); // Redirect if not logged in
    exit;
}

// Fetch products from database
$sql = "SELECT id, title, price, description, images, status, created_at FROM products WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']); // Assuming 'email' is used to identify user
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'/>
    <title>Amazify: List Your Products</title>
    <link rel='stylesheet' href='admin-styles.css'/>
</head>
<body>
    <nav>
        <div class="left-links">
            <div class="pfp-placeholder">
                <img src="#" alt="Profile Picture">
            </div>
            <div class="full-name"><?php echo $_SESSION['email']; ?>;</div>
        </div>
        <div class="right-links">
            <button class="list-product-button"><a href="../add-product-page/add-product.html">List Product</a></button>
            <button class="logout-button"><a href="./logout.php">Log Out</a></button>
        </div>
    </nav>

    <header class='header'>
        <h1>Welcome To Amazify!</h1>
        <p><em>Check out the status of your product listings here.</em></p>
    </header>

    <section class="products">
        <?php foreach ($products as $product): ?>
            <div class="card">
                <div class="image-placeholder">
                    <img src="<?php echo $product['images']; ?>" alt="Product Image" width="150" height="150">
                </div>
                <div class="information">
                    <h2 class="product-title"><?php echo $product['title']; ?></h2>
                    <p class="product-price">₹ <?php echo $product['price']; ?></p>
                    <p class="product-description"><?php echo $product['description']; ?></p>
                    <p class="product-status product-<?php echo strtolower($product['status']); ?>"><?php echo $product['status']; ?></p>
                </div>
                <img class="delete-button" src="./svg/delete-outline.svg" alt="Delete Button">
            </div>
        <?php endforeach; ?>
    </section>
    <script src="./admin-main.js"></script>
</body>
</html>
