<?php
$conn=mysqli_connect("localhost","root","");

if ($conn == false)
    dir('Error: Cannot connect');
$query="use ecommerce";
$execute=mysqli_query($conn,$query);
if (!$execute) {
    die("Error: Cannot select database. " . mysqli_error($conn));
}
// else echo "yes";