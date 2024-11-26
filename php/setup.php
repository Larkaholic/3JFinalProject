<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "Dbase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE Dbase (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
users VARCHAR(30) NOT NULL,
appointments VARCHAR(30) NOT NULL,
services VARCHAR(30) NOT NULL,
promotions VARCHAR(30) NOT NULL,
reviews VARCHAR(30) NOT NULLs
)";

if ($conn->query($sql) === TRUE) {
  echo "Table Dbase created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>