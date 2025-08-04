<?php require_once('header.php'); ?>

<?php
// Preventing direct access to this page.
if (!isset($_REQUEST['id'])) {
    header('location: technology.php');
    exit;
}

// Validate the ID and retrieve the corresponding record.
$statement = $pdo->prepare("SELECT * FROM tbl_technology WHERE tec_id=?");
$statement->execute(array($_REQUEST['id']));
$total = $statement->rowCount();

if ($total == 0) {
    header('location: technology.php');
    exit;
}

// Delete the record from the database.
$statement = $pdo->prepare("DELETE FROM tbl_technology WHERE tec_id=?");
$statement->execute(array($_REQUEST['id']));

// Redirect to the technologies list page.
header('location: technology.php');
exit;
?>
