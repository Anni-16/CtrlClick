<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['plan_cat_name'])) {
        $valid = 0;
        $error_message .= "Plan Category Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_plan_category WHERE plan_cat_name=?");
        $statement->execute(array($_POST['plan_cat_name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Plan Category Name already exists<br>";
        }
    }

    if ($valid == 1) {
        try {
            // Insert new plan category into the database
            $statement = $pdo->prepare("INSERT INTO tbl_plan_category (plan_cat_name, status) VALUES (?, ?)");
            $statement->execute([$_POST['plan_cat_name'], $_POST['status']]);
    
            // Get the last inserted plan category ID
            $plan_cat_id = $pdo->lastInsertId();
            
            // Create a URL-friendly slug from the plan category name
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['plan_cat_name'])));
            $slug_url = rtrim($slug_url, '-');
            
            // Update the inserted plan category with the generated slug
            $statement = $pdo->prepare("UPDATE tbl_plan_category SET url = ? WHERE plan_cat_id = ?");
            $statement->execute([$slug_url, $plan_cat_id]);
            
            $success_message = 'Plan category Name added successfully.';
        } catch (PDOException $e) {
            $error_message = 'Database Error: ' . $e->getMessage();
        }
    }
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Plans Category</h1>
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
                                <input type="text" class="form-control" name="plan_cat_name">
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
