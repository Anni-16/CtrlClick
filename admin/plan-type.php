<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Plans Type</h1>
	</div>
	<div class="content-header-right">
		<a href="plan-type-add.php" class="btn btn-primary btn-sm">Add Plans Type</a>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>S.No</th>
			        <th>Plan Category Name</th>
			        <th>Plan Sub Category Name</th>
			        <th>Plan Type Name</th>
			        <th>Plan Price</th>
			        <th>Plan Duration</th>
			        <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_plan_type t1 JOIN tbl_plan_sub_category t2 ON t1.plan_sub_cat_id = t2.plan_sub_cat_id JOIN tbl_plan_category t3 ON t2.plan_cat_id = t3.plan_cat_id ORDER BY t1.plan_type_id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['plan_cat_name']; ?></td>
	                    <td><?php echo $row['plan_sub_cat_name']; ?></td>
	                    <td><?php echo $row['plan_type_name']; ?></td>
	                    <td><?php echo $row['plan_type_price']; ?></td>
	                    <td><?php echo $row['plan_type_duration']; ?></td>
	                    <td>
	                        <a href="plan-type-edit.php?id=<?php echo $row['plan_type_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
	                        <a href="#" class="btn btn-danger btn-xs" data-href="plan-type-delete.php?id=<?php echo $row['plan_type_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>
  

</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful! All products, mid level categories and end level categories under this top lelvel category will be deleted from all the tables like order table, payment table, size table, color table, rating table etc.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>