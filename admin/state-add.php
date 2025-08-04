<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['state_name'])) {
		$valid = 0;
		$error_message .= "State Name can not be empty<br>";
	}

	if ($valid == 1) {

		// Saving data into the main table tbl_mid_category
		$statement = $pdo->prepare("INSERT INTO tbl_state (state_name,state_capital,state_font_display) VALUES (?,?,?)");
		$statement->execute(array($_POST['state_name'], $_POST['state_capital'], $_POST['state_font_display']));

		 // Get the last inserted portfolio ID
		 $state_id = $pdo->lastInsertId();

		 // Create a URL-friendly slug
		 $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($_POST['state_name'])));
		 $slug_url = rtrim($slug_url, '-');

		 $slug_url2 = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($_POST['state_capital'])));
		 $slug_url2 = rtrim($slug_url2, '-');
 
		 // Update the record with the slug
		 $statement = $pdo->prepare("UPDATE tbl_state SET url = ?, state_cap_url =? WHERE state_id = ?");
		 $statement->execute([$slug_url, $slug_url2, $state_id]);
 

		$success_message = 'State Name is added successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add States</h1>
	</div>
	<div class="content-header-right">
		<a href="state.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


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
							<label for="" class="col-sm-3 control-label">State Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="state_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Capital City Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="state_capital">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Front Display Status? <span>*</span></label>
							<div class="col-sm-4">
								<select name="state_font_display" class="form-control" style="width:auto;">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>

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