<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
}

// Fetch existing data first
$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE ser_id = ?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header('location: logout.php');
    exit;
}

extract($result); // Now $ser_heading, $ser_id, etc. are available

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['ser_heading'])) {
        $valid = 0;
        $error_message .= "Service heading cannot be empty.<br>";
    }

    // File Upload Handling for Featured Photo
    $path = $_FILES['ser_image']['name'];
    $path_tmp = $_FILES['ser_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif','webp','JPG','JPEG','PNG','GIF','WEBP'])) {
            $valid = 0;
            $error_message .= "Only JPG, JPEG, PNG, or GIF files are allowed for the featured photo.<br>";
        }
    }

    if ($valid == 1) {
        // Handle photo
        if ($path != '') {
            if (!empty($_POST['current_photo']) && file_exists('./uploads/services/' . $_POST['current_photo'])) {
                unlink('./uploads/services/' . $_POST['current_photo']);
            }
            $final_name = 'service-' . $_REQUEST['id'] . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/services/' . $final_name);
        } else {
            $final_name = $_POST['current_photo'];
        }

        // Update database
        $statement = $pdo->prepare("UPDATE tbl_service SET 
            ser_heading = ?, 
            ser_description = ?,
            ser_image = ?,
            ser_alt_tag = ?,
            ser_icon = ?,
            ser_meta_title = ?,
            ser_meta_keyword = ?,
            ser_meta_descr = ?,
            status = ?
            WHERE ser_id = ?");

        $statement->execute([
            $_POST['ser_heading'],
            $_POST['ser_description'],
            $final_name,
            $_POST['ser_alt_tag'],
            $_POST['ser_icon'],
            $_POST['ser_meta_title'],
            $_POST['ser_meta_keyword'],
            $_POST['ser_meta_descr'],
            $_POST['status'],
            $_REQUEST['id']
        ]);

        // Create slug from POST ser_heading (not $ser_heading)
        $slug_text = $_POST['ser_heading'] ?? '';
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($slug_text)));
        $slug_url = rtrim($slug_url, '-');

        // Update slug
        $statement = $pdo->prepare("UPDATE tbl_service SET url = ? WHERE ser_id = ?");
        $statement->execute([$slug_url, $_REQUEST['id']]);

        $success_message = 'Service is updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Service</h1>
    </div>
    <div class="content-header-right">
        <a href="service.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($error_message)): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Service Heading <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_heading" class="form-control" value="<?php echo $ser_heading; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/services/<?php echo $ser_image; ?>" alt="<?php echo $ser_heading; ?>" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo $ser_image; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Change Featured Photo</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Alt Tag Keyword Images * </label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_alt_tag" class="form-control" value="<?php echo $ser_alt_tag; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Current Icon</label>
                            <div class="col-sm-4">
                                <?php if ($ser_icon): ?>
                                    <i class="<?php echo $ser_icon; ?>" style="font-size: 40px;"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Font Awesome Icon Class</label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_icon" class="form-control" value="<?php echo $ser_icon; ?>" placeholder="e.g., fa-solid fa-industry">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo$ser_description; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_title" class="form-control" value="<?php echo$ser_meta_title; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_keyword" class="form-control" value="<?php echo$ser_meta_keyword; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description *</label>
                            <div class="col-sm-8">
                                <textarea name="ser_meta_descr" class="form-control" cols="30" rows="10"><?php echo$ser_meta_descr; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($status == '0') ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == '1') ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
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
