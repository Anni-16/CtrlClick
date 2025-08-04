<?php require_once('header.php'); ?>

<?php

if (isset($_POST['form_about'])) {
    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if (empty($_POST['content'])) {
        $valid = 0;
        $error_message .= 'Content can not be empty<br>';
    }

    // Image 1
    $about_image_1 = '';
    $path1 = $_FILES['about_image_1']['name'];
    $path_tmp1 = $_FILES['about_image_1']['tmp_name'];
    $ext1 = pathinfo($path1, PATHINFO_EXTENSION);

    if ($path1 != '') {
        if (!in_array($ext1, ['jpg', 'png', 'jpeg', 'gif','webp','JPG','JPEG','PNG','GIF','WEBP'])) {
            $valid = 0;
            $error_message .= 'Image 1 must be jpg, jpeg, gif, or png<br>';
        } else {
            $about_image_1 = 'about1-' . time() . '.' . $ext1;
            move_uploaded_file($path_tmp1, './uploads/about/' . $about_image_1);
        }
    }

    // Image 2
    $about_image_2 = '';
    $path2 = $_FILES['about_image_2']['name'];
    $path_tmp2 = $_FILES['about_image_2']['tmp_name'];
    $ext2 = pathinfo($path2, PATHINFO_EXTENSION);

    if ($path2 != '') {
        if (!in_array($ext2, ['jpg', 'png', 'jpeg', 'gif','webp','JPG','JPEG','PNG','GIF','WEBP'])) {
            $valid = 0;
            $error_message .= 'Image 2 must be jpg, jpeg, gif, or png<br>';
        } else {
            $about_image_2 = 'about2-' . time() . '.' . $ext2;
            move_uploaded_file($path_tmp2, './uploads/about/' . $about_image_2);
        }
    }

    if ($valid == 1) {
        if ($about_image_1 != '' && $about_image_2 != '') {
            // Both images uploaded
            $statement = $pdo->prepare("UPDATE tbl_about SET heading=?, sub_heading=?, content=?, description =?,alt_tag=?, alt_tag_2=?, our_mission=?, our_vision=?, meta_title=?, meta_keyword=?, meta_desc=?, about_image_1=?, about_image_2=? WHERE id=1");
            $statement->execute([
                $_POST['heading'], $_POST['sub_heading'], $_POST['content'],  $_POST['description'], $_POST['alt_tag'], $_POST['alt_tag_2'], $_POST['our_mission'], $_POST['our_vision'],
                $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_desc'],
                $about_image_1, $about_image_2
            ]);
        } elseif ($about_image_1 != '') {
            // Only image 1 uploaded
            $statement = $pdo->prepare("UPDATE tbl_about SET heading=?, sub_heading=?, content=?, description =?,alt_tag=?, alt_tag_2=?, our_mission=?, our_vision=?, meta_title=?, meta_keyword=?, meta_desc=?, about_image_1=? WHERE id=1");
            $statement->execute([
                $_POST['heading'], $_POST['sub_heading'], $_POST['content'], $_POST['description'], $_POST['alt_tag'], $_POST['alt_tag_2'], $_POST['our_mission'], $_POST['our_vision'],
                $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_desc'],
                $about_image_1
            ]);
        } elseif ($about_image_2 != '') {
            // Only image 2 uploaded
            $statement = $pdo->prepare("UPDATE tbl_about SET heading=?, sub_heading=?, content=?,  description =?, alt_tag=?, alt_tag_2=?, our_mission=?, our_vision=?, meta_title=?, meta_keyword=?, meta_desc=?, about_image_2=? WHERE id=1");
            $statement->execute([
                $_POST['heading'], $_POST['sub_heading'], $_POST['content'], $_POST['description'], $_POST['alt_tag'], $_POST['alt_tag_2'], $_POST['our_mission'], $_POST['our_vision'],
                $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_desc'],
                $about_image_2
            ]);
        } else {
            // No image uploaded
            $statement = $pdo->prepare("UPDATE tbl_about SET heading=?, sub_heading=?, content=?, description =?, alt_tag=?, alt_tag_2=?, our_mission=?, our_vision=?, meta_title=?, meta_keyword=?, meta_desc=? WHERE id=1");
            $statement->execute([
                $_POST['heading'], $_POST['sub_heading'], $_POST['content'],  $_POST['description'],$_POST['alt_tag'], $_POST['alt_tag_2'], $_POST['our_mission'], $_POST['our_vision'],
                $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_desc']
            ]);
        }

        $success_message = 'About Page Information is updated successfully.';
    }
}

// About content End

// Contact Content Start
if (isset($_POST['form_contact'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }
    if ($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_contact SET heading=?,address=?,phone_1=?,phone_2=?,email_id_1=?,email_id_2=?,email_id_3=?,email_id_4=?,map_url=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['address'], $_POST['phone_1'], $_POST['phone_2'], $_POST['email_id_1'], $_POST['email_id_2'], $_POST['email_id_3'], $_POST['email_id_4'], $_POST['map_url']));
    }

    $success_message = 'Contact Page Information is updated successfully.';
}

// Contact Content End

// Trems & Condition Content Start
if (isset($_POST['form_faq'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_term_conditions SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Trem & Conditions Page Information is updated successfully.';
}

// Trems & Condition Content End

// Privacy & Ploicy Content Start
if (isset($_POST['form_privacy'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_privacy_policy SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Privacy & Ploicy Page Information is updated successfully.';
}

// Privacy & Ploicy Content End

// Refund & Ploicy Content Start
if (isset($_POST['form_refund'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_refund_ploicy SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Refund & Ploicy Page Information is updated successfully.';
}

// Refund & Ploicy Content End

// Disclaimer Content Start
if (isset($_POST['form_disclaimer'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_disclaimer SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Disclaimer Page Information is updated successfully.';
}

// Disclaimer Content End

?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Page CMS Manage</h1>
    </div>
</section>

<section class="content" style="min-height:auto;margin-bottom: -30px;">
    <div class="row">
        <div class="col-md-12">
            <?php if ($error_message) : ?>
                <div class="callout callout-danger">
                    <p> <?php echo $error_message; ?> </p>
                </div>
            <?php endif; ?>

            <?php if ($success_message) : ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">About Us</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Contact</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Terms & Condition</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Privacy & Ploicy</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Refund & Ploicy</a></li>
                    <li><a href="#tab_6" data-toggle="tab">Disclaimer</a></li>

                </ul>

                <!-- About us Page Content -->
                <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $heading = $row['heading'];
                    $sub_heading = $row['sub_heading'];
                    $content = $row['content'];
                    $description = $row['description'];
                    $our_mission = $row['our_mission'];
                    $our_vision = $row['our_vision'];
                    $meta_title = $row['meta_title'];
                    $meta_keyword = $row['meta_keyword'];
                    $meta_desc = $row['meta_desc'];
                    $about_image_1 = $row['about_image_1'];
                    $alt_tag = $row['alt_tag'];
                    $about_image_2 = $row['about_image_2'];
                    $alt_tag_2 = $row['alt_tag_2'];
                }
                ?>

                <div class="tab-content">
                    <!-- About Contect Start -->
                    <div class="tab-pane active" id="tab_1">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Heading * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"> Sub Heading * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="sub_heading" value="<?php echo $sub_heading; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Front Page Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor1"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="description" id="editor2"><?php echo $description; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Our Mission * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="our_mission" id="editor3"><?php echo $our_mission; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Our Vision * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="our_vision" id="editor4"><?php echo $our_vision; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Preview About Detail Page Image 1 -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Preview About Detail Page Image 1</label>
                                        <div class="col-sm-8">
                                            <img src="./uploads/about/<?php echo $about_image_1; ?>" alt="" style="max-width: 200px;">
                                        </div>
                                    </div>

                                    <!-- Upload About Detail Page Image 1 -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Detail Page Image 1</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="file" name="about_image_1">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Alt Tag Keyword Image 1 </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="alt_tag" value="<?= $alt_tag; ?>">
                                        </div>
                                    </div>

                                    <!-- Preview About Detail Page Image 2 -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Preview About Detail Page Image 2</label>
                                        <div class="col-sm-8">
                                            <img src="./uploads/about/<?php echo $about_image_2; ?>" alt="" style="max-width: 200px;">
                                        </div>
                                    </div>

                                    <!-- Upload About Detail Page Image 2 -->
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Detail Page Image 2</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="file" name="about_image_2">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Alt Tag Keyword Image 1 </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="alt_tag_2" value="<?= $alt_tag_2; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Title</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="meta_title" value="<?php echo $meta_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Keyword </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="meta_keyword" ><?php echo $meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Meta Description </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="meta_desc" ><?php echo $meta_desc; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_about">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- About Content End -->

                    <!-- Contact Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM  tbl_contact WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $address = $row['address'];
                        $phone_1 = $row['phone_1'];
                        $phone_2 = $row['phone_2'];
                        $email_id_1 = $row['email_id_1'];
                        $email_id_2 = $row['email_id_2'];
                        $email_id_3 = $row['email_id_3'];
                        $email_id_4 = $row['email_id_4'];
                        $map_url = $row['map_url'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_2">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Address * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="address" style="height:100px;"><?php echo $address; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Phone Number 1 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="phone_1" value="<?php echo $phone_1; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Phone Number 2 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="phone_2" value="<?php echo $phone_2; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Email Id 1 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="email" name="email_id_1" value="<?php echo $email_id_1; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Email Id 2 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="email" name="email_id_2" value="<?php echo $email_id_2; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Email Id 3 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="email_id_3" value="<?php echo $email_id_3; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Email Id 4 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="email" name="email_id_4" value="<?php echo $email_id_4; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Google Map URL Link * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="map_url" value="<?php echo $map_url; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_contact">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Content End  -->

                    <!-- Term & condition Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM  tbl_term_conditions WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_3">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor5"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_faq">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End of Term $ Condition Page Content -->

                    <!-- Privacy & Ploicy Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM  tbl_privacy_policy WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_4">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor6"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_privacy">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End of privacy $ Ploicy Page Content -->

                    <!-- Refund & Ploicy Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM  tbl_refund_ploicy WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_5">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor7"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_refund">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End of Refund & Ploicy Page Content -->

                    <!-- Disclaimer Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM  tbl_disclaimer WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }   
                    ?>
                    <div class="tab-pane" id="tab_6">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Content * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor8"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_disclaimer">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End of Disclaimer Page Content -->

                    </form>
                </div>
            </div>

</section>

<?php require_once('footer.php'); ?>