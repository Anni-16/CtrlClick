<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['state_name'])) {
        $valid = 0;
        $error_message .= "State Name can not be empty<br>";
    }

    if ($valid == 1) {

        // updating into the database
        $statement = $pdo->prepare("UPDATE tbl_state SET state_name=?,state_capital=?,state_font_display=? WHERE state_id=?");
        $statement->execute(array($_POST['state_name'], $_POST['state_capital'], $_POST['state_font_display'], $_REQUEST['id']));


        // Create slug from POST ser_heading (not $ser_heading)
        $slug_text = $_POST['state_name'] ?? '';
        $slug_text2 = $_POST['state_capital'] ?? '';
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($slug_text)));
        $slug_url = rtrim($slug_url, '-');

        $slug_url2 = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($slug_text2)));
        $slug_url2 = rtrim($slug_url2, '-');

        // Update slug
        $statement = $pdo->prepare("UPDATE tbl_state SET url = ? , state_cap_url =? WHERE state_id = ?");
        $statement->execute([$slug_url, $slug_text2,  $_REQUEST['id']]);

        $success_message = 'State Name is updated successfully.';
    }
}
?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_state WHERE state_id=?");
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
        <h1>Edit States</h1>
    </div>
    <div class="content-header-right">
        <a href="state.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<?php
foreach ($result as $row) {
    $state_name = $row['state_name'];
    $state_capital = $row['state_capital'];
    $state_font_display = $row['state_font_display'];
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
                            <label for="" class="col-sm-3 control-label">State Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="state_name" value="<?php echo $state_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Capital City Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="state_capital" value="<?php echo $state_capital; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="state_font_display" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($state_font_display == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($state_font_display == 1) ? 'selected' : ''; ?>>Yes</option>
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