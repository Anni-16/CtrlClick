<?php require_once('header.php'); ?>

<?php
// Check if the ID is set
if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
    header('location: client-logo.php');
    exit;
} else {
    $id = $_REQUEST['id'];
    // Check if the record exists
    $statement = $pdo->prepare("SELECT * FROM tbl_client_logo WHERE client_id=?");
    $statement->execute(array($id));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        header('location: client-logo.php');
        exit;
    }
    $client_name = $result['client_name'];
    $client_image = $result['client_image'];
    $status = $result['status'];
}

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['client_name'])) {
        $valid = 0;
        $error_message .= "Client Logo cannot be empty.<br>";
    } else {
        // Duplicate category name check
        $statement = $pdo->prepare("SELECT * FROM tbl_client_logo WHERE client_name=? AND client_id!=?");
        $statement->execute(array($_POST['client_name'], $id));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Client Name already exists.<br>";
        }
    }

    if ($valid == 1) {
        // Update category image if a new one is uploaded
        if (isset($_FILES['client_image']['name']) && $_FILES['client_image']['name'] != '') {
            $path = $_FILES['client_image']['name'];
            $path_tmp = $_FILES['client_image']['tmp_name'];
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'png', 'jpeg', 'gif'];

            if (!in_array($ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= "Only JPG, JPEG, PNG, or GIF files are allowed.<br>";
            } else {
                // Delete the old image
                if ($client_image != '') {
                    unlink('./uploads/client-logo/' . $client_image);
                }
                $final_name = 'client-logo-' . time() . '.' . $ext;
                move_uploaded_file($path_tmp, './uploads/client-logo/' . $final_name);
            }
        } else {
            $final_name = $client_image; // Use existing image if no new one is uploaded
        }

        // Update category details
        $statement = $pdo->prepare("UPDATE tbl_client_logo SET client_name=?, client_image=?, status=? WHERE client_id=?");
        $statement->execute(array($_POST['client_name'], $final_name,  $_POST['status'], $id));

        $success_message = 'Client Logo updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Client Logo</h1>
    </div>
    <div class="content-header-right">
        <a href="client-logo.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="client_name" value="<?php echo $client_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Current Logo</label>
                            <div class="col-sm-4">
                                <?php if ($client_image != ''): ?>
                                    <img src="./Uploads/client-logo/<?php echo $client_image; ?>" alt="<?php echo $client_name?>" style="width:100px;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">New Logo</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="client_image">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

</section>


<?php require_once('footer.php'); ?>