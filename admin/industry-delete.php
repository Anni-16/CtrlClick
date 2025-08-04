<?php require_once('header.php'); ?>

<?php
// Preventing direct access to this page.
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
}

// Validate the ID and retrieve the corresponding record.
$statement = $pdo->prepare("SELECT * FROM tbl_industry WHERE ind_id=?");
$statement->execute(array($_REQUEST['id']));
$total = $statement->rowCount();

if ($total == 0) {
    header('location: logout.php');
    exit;
}

// Delete the record from the database.
$statement = $pdo->prepare("DELETE FROM tbl_industry WHERE ind_id=?");
$statement->execute(array($_REQUEST['id']));

// Redirect to the technologies list page.
header('location: industry.php');
exit;
?>
