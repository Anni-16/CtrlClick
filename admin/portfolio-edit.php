<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['p_name'])) {
		$valid = 0;
		$error_message .= "Portfolio name can not be empty<br>";
	}

	if (empty($_POST['p_url'])) {
		$valid = 0;
		$error_message .= "Portfolio URL can not be empty<br>";
	}
	if (empty($_POST['type_id'])) {
		$valid = 0;
		$error_message .= "Portfolio Type can not be empty<br>";
	}


	$path = $_FILES['p_image']['name'];
	$path_tmp = $_FILES['p_image']['tmp_name'];

	if ($path != '') {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$file_name = basename($path, '.' . $ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'webp' && $ext != 'pdf' && $ext != 'JPG' && $ext != 'JPEG' && $ext != 'PNG' && $ext != 'GIF' && $ext != 'WEBP' && $ext != 'PDF') {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
		}
	}


	if ($valid == 1) {

		if ($path == '') {
			$statement = $pdo->prepare("UPDATE tbl_portfolio SET 
        							p_name=?, 
        							p_description=?, 
        							p_url=?, 
        							p_meta_title=?,
        							p_meta_keyword=?,
        							p_meta_desc=?,
        							p_is_featured=?,
        							status=?,
        							area_id=?,
        							type_id=?,
        							ind_id=?,
        							state_id=?
        							WHERE p_id=?");
			$statement->execute(array(
				$_POST['p_name'],
				$_POST['p_description'],
				$_POST['p_url'],
				$_POST['p_meta_title'],
				$_POST['p_meta_keyword'],
				$_POST['p_meta_desc'],
				$_POST['p_is_featured'],
				$_POST['status'],
				$_POST['area_id'],
				$_POST['type_id'],
				$_POST['ind_id'],
				$_POST['state_id'],
				$_REQUEST['id']
			));
		} else {

			unlink('./uploads/portfolio/' . $_POST['current_photo']);

			$final_name = 'portfolio-' . $_REQUEST['id'] . '.' . $ext;
			move_uploaded_file($path_tmp, './uploads/portfolio/' . $final_name);


			$statement = $pdo->prepare("UPDATE tbl_portfolio SET 
        							p_name=?, 
        							p_image=?,
        							p_description=?,
        							p_url=?,
        							p_meta_title=?,
        							p_meta_keyword=?,
        							p_meta_desc=?,
        							p_is_featured=?,
        							status=?,
        							area_id=?,
        							type_id=?,
        							ind_id=?,
        							state_id=?
        							WHERE p_id=?");
			$statement->execute(array(
				$_POST['p_name'],
				$final_name,
				$_POST['p_description'],
				$_POST['p_url'],
				$_POST['p_meta_title'],
				$_POST['p_meta_keyword'],
				$_POST['p_meta_desc'],
				$_POST['p_is_featured'],
				$_POST['status'],
				$_POST['area_id'],
				$_POST['type_id'],
				$_POST['ind_id'],
				$_POST['state_id'],
				$_REQUEST['id']
			));
		}

// Mulitple Technologies
		if (isset($_POST['technology'])) {

			$statement = $pdo->prepare("DELETE FROM tbl_portfolio_technology WHERE p_id=?");
			$statement->execute(array($_REQUEST['id']));

			foreach ($_POST['technology'] as $value) {
				$statement = $pdo->prepare("INSERT INTO tbl_portfolio_technology (tec_id,p_id) VALUES (?,?)");
				$statement->execute(array($value, $_REQUEST['id']));
			}
		} else {
			$statement = $pdo->prepare("DELETE FROM tbl_portfolio_technology WHERE p_id=?");
			$statement->execute(array($_REQUEST['id']));
		}

		// Generate slug from package title
		$slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['p_name'])));
		$slug_url = rtrim($slug_url, '-');
		$url = $slug_url;

		// Optional: update URL in the same package row
		$stmt2 = $pdo->prepare("UPDATE tbl_portfolio SET url = ? WHERE p_id = ?");
		$stmt2->execute([$url, $_REQUEST['id']]);

		$success_message = 'Portfolio item Updated successfully.';
	}
}
?>

<?php
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_portfolio WHERE p_id=?");
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
		<h1>Edit Portfolio</h1>
	</div>
	<div class="content-header-right">
		<a href="portfolio.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_portfolio WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$p_name = $row['p_name'];
	$p_image = $row['p_image'];
	$p_description = $row['p_description'];
	$p_url = $row['p_url'];
	$p_meta_title = $row['p_meta_title'];
	$p_meta_keyword = $row['p_meta_keyword'];
	$p_meta_desc = $row['p_meta_desc'];
	$p_is_featured = $row['p_is_featured'];
	$status = $row['status'];
	$area_id = $row['area_id'];
	$type_id = $row['type_id'];
	$ind_id = $row['ind_id'];
	$state_id = $row['state_id'];
}

$statement = $pdo->prepare("SELECT * 
                        FROM tbl_area t1
                        JOIN tbl_city t2
                        ON t1.city_id = t2.city_id
                        JOIN tbl_state t3
                        ON t2.state_id = t3.state_id
                        WHERE t1.area_id=?");
$statement->execute(array($area_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$area_name = $row['area_name'];
	$city_id = $row['city_id'];
	$state_id = $row['state_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_portfolio_technology WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$tec_id[] = $row['tec_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_type WHERE type_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$type_id = $row['type_id'];
	$type_name = $row['type_name'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_industry WHERE ind_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ind_id = $row['ind_id'];
	$ind_name = $row['ind_name'];
}
?>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if ($error_message) : ?>
				<div class="callout callout-danger">

					<p>
						<?php echo $error_message; ?>
					</p>
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
							<label for="" class="col-sm-3 control-label">Portfolio Name <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Portfolio URL<span>*</span></label>
							<div class="col-sm-6">
								<input type="text" name="p_url" class="form-control" value="<?php echo $p_url; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Portfolio Select Type</label>
							<div class="col-sm-6">
								<select name="type_id" class="form-control select2">
									<option value="">Select Portfolio Type</option>
									<?php
									$is_select = '';
									$statement = $pdo->prepare("SELECT * FROM tbl_type ORDER BY type_id ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['type_id']; ?>" <?php if ($row['type_id'] == $type_id) {
																							echo 'selected';
																						} ?>><?php echo $row['type_name']; ?></option> <?php
																																		}
																																			?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Portfolio Select Industries</label>
							<div class="col-sm-6">
								<select name="ind_id" class="form-control select2">
								<option value="">Select Portfolio Industries</option>
									<?php
									$is_select = '';
									$statement = $pdo->prepare("SELECT * FROM tbl_industry ORDER BY ind_id ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['ind_id']; ?>" <?php if ($row['ind_id'] == $type_id) {
																							echo 'selected';
																						} ?>><?php echo $row['ind_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Portfolio Select Technology</label>
							<div class="col-sm-6">
								<select name="technology[]" class="form-control select2" multiple="multiple">
									<?php
									$is_select = '';
									$statement = $pdo->prepare("SELECT * FROM tbl_technology ORDER BY tec_id ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										if (isset($tec_id)) {
											if (in_array($row['tec_id'], $tec_id)) {
												$is_select = 'selected';
											} else {
												$is_select = '';
											}
										}
									?>
										<option value="<?php echo $row['tec_id']; ?>" <?php echo $is_select; ?>><?php echo $row['tec_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Country Name <span>*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" readonly value="Australian">
							</div>
							<label for="" class="col-sm-2 control-label">State Name <span>*</span></label>
							<div class="col-sm-3">
								<select name="state_id" class="form-control select2 " id="state-cat">
									<option value="">Select State Name</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_state ORDER BY state_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['state_id']; ?>" <?php if ($row['state_id'] == $state_id) {
																							echo 'selected';
																						} ?>><?php echo $row['state_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">City Name <span>*</span></label>
							<div class="col-sm-3">
								<select name="city_id" class="form-control select2 " id="city-cat">
									<option value="">Select City Name</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_city WHERE state_id = ? ORDER BY city_name ASC");
									$statement->execute(array($state_id));
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['city_id']; ?>" <?php if ($row['city_id'] == $city_id) {
																							echo 'selected';
																						} ?>><?php echo $row['city_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<label for="" class="col-sm-2 control-label">Area Name <span>*</span></label>
							<div class="col-sm-3">
								<select name="area_id" class="form-control select2 " id="area-cat">
									<option value="">Select Area Name</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_area WHERE city_id = ? ORDER BY area_name ASC");
									$statement->execute(array($city_id));
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['area_id']; ?>" <?php if ($row['area_id'] == $area_id) {
																							echo 'selected';
																						} ?>><?php echo $row['area_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<img src="./uploads/portfolio/<?php echo $p_image; ?>" alt="" style="width:150px;">
								<input type="hidden" name="current_photo" value="<?php echo $p_image; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Change Featured Photo </label>
							<div class="col-sm-4" style="padding-top:4px;">
								<input type="file" name="p_image">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Description *</label>
							<div class="col-sm-8">
								<textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Meta Title<span>*</span></label>
							<div class="col-sm-8">
								<input type="text" name="p_meta_title" class="form-control" value="<?php echo $p_meta_title; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Meta Keyword<span>*</span></label>
							<div class="col-sm-8">
								<input type="text" name="p_meta_keyword" class="form-control" value="<?php echo $p_meta_keyword; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Meta Description</label>
							<div class="col-sm-8">
								<textarea name="p_meta_desc" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_meta_desc; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Featured?</label>
							<div class="col-sm-8">
								<select name="p_is_featured" class="form-control" style="width:auto;">
									<option value="0" <?php if ($p_is_featured == '0') {
															echo 'selected';
														} ?>>No</option>
									<option value="1" <?php if ($p_is_featured == '1') {
															echo 'selected';
														} ?>>Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-8">
								<select name="status" class="form-control" style="width:auto;">
									<option value="0" <?php if ($status == '0') {
															echo 'selected';
														} ?>>No</option>
									<option value="1" <?php if ($status == '1') {
															echo 'selected';
														} ?>>Yes</option>
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