<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['plan_cat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a Plan Category Name<br>";
    }

    if (empty($_POST['plan_sub_cat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a Plan Sub Category Name<br>";
    }

    if (empty($_POST['plan_type_name'])) {
        $valid = 0;
        $error_message .= "Plan Type name can not be empty<br>";
    }

    if ($valid == 1) {
        try {
            // Update plan type details
            $statement = $pdo->prepare("UPDATE tbl_plan_type SET plan_type_name = ?, plan_type_price = ?, plan_type_duration = ?, plan_sub_cat_id = ? WHERE plan_type_id = ?");
            $statement->execute([
                $_POST['plan_type_name'],
                $_POST['plan_type_price'],
                $_POST['plan_type_duration'],
                $_POST['plan_sub_cat_id'],
                $_REQUEST['id']
            ]);
    
            // Generate a slug from the plan type name
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['plan_type_name'])));
            $slug_url = rtrim($slug_url, '-');
    
            // Update the slug URL in the same row
            $stmt2 = $pdo->prepare("UPDATE tbl_plan_type SET url = ? WHERE plan_type_id = ?");
            $stmt2->execute([$slug_url, $_REQUEST['id']]);
    
            $success_message = 'Plan type updated successfully.';
        } catch (PDOException $e) {
            $error_message = 'Database Error: ' . $e->getMessage();
        }
    }
    
}
?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * 
                            FROM tbl_plan_type t1
                            JOIN tbl_plan_sub_category t2
                            ON t1.plan_sub_cat_id = t2.plan_sub_cat_id
                            JOIN tbl_plan_category t3
                            ON t2.plan_cat_id = t3.plan_cat_id
                            WHERE t1.plan_type_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Plan Type</h1>
    </div>
    <div class="content-header-right">
        <a href="plan-type.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<?php
foreach ($result as $row) {
    $plan_type_name = $row['plan_type_name'];
    $plan_sub_cat_id = $row['plan_sub_cat_id'];
    $plan_cat_id = $row['plan_cat_id'];
    $plan_type_price = $row['plan_type_price'];
    $plan_type_duration = $row['plan_type_duration'];
}
?>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">

                    <p>
                        <?php echo $error_message; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="callout callout-success">

                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">

                <div class="box box-info">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_cat_id" class="form-control select2 " id="plan-cat">
                                    <option value="">Select Plan Category Name</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['plan_cat_id']; ?>" <?php if ($row['plan_cat_id'] == $plan_cat_id) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $row['plan_cat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan Sub Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_sub_cat_id" class="form-control select2 " id="plan-sub-cat">
                                    <option value="">Select Plan Sub Category Name</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_sub_category WHERE plan_cat_id = ? ORDER BY plan_sub_cat_name ASC");
                                    $statement->execute(array($plan_cat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['plan_sub_cat_id']; ?>" <?php if ($row['plan_sub_cat_id'] == $plan_sub_cat_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['plan_sub_cat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan Type Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="plan_type_name" value="<?php echo $plan_type_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan Price <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="plan_type_price" value="<?php echo $plan_type_price; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Plan Duration <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_type_duration" class="form-control" style="width:auto;">
                                    <option value="Month" <?php echo ($plan_type_duration == 'Month') ? 'selected' : ''; ?>>Month</option>
                                    <option value="Year" <?php echo ($plan_type_duration == 'Year') ? 'selected' : ''; ?>>Year</option>
                                    <option value="Nill" <?php echo ($plan_type_duration == 'Nill') ? 'selected' : ''; ?>>Nill</option>
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