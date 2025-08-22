<?php
include("../config/db.php");

$result = $conn->query("SELECT * FROM meals");
$meals = [];

while ($row = $result->fetch_assoc()) {
    $meals[] = $row;
}

echo json_encode(["status" => "success", "data" => $meals]);
?>
