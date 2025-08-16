<?php
$servername = "sql313.infinityfree.com";
$username = "if0_39717260";     
$password = "AgPV5fsm3HK";
$dbname = "if0_39717260_npk_db";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from ESP32
$value1 = $_POST['temperature'] ?? '';
$value2 = $_POST['humidity'] ?? '';

// Insert into database
$sql = "INSERT INTO sensor_data (temperature, humidity) VALUES ('$value1', '$value2')";
if ($conn->query($sql) === TRUE) {
    echo "Data stored successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
