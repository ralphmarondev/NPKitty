<?php
include './connection.php';

$response = ['success' => '0', 'npkData' => []];

$sql = "SELECT id, user_id, pin, plot_id, nitrogen, phosphorus, potassium, moisture, timestamp FROM sensor_data ORDER BY timestamp";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$response['npkData'][] = $row;
	}
	$response['success'] = '1';
}

echo json_encode($response);
$mysqli->close();
