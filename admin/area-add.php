<?php
require_once('header.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_message = "";
$success_message = "";

if (isset($_POST['form1'])) {
	$valid = 1;

	// Validate mandatory fields
	if (empty($_POST['state_id'])) {
		$valid = 0;
		$error_message .= "You must select a State Name.<br>";
	} else {
		$state_id = $_POST['state_id']; // Needed for CSV function
	}

	// Check if either area fields OR CSV is provided
	if (
		empty($_POST['city_id']) &&
		empty($_POST['area_name']) &&
		empty($_POST['pin']) &&
		empty($_FILES['csv_file']['name'])
	) {
		$valid = 0;
		$error_message .= "You must enter Area details or upload a CSV file.<br>";
	}

	if ($valid == 1) {
		// Manual area entry
		if (!empty($_POST['city_id']) && !empty($_POST['area_name']) && !empty($_POST['pin'])) {
			$city_id = $_POST['city_id'];
			$area_name = trim($_POST['area_name']);
			$pin = trim($_POST['pin']);

			// Insert into tbl_area
			$statement = $pdo->prepare("INSERT INTO tbl_area (area_name, city_id, pin) VALUES (?, ?, ?)");
			$statement->execute([$area_name, $city_id, $pin]);

			$area_id = $pdo->lastInsertId();

			// Generate slug
			$slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($area_name));
			$slug = rtrim($slug, '-');

			$statement = $pdo->prepare("UPDATE tbl_area SET url=? WHERE area_id=?");
			$statement->execute([$slug, $area_id]);

			$success_message = "Area added successfully.";
		}

		// CSV upload
		if (!empty($_FILES['csv_file']['name'])) {
			$file = $_FILES["csv_file"]["tmp_name"];
			$message = importAreasFromCSV($file, $_POST['city_id']);
			$success_message .= "<br>" . $message;
		}
	}
}

/**
 * Import areas from CSV
 * CSV columns: area_name, pin
 */
function importAreasFromCSV($file, $city_id)
{
	global $pdo;

	if (!file_exists($file) || !is_readable($file)) {
		return "Error: File not found or not readable.";
	}

	if (($handle = fopen($file, "r")) !== FALSE) {
		fgetcsv($handle); // Skip header

		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$area_name = trim($data[0]); // area_name
			$pin       = trim($data[1]);

			if (!empty($area_name)) {
				// Check if area already exists for the city
				$stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_area WHERE area_name = ? AND city_id = ?");
				$stmt->execute([$area_name, $city_id]);
				$exists = $stmt->fetchColumn();

				if (!$exists) {
					// Generate slug
					$slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower($area_name));
					$slug_url = rtrim($slug_url, '-');

					// Insert area
					$stmt = $pdo->prepare("INSERT INTO tbl_area (area_name, pin, city_id, url) VALUES (?, ?, ?, ?)");
					$stmt->execute([$area_name, $pin, $city_id, $slug_url]);
				}
			}
		}

		fclose($handle);
		return "CSV file imported successfully!";
	} else {
		return "Error opening the CSV file.";
	}
}
?>


<section class="content-header">
	<div class="content-header-left">
		<h1>Add Areas</h1>
	</div>
	<div class="content-header-right">
		<a href="area.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if (!empty($error_message)) : ?>
				<div class="callout callout-danger">
					<p><?php echo $error_message; ?></p>
				</div>
			<?php endif; ?>

			<?php if (!empty($success_message)) : ?>
				<div class="callout callout-success">
					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-3 control-label">State Name <span>*</span></label>
							<div class="col-sm-4">
								<select name="state_id" class="form-control select2" id="state-cat">
									<option value="">Select State Name</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_state ORDER BY state_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										echo '<option value="' . $row['state_id'] . '">' . $row['state_name'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">City Name <span>*</span></label>
							<div class="col-sm-4">
								<select name="city_id" class="form-control select2 " id="city-cat">
									<option value="">Select City Name</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Area Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="area_name">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Pin/Zip Code <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="pin">
							</div>
						</div>

						<h1 style="text-align: center;">Or</h1>
						<div class="form-group">
							<label class="col-sm-3 control-label">Upload CSV File</label>
							<div class="col-sm-4">
								<input type="file" name="csv_file" accept=".csv" class="form-control">
								<small>Format for CSV: state_id, city_id, area_name, pin</small>
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