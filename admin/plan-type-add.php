<?php require_once('header.php'); ?>

<?php
$error_message = ""; // Initialize error message variable
$success_message = ""; // Initialize success message variable

if (isset($_POST['form1'])) {
    $valid = 1;

    // Check if Country is selected
    if (empty($_POST['plan_cat_id'])) {
        $valid = 0;
        $error_message .= "You must select a Plan Category Name.<br>";
    }

    // Check if State is selected
    if (empty($_POST['plan_sub_cat_id'])) {
        $valid = 0;
        $error_message .= "You must select a Plan Sub Category Name.<br>";
    }

    // Check if either City Name is entered or CSV file is uploaded
    if (empty($_POST['plan_type_name'])) {
        $valid = 0;
        $error_message .= "You must enter a Plan Type Name.<br>";
    }

    if ($valid == 1) {
        try {
            // Insert new plan type
            $statement = $pdo->prepare("INSERT INTO tbl_plan_type (plan_type_name, plan_type_price, plan_type_duration, plan_sub_cat_id) VALUES (?, ?, ?, ?)");
            $statement->execute([
                $_POST['plan_type_name'],
                $_POST['plan_type_price'],
                $_POST['plan_type_duration'],
                $_POST['plan_sub_cat_id']
            ]);
    
            $plan_type_id = $pdo->lastInsertId(); // Get last inserted plan_type_id
    
            // Create a URL-friendly slug from the plan type name
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['plan_type_name'])));
            $slug_url = rtrim($slug_url, '-');
    
            // Update the URL in the plan type table
            $statement = $pdo->prepare("UPDATE tbl_plan_type SET url=? WHERE plan_type_id=?");
            $statement->execute([$slug_url, $plan_type_id]);
    
            $success_message = 'Plan type Name added successfully.';
        } catch (PDOException $e) {
            $error_message = "Database Error: " . $e->getMessage();
        }
    }
    
}

?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Plan Type</h1>
    </div>
    <div class="content-header-right">
        <a href="plan-type.php" class="btn btn-primary btn-sm">View All</a>
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

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">
                        <!-- Country Selection -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plans Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_cat_id" class="form-control select2 " id="plan-cat">
                                    <option value="">Select Plans Category Name</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['plan_cat_id']; ?>"><?php echo $row['plan_cat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- State Selection -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plans Sub Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_sub_cat_id" class="form-control select2 " id="plan-sub-cat">
                                    <option value="">Select Plan Sub Category Name</option>
                                </select>
                            </div>
                        </div>

                        <!-- City Name Input -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plan Type Name </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="plan_type_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plan Price </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="plan_type_price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan Duration <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_type_duration" class="form-control" style="width:auto;">
                                    <option value="Month">Month</option>
                                    <option value="Year">Year</option>
                                    <option value="Nill">Nill</option>
                                </select>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
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
