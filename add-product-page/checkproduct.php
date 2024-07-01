<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../config.php";
session_start();

// Function to make a prediction using Roboflow API
function makePrediction1($apiKey, $workspace, $project, $version, $imagePath) {
    // Read the image file
    $imageData = file_get_contents($imagePath);

    // Set up the URL and parameters
    $url = "https://detect.roboflow.com/$project/$version";
    $params = http_build_query([
        'api_key' => $apiKey,
        'confidence' => 10,
        'overlap' => 50,
        'format' => 'image',
        'labels' => 'true',
    ]);

    // Initialize CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url?$params");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'file' => new CURLFile($imagePath)
    ]);

    // Execute CURL request
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Check for CURL errors
    if ($error) {
        return ["error" => $error];
    }

    // Save the prediction image
    $predictionPath = 'uploads/prediction.jpg';
    file_put_contents($predictionPath, $response);

    // Return the path to the prediction image
    return $predictionPath;
}

function makePrediction($apiKey, $workspace, $project, $version, $imagePath) {
    // Read the image file
    $imageData = file_get_contents($imagePath);

    // Set up the URL and parameters
    $url = "https://detect.roboflow.com/$project/$version";
    $params = http_build_query([
        'api_key' => $apiKey,
        'confidence' => 40,
        'overlap' => 30,
        'format' => 'json',
        'labels' => 'true',
    ]);

    // Initialize CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url?$params");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'file' => new CURLFile($imagePath)
    ]);

    // Execute CURL request
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Check for CURL errors
    if ($error) {
        return ["error" => $error];
    }

    // Decode JSON response
    $decodedResponse = json_decode($response, true);
    return $decodedResponse;
}

// Handle form submission
$title = '';
$price = '';
$description = '';
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle product information
    $title = $_POST['full-name'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['abstract'] ?? '';
    
    // Handle image upload and prediction
    if (isset($_FILES['images']) && !empty($_FILES['images']['tmp_name'])) {
        // Save uploaded file
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['images']['name']);
        $_SESSION['uploadFile']=$uploadFile;
        if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadFile)) {
            // Make prediction
            $apiKey = 'h0LatO6wKxgJUq5K6HTI';
            $workspace = 'tanay-bs8l1';
            $project = 'mukul';
            $version = 1;
            $result = makePrediction($apiKey, $workspace, $project, $version, $uploadFile);
            $_SESSION['result']=$result;
            if ($result && isset($result['predictions']) && !empty($result['predictions'])) {
                $predictionPath = makePrediction1($apiKey, $workspace, $project, $version, $uploadFile);
                $_SESSION['predictionPath']=$predictionPath;
                // Calculate the average confidence
                $totalConfidence = 0;
                $numPredictions = count($result['predictions']);
                $containsFakeClass = false;

                foreach ($result['predictions'] as $prediction) {
                    $totalConfidence += $prediction['confidence'];
                    if (strpos(strtolower($prediction['class']), 'fake') !== false) {
                        $containsFakeClass = true;
                    }
                }
                $averageConfidence = $totalConfidence / $numPredictions;

                // Adjust average confidence if fake class is detected
                if ($containsFakeClass) {
                    $averageConfidence *= -1;
                }

                // Determine status based on average confidence
                $status = $averageConfidence > 0.75 ? 'Verified' : 'Rejected';
                // Store product data in session for use in JavaScript
                $_SESSION['new_product'] = [
                    'title' => $title,
                    'price' => $price,
                    'description' => $description,
                    'image' => $uploadFile,
                    'status' => $status
                ];
                $stmt = $conn->prepare("INSERT INTO products (title, price, description, images, status, user) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $title, $price, $description, $uploadFile, $status, $_SESSION['email']);
                $stmt->execute();
                $stmt->close();
                
                // Redirect to admin page
                header("Location: admin.php");
                exit();
            } elseif (isset($result['error'])) {
                echo "Error: " . $result['error'];
            } else {
                echo "No predictions found.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Please upload an image.";
    }
}
?>
