<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['ind_name'])) {
        $valid = 0;
        $error_message .= "Industry Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_industry WHERE ind_name=?");
        $statement->execute(array($_POST['ind_name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Industry Name already exists<br>";
        }
    }


    if ($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_industry (ind_name, status) VALUES (?,?)");
        $statement->execute(array($_POST['ind_name'], $_POST['status']));

        $area_id = $pdo->lastInsertId();

        $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($_POST['ind_name']));
        $slug = rtrim($slug, '-');

        $stmt = $pdo->prepare("UPDATE tbl_industry SET url = ? WHERE ind_id = ?");
        $stmt->execute([$slug, $area_id]);

        $success_message = 'Industry is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Industrys</h1>
    </div>
    <div class="content-header-right">
        <a href="industry.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if ($error_message) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message) : ?>
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
                                <input type="text" class="form-control" name="ind_name">
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