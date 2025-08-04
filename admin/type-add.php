<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['type_name'])) {
        $valid = 0;
        $error_message .= "Type Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_type WHERE type_name=?");
        $statement->execute(array($_POST['type_name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Type Name already exists<br>";
        }
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_type (type_name, status) VALUES (?,?)");
        $statement->execute(array($_POST['type_name'], $_POST['status']));

        $area_id = $pdo->lastInsertId();

        $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($_POST['type_name']));
        $slug = rtrim($slug, '-');

        $stmt = $pdo->prepare("UPDATE tbl_type SET url = ? WHERE type_id = ?");
        $stmt->execute([$slug, $area_id]);

        $success_message = 'Type is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Types</h1>
    </div>
    <div class="content-header-right">
        <a href="type.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-2 control-label">Types Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="type_name">
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
