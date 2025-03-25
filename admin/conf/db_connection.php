<?php
$servername = "localhost";  // Change this to your server if not localhost
$username = "raj@simform";         // Replace with your MySQL username
$password = "Raj123";             // Replace with your MySQL password
$dbname = "flipkart_db";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>