<?php
session_start();
require_once "../config.php"; // Adjust path as per your file structure

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../index.html"); // Redirect if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["product_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Implement your own image validation logic here
            // Placeholder: $isOriginal should be set based on your validation logic
            $isOriginal = true; // Placeholder, implement actual logic

            // Update product image and status
            $status = $isOriginal ? 'Verified' : 'Rejected';

            $sql = "UPDATE products SET images = ?, status = ? WHERE id = ? AND user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssis", $target_file, $status, $productId, $_SESSION['email']);
            $stmt->execute();
            $stmt->close();

            // Redirect to the list product page
            header("Location: admin.php"); // Adjust the path as needed
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    // Display form for the product
    if (isset($_GET['product_id'])) {
        $productId = $_GET['product_id'];
        
        // Fetch product details
        $sql = "SELECT id, title, price, description, images, status FROM products WHERE id = ? AND user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $productId, $_SESSION['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 0 auto;
        }
        label {
            margin-top: 10px;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        input[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Product</h1>
    <?php if (isset($product)): ?>
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <label for="product_title">Title:</label>
            <input type="text" name="product_title" id="product_title" value="<?php echo $product['title']; ?>" disabled>

            <label for="product_price">Price:</label>
            <input type="text" name="product_price" id="product_price" value="<?php echo $product['price']; ?>" disabled>

            <label for="product_description">Description:</label>
            <textarea name="product_description" id="product_description" disabled><?php echo $product['description']; ?></textarea>

            <label for="product_image">Update Image:</label>
            <input type="file" name="product_image" id="product_image" required>

            <input type="submit" value="Update Product">
        </form>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</body>
</html>

