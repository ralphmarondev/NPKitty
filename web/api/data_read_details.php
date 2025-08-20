<?php
include './connection.php';
header('Content-Type: application/json');

$response = ['success' => 0, 'npkData' => null];
$id = intval($_GET['id'] ?? ($POST['id']) ?? 0);

if ($id > 0) {
	$sql = "SELECT id, user_id, pin, plot_id, nitrogen, phosphorus, potassium, moisture, timestamp 
            FROM sensor_data 
            WHERE id = ? AND is_deleted = 0 
            LIMIT 1";

	$stmt = $mysqli->prepare($sql);
	if ($stmt) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			$response['success'] = '1';
			$response['npkData'] = $row;
		} else {
			$response['error'] = "Record not found";
		}

		$stmt->close();
	} else {
		$response['error'] = "Prepare failed: " . $mysqli->error;
	}
} else {
	$response['error'] = "Missing or invalid ID";
}

echo json_encode($response);
$mysqli->close();
