<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_portfolio WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	// Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_portfolio WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$p_image = $row['p_image'];
		unlink('./uploads/portfolio/'.$p_image);
	}

	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_portfolio WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_color
	$statement = $pdo->prepare("DELETE FROM tbl_portfolio_technology WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: portfolio.php');
?>