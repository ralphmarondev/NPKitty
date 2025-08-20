<?php
include './connection.php';

$userId     = $_POST['userId'] ?? '';   // email
$pin        = $_POST['pin'] ?? '';      // password
$plotId     = $_POST['plotId'] ?? '';
$nitrogen   = $_POST['nitrogen'] ?? '';
$phosphorus = $_POST['phosphorus'] ?? '';
$potassium  = $_POST['potassium'] ?? '';
$moisture   = $_POST['moisture'] ?? '';

$response = ['success' => 0, 'message' => ''];

$stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ? AND password = ? AND is_deleted = 0 LIMIT 1");
$stmt->bind_param("ss", $userId, $pin);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
	$user = $result->fetch_assoc();
	$dbUserId = $user['id'];

	$insert = $mysqli->prepare("INSERT INTO sensor_data (user_id, pin, plot_id, nitrogen, phosphorus, potassium, moisture) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
	$insert->bind_param("sssssss", $userId, $pin, $plotId, $nitrogen, $phosphorus, $potassium, $moisture);

	if ($insert->execute()) {
		$response['success'] = 1;
		$response['message'] = "Data stored successfully";
	} else {
		$response['message'] = "Error inserting data: " . $mysqli->error;
	}
	$insert->close();
} else {
	$response['message'] = "Invalid user credentials";
}

$stmt->close();
$mysqli->close();

echo json_encode($response);
