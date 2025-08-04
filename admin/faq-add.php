<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';
    $success_message = '';

    if (empty($_POST['faq_title'][0])) {
        $valid = 0;
        $error_message .= 'Question cannot be empty<br>';
    }

    if (empty($_POST['faq_content'][0])) {
        $valid = 0;
        $error_message .= 'Answer cannot be empty<br>';
    }

    if ($valid == 1) {
        foreach ($_POST['faq_title'] as $key => $title) {
            if (!empty($title) && !empty($_POST['faq_content'][$key])) {
                $statement = $pdo->prepare("INSERT INTO tbl_faq (faq_title, faq_content) VALUES (?, ?)");
                $statement->execute(array($title, $_POST['faq_content'][$key]));
            }
        }
        $success_message = 'FAQ(s) added successfully!';
        unset($_POST['faq_title']);
        unset($_POST['faq_content']);
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add FAQ</h1>
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
                        <!-- Initial FAQ Fields -->
                        <div id="faqContainer">
                            <div class="faq-item">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Question <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" autocomplete="off" class="form-control" name="faq_title[]" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Answer <span>*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="faq_content[]" placeholder="Enter Content" style="height:200px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-9">
                                        <button type="button" class="btn btn-danger btn-xs deleteFaq">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button to Add New FAQ -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <button type="button" id="addNewFaq" class="btn btn-warning">Add FAQ</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
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
