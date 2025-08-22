<?php
header("Content-Type: application/json");
include("../config/db.php");

$data = json_decode(file_get_contents("php://input"), true);
$phone = $data["phone"] ?? "";

if ($phone == "") {
  echo json_encode(["status" => "error", "message" => "Phone number required"]);
  exit;
}

$sql = "SELECT o.id, o.user_name, o.address, m.name AS meal_name, o.status, o.order_time
        FROM orders o
        JOIN meals m ON o.meal_id = m.id
        WHERE o.phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
  $orders[] = $row;
}

echo json_encode(["status" => "success", "data" => $orders]);
?>
