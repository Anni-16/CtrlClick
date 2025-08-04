<?php require_once('header.php'); ?>

<?php
// Check if the ID is set
if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
    header('location: plan-category.php');
    exit;
} else {
    $id = $_REQUEST['id'];
    // Check if the record exists
    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category WHERE plan_cat_id=?");
    $statement->execute(array($id));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        header('location: plan-category.php');
        exit;
    }
    $plan_cat_name = $result['plan_cat_name'];
    $status = $result['status'];
}

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['plan_cat_name'])) {
        $valid = 0;
        $error_message .= "Category Name cannot be empty.<br>";
    } else {
        // Duplicate category name check
        $statement = $pdo->prepare("SELECT * FROM tbl_plan_category WHERE plan_cat_name=? AND plan_cat_id!=?");
        $statement->execute(array($_POST['plan_cat_name'], $id));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Plan Category Name already exists.<br>";
        }
    }

    if ($valid == 1) {
        try {
            // Update category details
            $statement = $pdo->prepare("UPDATE tbl_plan_category SET plan_cat_name=?, status=? WHERE plan_cat_id=?");
            $statement->execute([$_POST['plan_cat_name'], $_POST['status'], $id]);
    
            // Generate slug from the plan category name
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['plan_cat_name'])));
            $slug_url = rtrim($slug_url, '-');
            
            // Update URL in the same package row
            $stmt2 = $pdo->prepare("UPDATE tbl_plan_category SET url = ? WHERE plan_cat_id = ?");
            $stmt2->execute([$slug_url, $id]);
    
            // Success message
            $success_message = 'Plan Category Name updated successfully.';
        } catch (PDOException $e) {
            // Error handling
            $error_message = 'Database Error: ' . $e->getMessage();
        }
    }
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Plans Category</h1>
    </div>
    <div class="content-header-right">
        <a href="plan-category.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-2 control-label">Plans Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="plan_cat_name" value="<?php echo $plan_cat_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
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