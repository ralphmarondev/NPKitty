<?php
require_once './connection.php';
header('Content-Type: application/json');

// disable raw PHP error output (avoid HTML in response)
ini_set('display_errors', 0);
error_reporting(E_ALL);

$response = ["success" => "0", "error" => "Unknown error"];

try {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		throw new Exception("Invalid request method");
	}

	$id = intval($_POST['id'] ?? 0);
	$current_password = $_POST['current_password'] ?? '';
	$new_password = $_POST['new_password'] ?? '';
	$confirm_new_password = $_POST['confirm_new_password'] ?? '';

	if (!$id) throw new Exception("Missing user account ID");
	if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
		throw new Exception("All fields are required");
	}
	if ($new_password !== $confirm_new_password) {
		throw new Exception("New passwords do not match");
	}

	$stmt = $mysqli->prepare("SELECT password FROM users WHERE id=? AND is_deleted=0");
	if (!$stmt) throw new Exception("Prepare failed: " . $mysqli->error);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($db_password);
	if (!$stmt->fetch()) throw new Exception("User not found");
	$stmt->close();

	if (!password_verify($current_password, $db_password)) {
		throw new Exception("Current password is incorrect");
	}

	$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
	$stmt = $mysqli->prepare("UPDATE users SET password=? WHERE id=? AND is_deleted=0");
	if (!$stmt) throw new Exception("Prepare failed: " . $mysqli->error);
	$stmt->bind_param("si", $new_password_hash, $id);

	if ($stmt->execute()) {
		$response = ["success" => "1"];
	} else {
		throw new Exception("Database error: " . $stmt->error);
	}

	$stmt->close();
	$mysqli->close();
} catch (Exception $e) {
	$response = ["success" => "0", "error" => $e->getMessage()];
}

echo json_encode($response);
