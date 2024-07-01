<?php
session_start();
require_once "../config.php"; // Adjust path as per your file structure

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['loggedin'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }

    // Get product ID from request
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['id'];

    if (empty($productId)) {
        echo json_encode(['success' => false, 'message' => 'Product ID is required']);
        exit;
    }

    // Prepare and execute delete statement
    $sql = "DELETE FROM products WHERE id = ? AND user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $productId, $_SESSION['email']);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
