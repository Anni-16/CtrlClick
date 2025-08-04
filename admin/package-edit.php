<?php 
require_once('header.php'); 

$error_message = "";
$success_message = "";

if (isset($_GET['package_id']) && is_numeric($_GET['package_id'])) {
    $package_id = $_GET['package_id'];

    // Fetch package data
    $stmt = $pdo->prepare("SELECT * FROM tbl_package WHERE package_id = ?");
    $stmt->execute([$package_id]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {
        $error_message = "Package not found.";
    }
} else {
    $error_message = "Invalid Package ID.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['package_id'])) {
        $valid = 0;
        $error_message .= "Package ID is missing.<br>";
    }
    if (empty($_POST['plan_type_id'])) {
        $valid = 0;
        $error_message .= "Please select a Plan Type.<br>";
    }
    if (empty($_POST['package_title'])) {
        $valid = 0;
        $error_message .= "Package Title is required.<br>";
    }
    if (empty($_POST['package_description']) || !is_array($_POST['package_description'])) {
        $valid = 0;
        $error_message .= "At least one Package Description is required.<br>";
    }

    if ($valid) {
        try {
            // Combine descriptions with status into an unordered list
            $descriptions = '<ul>';
            foreach ($_POST['package_description'] as $index => $desc) {
                $status = isset($_POST['package_desc_status'][$index]) ? $_POST['package_desc_status'][$index] : 'normal';
                $descriptions .= '<li data-status="' . $status . '">' . $desc . '</li>';
            }
            $descriptions .= '</ul>';

            $stmt = $pdo->prepare("UPDATE tbl_package SET 
                plan_cat_id = ?, 
                plan_sub_cat_id = ?, 
                plan_type_id = ?, 
                package_title = ?, 
                package_description = ? 
                WHERE package_id = ?");
            $stmt->execute([ 
                $_POST['plan_cat_id'],
                $_POST['plan_sub_cat_id'],
                $_POST['plan_type_id'],
                $_POST['package_title'],
                $descriptions,
                $_POST['package_id']
            ]);

            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['package_title']))); 
            $slug_url = rtrim($slug_url, '-'); 

            $stmt2 = $pdo->prepare("UPDATE tbl_package SET url = ? WHERE package_id = ?");
            $stmt2->execute([$slug_url, $_POST['package_id']]);

            $success_message = 'Package updated successfully.';
        } catch (PDOException $e) {
            $error_message = "Database Error: " . $e->getMessage();
        }
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Package</h1>
    </div>
    <div class="content-header-right">
        <a href="package.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger"><p><?= $error_message ?></p></div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="callout callout-success"><p><?= $success_message ?></p></div>
            <?php endif; ?>

            <form method="post" class="form-horizontal">
                <input type="hidden" name="form1" value="1">
                <input type="hidden" name="package_id" value="<?= $package['package_id'] ?>">

                <div class="box box-info">
                    <div class="box-body">

                    <!-- Plan Category -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Plan Category <span>*</span></label>
                        <div class="col-sm-4">
                            <select name="plan_cat_id" class="form-control select2" id="plan-cat">
                                <option value="">Select Plan Category</option>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                                while ($row = $stmt->fetch()) {
                                    $selected = ($package['plan_cat_id'] == $row['plan_cat_id']) ? 'selected' : '';
                                    echo '<option value="' . $row['plan_cat_id'] . '" ' . $selected . '>' . $row['plan_cat_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Plan Sub Category -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Plan Sub Category <span>*</span></label>
                        <div class="col-sm-4">
                            <select name="plan_sub_cat_id" class="form-control select2" id="plan-sub-cat">
                                <option value="">Select Sub Category</option>
                                <?php
                                if (isset($package['plan_cat_id'])) {
                                    $stmt = $pdo->prepare("SELECT * FROM tbl_plan_sub_category WHERE plan_cat_id = ? ORDER BY plan_sub_cat_name ASC");
                                    $stmt->execute([$package['plan_cat_id']]);
                                    while ($row = $stmt->fetch()) {
                                        $selected = ($package['plan_sub_cat_id'] == $row['plan_sub_cat_id']) ? 'selected' : '';
                                        echo '<option value="' . $row['plan_sub_cat_id'] . '" ' . $selected . '>' . $row['plan_sub_cat_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Plan Type -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Plan Type <span>*</span></label>
                        <div class="col-sm-4">
                            <select name="plan_type_id" id="plan-type" class="form-control select2">
                                <option value="">Select Plan Type</option>
                                <?php
                                if (isset($package['plan_sub_cat_id'])) {
                                    $stmt = $pdo->prepare("SELECT * FROM tbl_plan_type WHERE plan_sub_cat_id = ? ORDER BY plan_type_name ASC");
                                    $stmt->execute([$package['plan_sub_cat_id']]);
                                    while ($row = $stmt->fetch()) {
                                        $selected = ($package['plan_type_id'] == $row['plan_type_id']) ? 'selected' : '';
                                        echo '<option value="' . $row['plan_type_id'] . '" data-name="' . $row['plan_type_name'] . '" ' . $selected . '>' . $row['plan_type_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Plan Price -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Plan Price</label>
                        <div class="col-sm-4">
                            <input type="text" id="plan-price" class="form-control" value="<?= $package['plan_price'] ?>" readonly>
                        </div>
                    </div>

                    <!-- Plan Duration -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Plan Duration</label>
                        <div class="col-sm-4">
                            <input type="text" id="plan-duration" class="form-control" value="<?= $package['plan_duration'] ?>" readonly>
                        </div>
                    </div>

                    <!-- Package Title -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Package Title <span>*</span></label>
                        <div class="col-sm-4">
                            <input type="text" name="package_title" id="package-title" class="form-control" value="<?= $package['package_title']?>" readonly>
                        </div>
                    </div>

                    <!-- Package Description -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Package Description <span>*</span></label>
                        <div class="col-sm-7" id="description-container">
                            <?php
                            if (!empty($package['package_description'])) {
                                // Extract list items and their status
                                preg_match_all('/<li(?: data-status="([^"]*)")?>(.*?)<\/li>/', $package['package_description'], $matches, PREG_SET_ORDER);
                                foreach ($matches as $match) {
                                    $status = !empty($match[1]) ? $match[1] : 'normal';
                                    $desc = $match[2];
                                    // Inline styles for correct/wrong
                                    $style = '';
                                    if ($status === 'correct') {
                                        $style = 'border:2px solid green;background-color:#e6ffe6;';
                                    } elseif ($status === 'wrong') {
                                        $style = 'border:2px solid red;background-color:#ffe6e6;';
                                    }

                                    echo '<div class="desc-item mb-3" style="display:flex;gap:5px;align-items:center;">
                                            <input type="text" name="package_description[]" class="form-control" style="'.$style.'" value="' . $desc . '" placeholder="Enter description" />
                                            <input type="hidden" name="package_desc_status[]" value="' . $status . '" class="desc-status" />
                                            <button type="button" class="btn btn-success btn-sm mark-correct" title="Correct"><i class="fa fa-check"></i></button>
                                            <button type="button" class="btn btn-warning btn-sm mark-wrong" title="Wrong"><i class="fa fa-times"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm remove-desc" title="Delete"><i class="fa fa-trash"></i></button>
                                          </div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary" id="add-description">Add Description</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-3">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php include('footer.php') ?>
<script>
$(document).ready(function() {

    function getDescField() {
        return `
        <div class="desc-item mb-3" style="display: flex; gap: 5px; align-items: center;">
            <input type="text" name="package_description[]" class="form-control" placeholder="Enter description" />
            <input type="hidden" name="package_desc_status[]" value="normal" class="desc-status" />
            <button type="button" class="btn btn-success btn-sm mark-correct" title="Correct"><i class="fa fa-check"></i></button>
            <button type="button" class="btn btn-warning btn-sm mark-wrong" title="Wrong"><i class="fa fa-times"></i></button>
            <button type="button" class="btn btn-danger btn-sm remove-desc" title="Delete"><i class="fa fa-trash"></i></button>
        </div>`;
    }

    $("#add-description").on("click", function() {
        $("#description-container").append(getDescField());
    });

    $("#description-container").on("click", ".remove-desc", function() {
        $(this).closest(".desc-item").remove();
    });

    $("#description-container").on("click", ".mark-correct", function() {
        let container = $(this).closest(".desc-item");
        let input = container.find("input[type='text']");
        container.find(".desc-status").val("correct");
        input.css({
            "border": "2px solid green",
            "background-color": "#e6ffe6"
        });
    });

    $("#description-container").on("click", ".mark-wrong", function() {
        let container = $(this).closest(".desc-item");
        let input = container.find("input[type='text']");
        container.find(".desc-status").val("wrong");
        input.css({
            "border": "2px solid red",
            "background-color": "#ffe6e6"
        });
    });

});
</script>
