<?php
require_once('header.php');
require_once('inc/config.php');

if (!isset($_GET['package_id']) || !is_numeric($_GET['package_id'])) {
    header("Location: package.php");
    exit;
}

$package_id = $_GET['package_id'];

// Check if the package exists
$stmt = $pdo->prepare("SELECT * FROM tbl_package WHERE package_id = ?");
$stmt->execute([$package_id]);
$package = $stmt->fetch();

if (!$package) {
    $_SESSION['error'] = "Package not found.";
    header("Location: package.php");
    exit;
}

// Delete the package
$stmt = $pdo->prepare("DELETE FROM tbl_package WHERE package_id = ?");
$stmt->execute([$package_id]);

$_SESSION['success'] = "Package deleted successfully.";
header("Location: package.php");
exit;
?>
