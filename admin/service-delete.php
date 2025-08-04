<?php
require_once('header.php');

if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    header('location: service.php');
    exit;
}

try {
    // Check if the ID exists in the database
    $statement = $pdo->prepare("SELECT * FROM tbl_service WHERE ser_id=?");
    $statement->execute([$_REQUEST['id']]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        header('location: service.php');
        exit;
    }

    // Delete the main image if it exists
    if (!empty($result['ser_image']) && file_exists('./uploads/services/' . $result['ser_image'])) {
        unlink('./uploads/services/' . $result['ser_image']);
    }


    // Delete the record from the database
    $statement = $pdo->prepare("DELETE FROM tbl_service WHERE ser_id=?");
    $statement->execute([$_REQUEST['id']]);

    header('location: service.php');
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
