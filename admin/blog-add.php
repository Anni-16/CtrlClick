<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['b_name'])) {
        $valid = 0;
        $error_message .= "Blog name can not be empty<br>";
    }

    $path = $_FILES['b_image']['name'];
    $path_tmp = $_FILES['b_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'webp' && $ext != 'JPG' && $ext != 'JPEG' && $ext != 'PNG' && $ext != 'GIF' && $ext != 'WEBP') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a featured photo<br>';
    }


    if ($valid == 1) {

        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_blog'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $ai_id = $row[10];
        }

        $final_name = 'Blog-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/blog/' . $final_name);

        //Saving data into the main table tbl_product
        $statement = $pdo->prepare("INSERT INTO tbl_blog (
										b_name,
										b_image,
										b_description,
										b_meta_title,
										b_meta_keyword,
										b_meta_desc,
										status
    									) VALUES (?,?,?,?,?,?,?)");
        $statement->execute(array(
            $_POST['b_name'],
            $final_name,
            $_POST['b_description'],
            $_POST['b_meta_title'],
            $_POST['b_meta_keyword'],
            $_POST['b_meta_desc'],
            $_POST['status']
        ));

         $b_id = $pdo->lastInsertId();

        // Create slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($_POST['b_name'])));
        $slug_url = rtrim($slug_url, '-');

        $stmt_slug = $pdo->prepare("UPDATE tbl_blog SET url = ? WHERE b_id = ?");
        $stmt_slug->execute([$slug_url, $b_id]);

        $success_message = 'Blog is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Blogs</h1>
    </div>
    <div class="content-header-right">
        <a href="blog.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">

                    <p>
                        <?php echo $error_message; ?>
                    </p>
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
                            <label for="" class="col-sm-3 control-label">Blog Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="b_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Image <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="b_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_description" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_title" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_meta_desc" class="form-control" cols="30" rows="10" id="editor2"></textarea>
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
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Blog</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>