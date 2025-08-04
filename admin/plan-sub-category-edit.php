<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['plan_cat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a Plan Category Name<br>";
    }

    if(empty($_POST['plan_sub_cat_name'])) {
        $valid = 0;
        $error_message .= "Plans Sub Category Name can not be empty<br>";
    }

    if ($valid == 1) {
        try {
            // Update plan sub category details
            $statement = $pdo->prepare("UPDATE tbl_plan_sub_category SET plan_sub_cat_name = ?, plan_cat_id = ?, status = ? WHERE plan_sub_cat_id = ?");
            $statement->execute([
                $_POST['plan_sub_cat_name'],
                $_POST['plan_cat_id'],
                $_POST['status'],
                $_REQUEST['id']
            ]);
    
            // Generate slug from plan sub category name
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['plan_sub_cat_name'])));
            $slug_url = rtrim($slug_url, '-');
    
            // Update the URL in the same row
            $stmt2 = $pdo->prepare("UPDATE tbl_plan_sub_category SET url = ? WHERE plan_sub_cat_id = ?");
            $stmt2->execute([$slug_url, $_REQUEST['id']]);
    
            $success_message = 'Plan sub category Name updated successfully.';
        } catch (PDOException $e) {
            $error_message = 'Database Error: ' . $e->getMessage();
        }
    }
    
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_plan_sub_category WHERE plan_sub_cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Plans Sub Category</h1>
	</div>
	<div class="content-header-right">
		<a href="plan-sub-category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$plan_sub_cat_name = $row['plan_sub_cat_name'];
    $plan_cat_id = $row['plan_cat_id'];
    $status = $row['status'];
}
?>

<section class="content">

  <div class="row">
    <div class="col-md-12">
		<?php if($error_message): ?>
		<div class="callout callout-danger">
		<p>
		<?php echo $error_message; ?>
		</p>
		</div>
		<?php endif; ?>

		<?php if($success_message): ?>
		<div class="callout callout-success">
		
		<p><?php echo $success_message; ?></p>
		</div>
		<?php endif; ?>

        <form class="form-horizontal" action="" method="post">

        <div class="box box-info">

            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Plans Category Name <span>*</span></label>
                    <div class="col-sm-4">
                        <select name="plan_cat_id" class="form-control select2">
                            <option value="">Select Plans Category Name</option>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['plan_cat_id']; ?>" <?php if($row['plan_cat_id'] == $plan_cat_id){echo 'selected';} ?>><?php echo $row['plan_cat_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Plans Sub Category Name <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="plan_sub_cat_name" value="<?php echo $plan_sub_cat_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Yes</option>
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