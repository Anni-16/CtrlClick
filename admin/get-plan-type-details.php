<?php
include('inc/config.php');

$id = $_POST['id'] ?? '';

$stmt = $pdo->prepare("SELECT plan_type_price, plan_type_duration FROM  tbl_plan_type WHERE plan_type_id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        'success' => true,
        'plan_type_price' => $row['plan_type_price'],
        'plan_type_duration' => $row['plan_type_duration']
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>
