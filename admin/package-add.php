<?php
require_once('header.php');
require_once('inc/config.php');

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['plan_cat_id'])) {
        $valid = 0;
        $error_message .= "Please select a Plan Category.<br>";
    }
    if (empty($_POST['plan_sub_cat_id'])) {
        $valid = 0;
        $error_message .= "Please select a Plan Sub Category.<br>";
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
            // Combine the descriptions with their statuses into an unordered list
            $descriptions = '<ul>';
            foreach ($_POST['package_description'] as $index => $desc) {
                $status = isset($_POST['package_desc_status'][$index]) ? $_POST['package_desc_status'][$index] : 'normal';
                $descriptions .= '<li data-status="' . $status . '">' . $desc . '</li>';
            }
            $descriptions .= '</ul>';

            // Insert into the tbl_package table
            $stmt = $pdo->prepare("INSERT INTO tbl_package (plan_cat_id, plan_sub_cat_id, plan_type_id, package_title, plan_price, plan_duration, package_description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['plan_cat_id'],
                $_POST['plan_sub_cat_id'],
                $_POST['plan_type_id'],
                $_POST['package_title'],
                $_POST['plan_price'],
                $_POST['plan_duration'],
                $descriptions
            ]);

            $package_id = $pdo->lastInsertId();

            // Generate slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['package_title'])));
            $slug_url = rtrim($slug_url, '-');

            $statement = $pdo->prepare("UPDATE tbl_package SET url=? WHERE package_id=?");
            $statement->execute([$slug_url, $package_id]);

            $success_message = 'Package added successfully.';
        } catch (PDOException $e) {
            $error_message = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Packages</h1>
    </div>
    <div class="content-header-right">
        <a href="package.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message) : ?>
                <div class="callout callout-danger">
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message) : ?>
                <div class="callout callout-success">
                    <p><?= $success_message ?></p>
                </div>
            <?php endif; ?>

            <form method="post" class="form-horizontal">
                <input type="hidden" name="form1" value="1">

                <div class="box box-info">
                    <div class="box-body">

                        <!-- Plan Category -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plans Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_cat_id" class="form-control select2" id="plan-cat">
                                    <option value="">Select Plans Category Name</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['plan_cat_id'] . '">' . $row['plan_cat_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Plan Sub Category -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plans Sub Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_sub_cat_id" class="form-control select2" id="plan-sub-cat">
                                    <option value="">Select Plan Sub Category Name</option>
                                </select>
                            </div>
                        </div>

                        <!-- Plan Type -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plan Type <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="plan_type_id" id="plan-type" class="form-control select2">
                                    <option value="">Select Plan Type</option>
                                </select>
                            </div>
                        </div>

                        <!-- Package Title -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Package Title <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="package_title" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Plan Price -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plan Price</label>
                            <div class="col-sm-4">
                                <input type="text" name="plan_price" id="plan-price" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Plan Duration -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Plan Duration</label>
                            <div class="col-sm-4">
                                <input type="text" name="plan_duration" id="plan-duration" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Package Description -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Package Description <span>*</span></label>

                            <div class="col-sm-7" id="description-container">
                                <div class="desc-item mb-3" style="display: flex; gap: 5px; align-items: center;">
                                    <input type="text" name="package_description[]" class="form-control" placeholder="Enter description" />
                                    <input type="hidden" name="package_desc_status[]" value="normal" class="desc-status" />

                                    <button type="button" class="btn btn-success btn-sm mark-correct" title="Correct">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm mark-wrong" title="Wrong">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm remove-desc" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary" id="add-description">Add Description</button>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-success">Submit</button>
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

        // Template for a new description input
        function getDescField() {
            return `
        <div class="desc-item mb-3" style="display: flex; gap: 5px; align-items: center;">
            <input type="text" name="package_description[]" class="form-control" placeholder="Enter description" />
            <input type="hidden" name="package_desc_status[]" value="normal" class="desc-status" />
            <button type="button" class="btn btn-success btn-sm mark-correct" title="Correct">
                <i class="fa fa-check"></i>
            </button>
            <button type="button" class="btn btn-warning btn-sm mark-wrong" title="Wrong">
                <i class="fa fa-times"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm remove-desc" title="Delete">
                <i class="fa fa-trash"></i>
            </button>
        </div>`;
        }

        // Add Description
        $("#add-description").on("click", function() {
            $("#description-container").append(getDescField());
        });

        // Remove Description
        $("#description-container").on("click", ".remove-desc", function() {
            $(this).closest(".desc-item").remove();
        });

        // Mark Correct
        $("#description-container").on("click", ".mark-correct", function() {
            let container = $(this).closest(".desc-item");
            container.find(".desc-status").val("correct");
            let input = container.find("input[type='text']");
            input.css({
                "border": "2px solid green",
                "background-color": "#e6ffe6"
            });
        });

        // Mark Wrong
        $("#description-container").on("click", ".mark-wrong", function() {
            let container = $(this).closest(".desc-item");
            container.find(".desc-status").val("wrong");
            let input = container.find("input[type='text']");
            input.css({
                "border": "2px solid red",
                "background-color": "#ffe6e6"
            });
        });

    });
</script>