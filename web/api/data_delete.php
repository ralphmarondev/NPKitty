<?php
include './connection.php';
header('Content-Type: application/json');

// $response = ["success" => 0, "message" => ""];

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data['id'] ?? 0);

    if ($id > 0) {
        $sql = "UPDATE sensor_data SET is_deleted = 1 WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response["success"] = 1;
                    $response["message"] = "NPK data deleted successfully.";
                } else {
                    $response["message"] = "No record found or already deleted.";
                }
            } else {
                $response["message"] = "Execute failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response["message"] = "Prepare failed: " . $mysqli->error;
        }
    } else {
        $response["message"] = "Invalid ID.";
    }
} catch (Exception $e) {
    $response["message"] = "Exception: " . $e->getMessage();
}

echo json_encode($response);
$mysqli->close();
