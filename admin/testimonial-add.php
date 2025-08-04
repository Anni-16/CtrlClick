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
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP'];
        if (!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select a featured photo<br>';
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_testimonial'");
        $statement->execute();
        $result = $statement->fetch();
        $ai_id = $result['Auto_increment'];

        $final_name = 'testimonial-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/testimonial/' . $final_name);

        $statement = $pdo->prepare("INSERT INTO tbl_testimonial (
            testimonial_name,
            testimonial_desi,
            testimonial_rating,
            testimonial_image,
            testimonial_content,
            status
        ) VALUES (?, ?, ?, ?, ?,?)");
        $statement->execute([
            $_POST['testimonial_name'],
            $_POST['testimonial_desi'],
            $_POST['testimonial_rating'],
            $final_name,
            $_POST['testimonial_content'],
            $_POST['status']
        ]);

        $success_message = 'Testimonial has been added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Testimonial</h1>
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

    .star-rating input:checked~label {
        color: #f5c518;
    }

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
                                <input type="text" name="testimonial_name" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Designation <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="testimonial_desi" class="form-control" placeholder="Enter Designation">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Rating Star <span>*</span></label>
                            <div class="star-rating col-sm-2">
                                <input type="radio" id="star5" name="testimonial_rating" value="5"><label for="star5">&#9733;</label>
                                <input type="radio" id="star4" name="testimonial_rating" value="4"><label for="star4">&#9733;</label>
                                <input type="radio" id="star3" name="testimonial_rating" value="3"><label for="star3">&#9733;</label>
                                <input type="radio" id="star2" name="testimonial_rating" value="2"><label for="star2">&#9733;</label>
                                <input type="radio" id="star1" name="testimonial_rating" value="1"><label for="star1">&#9733;</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Image <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="testimonial_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="testimonial_content" class="form-control" cols="30" rows="10" placeholder="Enter Description" id="wordLimitBox" oninput="limitWords(this, 50)"></textarea>
                                <small><span id="wordCount">0</span>/50 words</small>
                            </div>
                        </div>

                        <script>
                            function limitWords(textarea, maxWords) {
                                const words = textarea.value.trim().split(/\s+/);
                                if (words.length > maxWords) {
                                    textarea.value = words.slice(0, maxWords).join(" ");
                                }
                                document.getElementById("wordCount").innerText = words.slice(0, maxWords).length;
                            }
                        </script>
    
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Testimonial</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>