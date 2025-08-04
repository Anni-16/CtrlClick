<?php require_once('header.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['plan_sub_cat_name'])) {
        $valid = 0;
        $error_message .= "Sub Category Name is required.<br>";
    }

    if (empty($_POST['plan_cat_id'])) {
        $valid = 0;
        $error_message .= "Please select a Plan Category Name.<br>";
    }

    if ($valid == 1) {
        try {
            // Insert new plan sub category
            $statement = $pdo->prepare("INSERT INTO tbl_plan_sub_category (plan_sub_cat_name, plan_cat_id, status) VALUES (?, ?, ?)");
            $statement->execute([
                $_POST['plan_sub_cat_name'],
                $_POST['plan_cat_id'],
                $_POST['status']
            ]);
    
            $plan_sub_cat_id = $pdo->lastInsertId(); // Get last inserted ID
    
            // Create a URL-friendly slug from the sub category name
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['plan_sub_cat_name'])));
            $slug_url = rtrim($slug_url, '-');
    
            // Update the URL in the sub category table
            $statement = $pdo->prepare("UPDATE tbl_plan_sub_category SET url=? WHERE plan_sub_cat_id=?");
            $statement->execute([$slug_url, $plan_sub_cat_id]);
    
            $success_message = 'Plan sub category Name added successfully.';
        } catch (PDOException $e) {
            $error_message = "Database Error: " . $e->getMessage();
        }
    }
    
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Plans Sub Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="plan-sub-category.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

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

            <!-- Add Sub Category Form -->
            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plans Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_cat_id" class="form-control select2" required>
                                    <option value="">Select Plans Category Name</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['plan_cat_id'] . '">' . htmlspecialchars($row['plan_cat_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plans Sub Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="plan_sub_cat_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
