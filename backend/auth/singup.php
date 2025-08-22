<?php
header("Content-Type: application/json");
include("../config/db.php");

$data = json_decode(file_get_contents("php://input"), true);
$name = $data["name"] ?? "";
$email = $data["email"] ?? "";
$phone = $data["phone"] ?? "";
$password = $data["password"] ?? "";

if ($name == "" || $phone == "" || $password == "") {
  echo json_encode(["status" => "error", "message" => "All fields required"]);
  exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo json_encode(["status" => "error", "message" => "Phone already registered"]);
} else {
  $stmt = $conn->prepare("INSERT INTO users (name, phone, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $phone, $hashedPassword);
  if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registered successfully"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Error registering"]);
  }
}
