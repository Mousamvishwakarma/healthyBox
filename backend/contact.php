<?php
include("config/db.php");

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email = $data->email;
$message = $data->message;

if (!$name || !$email || !$message) {
    echo json_encode(["status" => "error", "message" => "All fields required"]);
    exit;
}

$query = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Message sent"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed"]);
}
?>
