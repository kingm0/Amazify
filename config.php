<?php
$conn=mysqli_connect("localhost","root","");

if ($conn == false)
    dir('Error: Cannot connect');
$query="use Amazify";
$execute=mysqli_query($conn,$query);
if (!$execute) {
    die("Error: Cannot select database. " . mysqli_error($conn));
}

