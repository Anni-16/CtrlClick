<?php require_once('header.php'); ?>

<?php
// Prevent direct access
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
}


$category_id = $_REQUEST['id'];

// Check if the category exists
$statement = $pdo->prepare("SELECT * FROM tbl_plan_category WHERE plan_cat_id=?");
$statement->execute([$category_id]);
$category = $statement->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    header('location: logout.php');
    exit;
}

// Finally, delete the category record
$statement = $pdo->prepare("DELETE FROM tbl_plan_category WHERE plan_cat_id=?");
$statement->execute([$category_id]);

header('location: plan-category.php');
exit;
?>
