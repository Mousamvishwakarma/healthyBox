<?php
include("../config/db.php");

$data = json_decode(file_get_contents("php://input"));
$name = $data->name;
$phone = $data->phone;
$address = $data->address;
$meal_id = $data->meal_id;

if (!$name || !$phone || !$address || !$meal_id) {
    echo json_encode(["status" => "error", "message" => "All fields required"]);
    exit;
}

$query = "INSERT INTO orders (user_name, phone, address, meal_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $name, $phone, $address, $meal_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Order placed successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Order failed"]);
}
?>
