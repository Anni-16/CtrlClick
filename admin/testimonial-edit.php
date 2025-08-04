<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['testimonial_name'])) {
        $valid = 0;
        $error_message .= "Name cannot be empty<br>";
    }

    $path = $_FILES['testimonial_image']['name'];
    $path_tmp = $_FILES['testimonial_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP'];
        if (!in_array(strtolower($ext), $allowed_ext)) {
            $valid = 0;
            $error_message .= "You must upload a JPG, JPEG, PNG, or GIF file for the featured photo<br>";
        }
    }

    if ($valid == 1) {
        if ($path == '') {
            // Update without changing the featured photo
            $statement = $pdo->prepare("UPDATE tbl_testimonial SET 
                testimonial_name=?, 
                testimonial_desi=?, 
                testimonial_rating=?, 
                testimonial_content=?, 
                status=? 
                WHERE testimonial_id=?");
            $statement->execute([
                htmlspecialchars($_POST['testimonial_name']),
                htmlspecialchars($_POST['testimonial_desi']),
                htmlspecialchars($_POST['testimonial_rating']),
                htmlspecialchars($_POST['testimonial_content']),
                htmlspecialchars($_POST['status']),
                $_REQUEST['id']
            ]);
        } else {
            // Update with a new featured photo
            if (file_exists('./uploads/testimonial/' . $_POST['current_photo'])) {
                unlink('./uploads/testimonial/' . $_POST['current_photo']);
            }
            $final_name = 'testimonial-' . $_REQUEST['id'] . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/testimonial/' . $final_name);

            $statement = $pdo->prepare("UPDATE tbl_testimonial SET 
                testimonial_name=?, 
                testimonial_desi=?, 
                testimonial_rating=?, 
                testimonial_image=?, 
                testimonial_content=?, 
                status=? 
                WHERE testimonial_id=?");
            $statement->execute([
                htmlspecialchars($_POST['testimonial_name']),
                htmlspecialchars($_POST['testimonial_desi']),
                htmlspecialchars($_POST['testimonial_rating']),
                $final_name,
                htmlspecialchars($_POST['testimonial_content']),
                htmlspecialchars($_POST['status']),
                $_REQUEST['id']
            ]);
        }

        $success_message = 'Testimonial information updated successfully.';
    }
}

if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE testimonial_id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}

foreach ($result as $row) {
    $testimonial_name = htmlspecialchars($row['testimonial_name']);
    $testimonial_desi = htmlspecialchars($row['testimonial_desi']);
    $testimonial_rating = htmlspecialchars($row['testimonial_rating']);
    $testimonial_image = htmlspecialchars($row['testimonial_image']);
    $testimonial_content = htmlspecialchars($row['testimonial_content']);
    $status = htmlspecialchars($row['status']);
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Testimonial</h1>
    </div>
    <div class="content-header-right">
        <a href="testimonial.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 2em;
        color: #ccc;
        cursor: pointer;
    }

    .star-rating input:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #f5c518;
    }
</style>

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
                            <label for="" class="col-sm-3 control-label">Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="testimonial_name" class="form-control" value="<?php echo $testimonial_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Designation <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="testimonial_desi" class="form-control" value="<?php echo $testimonial_desi; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Rating Star <span>*</span></label>
                            <div class="star-rating col-sm-2">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?php echo $i; ?>" name="testimonial_rating" value="<?php echo $i; ?>" <?php echo ($testimonial_rating == $i) ? 'checked' : ''; ?>>
                                    <label for="star<?php echo $i; ?>">&#9733;</label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/testimonial/<?php echo $testimonial_image; ?>" alt="" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo $testimonial_image; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Change Featured Photo</label>
                            <div class="col-sm-4">
                                <input type="file" name="testimonial_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="testimonial_content" class="form-control" cols="30" rows="10"><?php echo $testimonial_content; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
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
