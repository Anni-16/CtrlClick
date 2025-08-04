<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['b_name'])) {
        $valid = 0;
        $error_message .= "Blog name can not be empty<br>";
    }

    $path = $_FILES['b_image']['name'];
    $path_tmp = $_FILES['b_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP'])) {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif or png file<br>';
        }
    }

    if ($valid == 1) {
        if ($path == '') {
            // No new image uploaded
            $statement = $pdo->prepare("UPDATE tbl_blog SET 
                b_name=?, 
                b_description=?,
                b_meta_title=?,
                b_meta_keyword=?,
                b_meta_desc=?,
                status=?
                WHERE b_id=?");
            $statement->execute([
                $_POST['b_name'],
                $_POST['b_description'],
                $_POST['b_meta_title'],
                $_POST['b_meta_keyword'],
                $_POST['b_meta_desc'],
                $_POST['status'],
                $_REQUEST['id']
            ]);
        } else {
            // Image uploaded
            $final_name = 'blog-' . $_REQUEST['id'] . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/blog/' . $final_name);

            $statement = $pdo->prepare("UPDATE tbl_blog SET 
                b_name=?, 
                b_image=?, 
                b_description=?,
                b_meta_title=?,
                b_meta_keyword=?,
                b_meta_desc=?,
                status=?
                WHERE b_id=?");
            $statement->execute([
                $_POST['b_name'],
                $final_name,
                $_POST['b_description'],
                $_POST['b_meta_title'],
                $_POST['b_meta_keyword'],
                $_POST['b_meta_desc'],
                $_POST['status'],
                $_REQUEST['id']
            ]);

            // Create slug from POST b_name (not $ser_heading)
            $slug_text = $_POST['b_name'] ?? '';
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($slug_text)));
            $slug_url = rtrim($slug_url, '-');

            // Update slug
            $statement = $pdo->prepare("UPDATE tbl_blog SET url = ? WHERE b_id = ?");
            $statement->execute([$slug_url, $_REQUEST['id']]);
        }

        $success_message = 'Blog is updated successfully.';
    }
}

// Validation: Redirect if no ID
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Validate ID from database
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE b_id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE b_id=?");
$statement->execute([$_REQUEST['id']]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

$b_name = $row['b_name'];
$b_image = $row['b_image'];
$b_description = $row['b_description'];
$b_meta_title = $row['b_meta_title'];
$b_meta_keyword = $row['b_meta_keyword'];
$b_meta_desc = $row['b_meta_desc'];
$status = $row['status'];
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Blog</h1>
    </div>
    <div class="content-header-right">
        <a href="blog.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($error_message)) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)) : ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Blog Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="b_name" class="form-control" value="<?php echo $b_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/blog/<?php echo $b_image; ?>" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo $b_image; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="b_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo $b_description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_title" class="form-control" value="<?php echo $b_meta_title; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_keyword" class="form-control" value="<?php echo $b_meta_keyword; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description <span>*</span></label>
                            <div class="col-sm-8">
                                <textarea name="b_meta_desc" class="form-control" cols="30" rows="10"><?php echo $b_meta_desc; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($status == '0') echo 'selected'; ?>>No</option>
                                    <option value="1" <?php if ($status == '1') echo 'selected'; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
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