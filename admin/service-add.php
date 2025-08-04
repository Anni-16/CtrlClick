<?php require_once('header.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['ser_heading'])) {
        $valid = 0;
        $error_message .= "Service name can not be empty<br>";
    }

    $path = $_FILES['ser_image']['name'];
    $path_tmp = $_FILES['ser_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'webp'  && $ext != 'JPG' && $ext != 'PNG' && $ext != 'JPEG' && $ext != 'GIF' && $ext != 'WEBP' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a featured photo<br>';
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_service'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $ai_id = $row[10];
        }

        $final_name = 'service-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/services/' . $final_name);

        // Saving data into the main table tbl_service
        $statement = $pdo->prepare("INSERT INTO tbl_service (
            ser_heading,
            ser_image,
            ser_alt_tag,
            ser_icon,
            ser_description,
            ser_meta_title,
            ser_meta_keyword,
            ser_meta_descr,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
        $statement->execute(array(
            $_POST['ser_heading'],
            $final_name,
            $_POST['ser_alt_tag'] ?? '',
            $_POST['ser_icon'] ?? '',
            $_POST['ser_description'] ?? '',
            $_POST['ser_meta_title'],
            $_POST['ser_meta_keyword'],
            $_POST['ser_meta_descr'] ?? '',
            $_POST['status']
        ));

        $ser_id = $pdo->lastInsertId();

        // Create slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($_POST['ser_heading'])));
        $slug_url = rtrim($slug_url, '-');

        $stmt_slug = $pdo->prepare("UPDATE tbl_service SET url = ? WHERE ser_id = ?");
        $stmt_slug->execute([$slug_url, $ser_id]);

        $success_message = 'Service is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Services</h1>
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
                                <input type="text" name="ser_heading" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Service Image <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="ser_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Alt Tag Keyword Image <span>*</span></label>
                            <div class="col-sm-8" style="padding-top:4px;">
                                <input type="text" name="ser_alt_tag" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Font Awesome Icon</label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_icon" class="form-control" placeholder="e.g. fa-brands fa-google">
                                <small class="text-muted">Only enter the class name, e.g., <code>fa-brands fa-google</code></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_title" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_meta_descr" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Services</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>