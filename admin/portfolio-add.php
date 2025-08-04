<?php require_once('header.php'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize messages to avoid undefined variable warnings
$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $valid = 1;

    // Basic validations
    if (empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Portfolio name can not be empty<br>";
    }

    if (empty($_POST['p_url'])) {
        $valid = 0;
        $error_message .= "Portfolio URL can not be empty<br>";
    }

    if (empty($_POST['type_id'])) {
        $valid = 0;
        $error_message .= "Portfolio Type can not be empty<br>";
    }

    // File upload validation
    $path = $_FILES['p_image']['name'];
    $path_tmp = $_FILES['p_image']['tmp_name'];

    if ($path != '') {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP', 'PDF'];

        if (!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, png, webp or pdf file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select a featured photo<br>';
    }

    if ($valid == 1) {

        // Get next auto-increment ID
        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_portfolio'");
        $statement->execute();
        $result = $statement->fetch();
        $ai_id = $result['Auto_increment'];

        // Rename and move uploaded image
        $final_name = 'portfolio-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/portfolio/' . $final_name);

        // Insert into tbl_portfolio
        $statement = $pdo->prepare("INSERT INTO tbl_portfolio (
            p_name,
            p_image,
            p_description,
            p_url,
            p_meta_title,
            p_meta_keyword,
            p_meta_desc,
            p_is_featured,
            status,
            area_id,
            type_id,
            ind_id,
            state_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
        $statement->execute([
            $_POST['p_name'],
            $final_name,
            $_POST['p_description'],
            $_POST['p_url'],
            $_POST['p_meta_title'],
            $_POST['p_meta_keyword'],
            $_POST['p_meta_desc'],
            $_POST['p_is_featured'],
            $_POST['status'],
            $_POST['area_id'],
            $_POST['type_id'],
            $_POST['ind_id'],
            $_POST['state_id']
        ]);

        // Get last inserted ID
        $portfolio_id = $pdo->lastInsertId();

        // Generate slug from portfolio name
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($_POST['p_name'])));
        $slug_url = rtrim($slug_url, '-');

        // Update portfolio record with slug
        $statement = $pdo->prepare("UPDATE tbl_portfolio SET url = ? WHERE p_id = ?");
        $statement->execute([$slug_url, $portfolio_id]);

        // Insert selected technologies
        if (!empty($_POST['technology'])) {
            foreach ($_POST['technology'] as $value) {
                $value = trim($value);
                if ($value !== '') {
                    $statement = $pdo->prepare("INSERT INTO tbl_portfolio_technology (tec_id, p_id) VALUES (?, ?)");
                    $statement->execute([(int)$value, $portfolio_id]);
                }
            }
        }

        $success_message = 'Portfolio is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Portfolio</h1>
    </div>
    <div class="content-header-right">
        <a href="portfolio.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message != '') : ?>
                <div class="callout callout-danger">
                    <p><?php echo nl2br(($error_message)); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message != '') : ?>
                <div class="callout callout-success">
                    <p><?php echo ($success_message); ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portfolio Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="p_name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portfolio URL <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="p_url" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portfolio Select Type</label>
                            <div class="col-sm-6">
                                <select name="type_id" class="form-control select2">
                                    <option value="">Select Portfolio Type</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_type ORDER BY type_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['type_id'] . '">' . ($row['type_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portfolio Select Industries</label>
                            <div class="col-sm-6">
                                <select name="ind_id" class="form-control select2" >
                                <option value="">Select Portfolio Industries</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_industry ORDER BY ind_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['ind_id'] . '">' . $row['ind_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portfolio Select Technologies</label>
                            <div class="col-sm-6">
                                <select name="technology[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_technology ORDER BY tec_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['tec_id'] . '">' . $row['tec_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contury Name <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" readonly value="Australian">
                            </div>
                            <label class="col-sm-2 control-label">State Name <span>*</span></label>
                            <div class="col-sm-3">
                                <select name="state_id" class="form-control select2 " id="state-cat">
                                    <option value="">Select State Name</option>
                                    <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_state ORDER BY state_id DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $i++;
                                        echo '<option value="' . $row['state_id'] . '">' . $row['state_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">City Name <span>*</span></label>
                            <div class="col-sm-3">
                                <select name="city_id" class="form-control select2 " id="city-cat">
                                    <option value="">Select City Name</option>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Area Name <span>*</span></label>
                            <div class="col-sm-3">
                                <select name="area_id" class="form-control select2 " id="area-cat">
                                    <option value="">Select Area Name</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Featured Photo <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="p_image">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title<span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="p_meta_title" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword<span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="p_meta_keyword" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_meta_desc" class="form-control" cols="30" rows="10" id="editor1"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="p_is_featured" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Portfolio</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
