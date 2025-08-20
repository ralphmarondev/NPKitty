<?php
include './connection.php';

$response = ['success' => '0', 'residents' => []];

$sql = "SELECT id, userId, pin, plotId, nitrogen, phosporous, potassium, moisture, timestamp FROM sensor_data ORDER BY timestamp";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$response['npkData'][] = $row;
	}
	$response['success'] = '1';
}

echo json_encode($response);
$mysqli->close();
