<?php require_once('header.php'); ?>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('location: faq.php');
    exit;
}

// Replace 'id' with the actual primary key column name (e.g., 'faq_id')
$faq_id = $_GET['id'];
$statement = $pdo->prepare("SELECT * FROM tbl_faq WHERE faq_id = ?");
$statement->execute([$faq_id]);
$faq = $statement->fetch(PDO::FETCH_ASSOC);

if (!$faq) {
    header('location: faq.php');
    exit;
}


if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';
    $success_message = '';

    if (empty($_POST['faq_title'][0])) {
        $valid = 0;
        $error_message .= 'At least one Question cannot be empty<br>';
    }

    if (empty($_POST['faq_content'][0])) {
        $valid = 0;
        $error_message .= 'At least one Answer cannot be empty<br>';
    }

    if ($valid == 1) {
        // Update existing FAQ
        $statement = $pdo->prepare("UPDATE tbl_faq SET faq_title = ?, faq_content = ? WHERE faq_id = ?");
        $statement->execute([$_POST['faq_title'][0], $_POST['faq_content'][0], $faq_id]);

        // Add any new FAQs
        for ($i = 1; $i < count($_POST['faq_title']); $i++) {
            if (!empty($_POST['faq_title'][$i]) && !empty($_POST['faq_content'][$i])) {
                $statement = $pdo->prepare("INSERT INTO tbl_faq (faq_title, faq_content) VALUES (?, ?)");
                $statement->execute([$_POST['faq_title'][$i], $_POST['faq_content'][$i]]);
            }
        }

        $success_message = 'FAQ(s) updated successfully!';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit FAQ</h1>
    </div>
    <div class="content-header-right">
        <a href="faq.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if ($error_message): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
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
                        <!-- Existing FAQ -->
                        <div id="faqContainer">
                            <div class="faq-item">
                                <div class="form-group">
                                    <label for="faq_title" class="col-sm-2 control-label">Question <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="faq_title[]" value="<?php echo htmlspecialchars($faq['faq_title']); ?>" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="faq_content" class="col-sm-2 control-label">Answer <span>*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="faq_content[]" placeholder="Enter Content" style="height:200px;"><?php echo htmlspecialchars($faq['faq_content']); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-9">
                                        <button type="button" class="btn btn-danger btn-xs deleteFaq">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add FAQ Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <button type="button" id="addNewFaq" class="btn btn-warning">Add FAQ</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
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
