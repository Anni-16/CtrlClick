<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['client_name'])) {
        $valid = 0;
        $error_message .= "Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_client_logo WHERE client_name=?");
        $statement->execute(array($_POST['client_name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Name already exists<br>";
        }
    }

    if (isset($_FILES['client_image']['name']) && $_FILES['client_image']['name'] != '') {
        $path = $_FILES['client_image']['name'];
        $path_tmp = $_FILES['client_image']['tmp_name'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP'];

        if (!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= "Only JPG, JPEG, PNG, WEBP or GIF files are allowed.<br>";
        } else {
            $final_name = 'client-logo-' . time() . '.' . $ext;
            if (!move_uploaded_file($path_tmp, './uploads/client-logo/' . $final_name)) {
                $valid = 0;
                $error_message .= "Failed to upload the file. Please check the upload directory permissions.<br>";
            }
        }
    } else {
        $valid = 0;
        $error_message .= "You must select a photo.<br>";
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_client_logo (client_name,client_image, status) VALUES (?, ?, ?)");
        $statement->execute(array($_POST['client_name'],$final_name, $_POST['status']));

        $success_message = 'Client Logo is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Client Logo</h1>
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
                                <input type="text" class="form-control" name="client_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Logo <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="client_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
