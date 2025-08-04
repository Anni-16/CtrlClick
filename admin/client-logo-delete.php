
<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_client_logo WHERE client_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $client_image = $result['client_image'];

        if ($client_image!= '' && file_exists('./uploads/client-logo/' . $client_image)) {
            unlink('./uploads/client-logo/' . $client_image);
        }

        $statement = $pdo->prepare("DELETE FROM tbl_client_logo WHERE client_id=?");
        $statement->execute(array($_REQUEST['id']));

        header('location: client-logo.php');
        exit;
    }
}

	// Delete from tbl_top_category
	$statement = $pdo->prepare("DELETE FROM tbl_client_logo WHERE client_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: client-logo.php');
?>