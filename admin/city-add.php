<?php require_once('header.php'); ?>

<?php
$error_message = ""; // Initialize error message variable
$success_message = ""; // Initialize success message variable

if (isset($_POST['form1'])) {
    $valid = 1;

    // Check if State is selected
    if (empty($_POST['state_id'])) {
        $valid = 0;
        $error_message .= "You must select a State Name.<br>";
    }

    // Check if either City Name is entered or CSV file is uploaded
    if (empty($_POST['city_name']) && empty($_FILES['csv_file']['name'])) {
        $valid = 0;
        $error_message .= "You must enter a City Name or upload a CSV file.<br>";
    }

    if ($valid == 1) {
        $state_id = $_POST['state_id'];

        // If a City Name is manually entered
        if (!empty($_POST['city_name'])) {
            $city_name = trim($_POST['city_name']);

            // Insert city
            $statement = $pdo->prepare("INSERT INTO tbl_city (city_name, state_id) VALUES (?, ?)");
            $statement->execute([$city_name, $state_id]);

            $city_id = $pdo->lastInsertId();

            // Generate and update slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower($city_name));
            $slug_url = rtrim($slug_url, '-');

            $statement = $pdo->prepare("UPDATE tbl_city SET url=? WHERE city_id=?");
            $statement->execute([$slug_url, $city_id]);

            $success_message = 'City added successfully.';
        }

        // If a CSV file is uploaded
        if (!empty($_FILES['csv_file']['name'])) {
            $file = $_FILES["csv_file"]["tmp_name"];
            $message = importCitiesFromCSV($file, $state_id);
            $success_message .= "<br>" . $message;
        }
    }
}

// Function to import Cities from CSV file
function importCitiesFromCSV($file, $state_id)
{
    global $pdo; // Use the database connection

    if (!file_exists($file) || !is_readable($file)) {
        return "Error: File not found or not readable.";
    }

    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row if present

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $city_name = trim($data[0]); // Assuming city name is in the first column

            if (!empty($city_name)) {
                // Check if the city already exists in the selected state
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_city WHERE city_name = ? AND state_id = ?");
                $stmt->execute([$city_name, $state_id]);
                $exists = $stmt->fetchColumn();

                if (!$exists) {
                    // Generate slug
                    $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower($city_name));
                    $slug_url = rtrim($slug_url, '-');

                    // Insert city with slug
                    $stmt = $pdo->prepare("INSERT INTO tbl_city (city_name, state_id, url) VALUES (?, ?, ?)");
                    $stmt->execute([$city_name, $state_id, $slug_url]);
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
        <h1>Add Cities</h1>
    </div>
    <div class="content-header-right">
        <a href="city.php" class="btn btn-primary btn-sm">View All</a>
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

                        <!-- State Selection -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">State Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="state_id" class="form-control select2 state-cat">
                                    <option value="">Select State Name</option>
                                    <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_state  ORDER BY state_id DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {
                                        $i++;
                                    ?>
                                        <option value="<?= $row['state_id']; ?>"><?= $row['state_name']; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>

                        <!-- City Name Input -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">City Name (Single Entry)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="city_name">
                            </div>
                        </div>

                        <h3 class="text-center">OR</h3>

                        <!-- CSV File Upload -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Upload CSV File (Multiple Cities)</label>
                            <div class="col-sm-4">
                                <input type="file" name="csv_file" accept=".csv" class="form-control">
                                <small>Format Of column Name:  city_name</small>
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