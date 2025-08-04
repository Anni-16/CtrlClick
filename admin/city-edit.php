<?php require_once('header.php'); ?>

<?php
$error_message = "";
$success_message = "";

// First, validate city id and fetch existing data
if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
    header('Location: logout.php');
    exit;
} else {
    // Check the ID is valid
    $statement = $pdo->prepare("
        SELECT t1.*, t2.state_name 
        FROM tbl_city t1
        JOIN tbl_state t2 ON t1.state_id = t2.state_id
        WHERE t1.city_id = ?
    ");
    $statement->execute([$_REQUEST['id']]);
    $cityData = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$cityData) {
        header('Location: logout.php');
        exit;
    }

    // Default values for form fields
    $city_name = $cityData['city_name'];
    $state_id = $cityData['state_id'];
}

// Handle form submission
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['state_id'])) {
        $valid = 0;
        $error_message .= "You must select a State Name<br>";
    }

    if (empty($_POST['city_name'])) {
        $valid = 0;
        $error_message .= "City name cannot be empty<br>";
    }

    if ($valid == 1) {
        $city_id = $_REQUEST['id'];
        $city_name = trim($_POST['city_name']);
        $state_id = $_POST['state_id'];

        // Update city name and state_id
        $statement = $pdo->prepare("UPDATE tbl_city SET city_name = ?, state_id = ? WHERE city_id = ?");
        $statement->execute([$city_name, $state_id, $city_id]);

        // Generate slug from city name
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower($city_name));
        $slug_url = rtrim($slug_url, '-');

        // Update slug URL
        $stmt2 = $pdo->prepare("UPDATE tbl_city SET url = ? WHERE city_id = ?");
        $stmt2->execute([$slug_url, $city_id]);

        $success_message = 'City updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit City</h1>
    </div>
    <div class="content-header-right">
        <a href="city.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-12">

        <?php if($error_message): ?>
        <div class="callout callout-danger">
            <p><?php echo $error_message; ?></p>
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
                        <label class="col-sm-3 control-label">State Name <span>*</span></label>
                        <div class="col-sm-4">
                            <select name="state_id" class="form-control select2 state-cat">
                                <option value="">Select State</option>
                                <?php
                                // Fetch all states
                                $stmtStates = $pdo->prepare("SELECT * FROM tbl_state ORDER BY state_name ASC");
                                $stmtStates->execute();
                                $allStates = $stmtStates->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($allStates as $st) {
                                    $selected = ($st['state_id'] == $state_id) ? 'selected' : '';
                                    echo '<option value="'.$st['state_id'].'" '.$selected.'>'.$st['state_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">City Name <span>*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="city_name" value="<?php echo htmlspecialchars($city_name); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
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
