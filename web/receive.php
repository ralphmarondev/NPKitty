<?php
// $servername = "sql313.infinityfree.com";
// $username = "if0_39717260";     
// $password = "AgPV5fsm3HK";
// $dbname = "if0_39717260_npk_db";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "npkitty";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from ESP32 (use null coalescing to avoid undefined index)
$userId     = $_POST['userId'] ?? '';
$pin        = $_POST['pin'] ?? '';
$plotId     = $_POST['plotId'] ?? '';
$nitrogen   = $_POST['nitrogen'] ?? '';
$phosphorus = $_POST['phosphorus'] ?? '';
$potassium  = $_POST['potassium'] ?? '';
$moisture   = $_POST['moisture'] ?? '';

// Insert into database
$sql = "INSERT INTO sensor_data (userId, pin, plotId, nitrogen, phosphorus, potassium, moisture)
        VALUES ('$userId', '$pin', '$plotId', '$nitrogen', '$phosphorus', '$potassium', '$moisture')";

if ($conn->query($sql) === TRUE) {
    echo "Data stored successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
