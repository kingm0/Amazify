<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Result and Prediction</title>
    <!-- Add any additional styles or meta tags as needed -->
</head>
<body>
    <h1>Displaying Result and Prediction</h1>
    <div>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();

        // Check if result and predictionPath are set in session
        if (isset($_SESSION['result']) && isset($_SESSION['predictionPath'])) {
            // $result = 
            // $predictionPath = ;

            $result = $_SESSION['result'];
            $predictionPath = $_SESSION['predictionPath'];
            $uploadFile=$_SESSION['uploadFile'];
            // echo $uploadFile;
            // Output the result array
            echo "<h2>Result:</h2>";
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            echo "<h2>Uploaded Image:</h2>";
            echo "<img src='$uploadFile' alt='Uploaded Image'>";
            // Output the image
            echo "<h2>Prediction Image:</h2>";
            echo "<img src='$predictionPath' alt='Prediction Image'>";
            // Optionally, you can unset the session variables if you no longer need them
            // unset($_SESSION['result']);
            // unset($_SESSION['predictionPath']);
        } else {
            echo "<p>No result or prediction path available.</p>";
        }
        ?>
    </div>
</body>
</html>
