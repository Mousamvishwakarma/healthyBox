<?php
session_start();
header("Content-Type: application/json");
include("../config/db.php");

// JSON input read
$data = json_decode(file_get_contents("php://input"), true);

// Variables with fallback
$phone = $data["phone"] ?? "";
$password = $data["password"] ?? "";

// Validation
if ($phone == "" || $password == "") {
    echo json_encode(["status" => "error", "message" => "Phone & Password required"]);
    exit;
}

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check password
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    echo json_encode(["status" => "success", "message" => "Login successful", "user" => $user['name']]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid phone or password"]);
}
?>
