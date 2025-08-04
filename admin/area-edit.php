<?php require_once('header.php'); ?>

<?php
$error_message = "";
$success_message = "";

if (isset($_POST['form1'])) {
    $valid = 1;


    if (empty($_POST['state_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a State Name<br>";
    }

    if (empty($_POST['city_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a City Name<br>";
    }

    if (empty($_POST['area_name'])) {
        $valid = 0;
        $error_message .= "Area name can not be empty<br>";
    }

    if ($valid == 1) {
        $area_id = $_REQUEST['id'];
        $area_name = trim($_POST['area_name']);
        $city_id = $_POST['city_id'];

        // Update area name and city_id
        $statement = $pdo->prepare("UPDATE tbl_area SET area_name = ?, city_id = ? WHERE area_id = ?");
        $statement->execute([$area_name, $city_id, $area_id]);

        // Generate slug and update URL
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', strtolower($area_name));
        $slug_url = rtrim($slug_url, '-');

        $stmt2 = $pdo->prepare("UPDATE tbl_area SET url = ? WHERE area_id = ?");
        $stmt2->execute([$slug_url, $area_id]);

        $success_message = 'Area updated successfully.';
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
                                FROM tbl_area t1 
                                JOIN tbl_city t2 ON t1.city_id = t2.city_id 
                                JOIN tbl_state t3 ON t2.state_id = t3.state_id 
                                 WHERE t1.area_id=? ");
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
        <h1>Edit Areas</h1>
    </div>
    <div class="content-header-right">
        <a href="area.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<?php
foreach ($result as $row) {
    $area_name = $row['area_name'];
    $pin = $row['pin'];
    $city_id = $row['city_id'];
    $state_id = $row['state_id'];
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

            <form class="form-horizontal" action="" method="post">

                <div class="box box-info">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">State Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="state_id" class="form-control select2" id="state-cat">
                                    <option value="">Select State</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_state ORDER BY state_name ASC");
                                    $statement->execute();
                                    $result_state = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result_state as $row_state) {
                                    ?>
                                        <option value="<?php echo $row_state['state_id']; ?>" <?php if ($row_state['state_id'] == $state_id) {
                                                                                                    echo 'selected';
                                                                                                } ?>>
                                            <?php echo $row_state['state_name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">City Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="city_id" class="form-control select2" id="city-cat">
                                    <option value="">Select City</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_city WHERE state_id = ? ORDER BY city_name ASC");
                                    $statement->execute(array($state_id));
                                    $result_city = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result_city as $row_city) {
                                    ?>
                                        <option value="<?php echo $row_city['city_id']; ?>" <?php if ($row_city['city_id'] == $city_id) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                            <?php echo $row_city['city_name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Area Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="area_name" value="<?php echo $area_name; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Pin/Zip Code <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="pin" value="<?php echo $pin; ?>">
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>