<?php
include './connection.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
$user_id = $_POST['update_user_id'] ?? '';
$plot_id = $_POST['update_plot_id'] ?? '';
$nitrogen = $_POST['update_nitrogen'] ?? '';
$phosphorus = $_POST['update_phosphorus'] ?? '';
$potassium = $_POST['update_potassium'] ?? '';
$moisture = $_POST['update_moisture'] ?? '';

if ($id > 0) {
	$sql = "UPDATE sensor_data 
            SET user_id = ?, plot_id = ?, nitrogen = ?, phosphorus = ?, potassium = ?, moisture = ? 
            WHERE id = ? AND is_deleted = 0 
            LIMIT 1";

	$stmt = $mysqli->prepare($sql);

	if ($stmt) {
		$stmt->bind_param("iisssii", $user_id, $plot_id, $nitrogen, $phosphorus, $potassium, $moisture, $id);

		if ($stmt->execute()) {
			if ($stmt->affected_rows > 0) {
				$response['success'] = 1;
				$response['message'] = "NPK data updated successfully.";
			} else {
				$response['error'] = "No changes were made or record not found.";
			}
		} else {
			$response['error'] = "Execute failed: " . $stmt->error;
		}

		$stmt->close();
	} else {
		$response['error'] = "Prepare failed: " . $mysqli->error;
	}
} else {
	$response['error'] = "Invalid or missing ID.";
}

echo json_encode($response);
$mysqli->close();
