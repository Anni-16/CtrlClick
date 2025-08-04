<?php
include('./admin/inc/config.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $plan_sub_cat_id = (int)$_GET['plan_sub_cat_id']; // This is the correct value passed via GET

    $statement = $pdo->prepare("SELECT * FROM tbl_plan_sub_category WHERE plan_sub_cat_id = ?");
    $statement->execute([$plan_sub_cat_id]); // Use $url here

    $pack_cat = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$pack_cat) {
        header('Location: package.php');
        exit;
    }

    $cat_id = $pack_cat['sub_id'];
    $cat_name = $pack_cat['pack_sub_cat_name']; // Updated name column usage
} else {
    header('Location: package.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>CtrlClick - Smart Web Development Agency | Australia </title>
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;family=Teko:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <link href="css/owl.css" rel="stylesheet">
    <link href="css/flaticon.css" rel="stylesheet">
    <link href="css/linoor-icons-2.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="css/hover.css" rel="stylesheet">
    <link href="css/custom-animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- rtl css -->
    <link href="css/rtl.css" rel="stylesheet">
    <!-- Responsive File -->
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/mycss.css" rel="stylesheet">

    <!-- Color css -->
    <link rel="stylesheet" id="jssDefault" href="css/colors/color-default.css">

    <link rel="shortcut icon" href="images/favicon.png" id="fav-shortcut" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" id="fav-icon" type="image/x-icon">

    <!-- Responsive Settings -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!-- [if lt IE 9]><script src="js/respond.js"></script><![endif] -->
</head>

<body>

    <div class="page-wrapper">
        <?php include('include/header.php'); ?>

        <!-- Banner -->
        <section class="page-banner">
            <div class="image-layer" style="background-image:url(images/background/image-7.jpg);"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1><?= htmlspecialchars($cat_name); ?></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li>Packages</li>
                                <li class="active"><?= htmlspecialchars($cat_name); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Package Plans Section -->
        <main class="pricing-one" style="padding: 0 !important;">
            <div class="container">
                <div id="wizard_container">
                    <form name="packageForm" id="wrapped" method="POST">
                        <input id="website" name="website" type="text" value=""> <!-- Honeypot for spam bots -->

                        <div id="middle-wizard">
                            <div class="step" data-state="branchtype">
                                <div class="question_title">
                                    <h3 style="color: #01395c; text-align:center;" id="header"><?= htmlspecialchars($cat_name); ?></h3>
                                    <p style="text-align:center; padding-bottom:50px;">
                                        Choose a plan below. Some services have additional branches.
                                    </p>
                                </div>

                                <div class="row">
                                    <?php
                                    $stmtPlans = $pdo->prepare("SELECT * FROM tbl_package_plan_type WHERE sub_id = ?");
                                    $stmtPlans->execute([$cat_id]);
                                    $plan_types = $stmtPlans->fetchAll(PDO::FETCH_ASSOC);

                                    if (!empty($plan_types)) {
                                        foreach ($plan_types as $index => $plan) {
                                            $plan_name = htmlspecialchars($plan['plan_type_name']);
                                            $plan_id = $plan['plan_id'];
                                            $plan_price = htmlspecialchars($plan['plan_price']);
                                            $plan_duration = htmlspecialchars($plan['plan_durations']);
                                    ?>
                                            <div class="col-sm-12 col-md-6 col-lg-4">
                                                <div class="pricing-card-wrapper" style="box-shadow: rgba(99,99,99,0.2) 0px 2px 8px 0px;">
                                                    <div class="pricing-card" style="background: #fff; padding: 0;">
                                                        <h3 class="pricing-card__amount" style="font-size: 35px; background:#01395c; color:#fff; padding:20px 0;">
                                                            <img src="./images/my-image/rocket.png" alt="Plan Icon" style="padding-bottom: 10px;" width="70px"><br>
                                                            <?= $plan_name ?>
                                                        </h3>

                                                        <div class="pricing-card__bottom">
                                                            <ul class="package-list">
                                                                <?php
                                                                $stmtPackages = $pdo->prepare("SELECT * FROM tbl_package WHERE plan_id = ?");
                                                                $stmtPackages->execute([$plan_id]);
                                                                $packages = $stmtPackages->fetchAll(PDO::FETCH_ASSOC);

                                                                if (!empty($packages)) {
                                                                    foreach ($packages as $pkg) {
                                                                        $features = explode(',', $pkg['pack_features']);
                                                                        foreach ($features as $feature) {
                                                                            echo '<li><i class="flaticon-check"></i> ' . htmlspecialchars(trim($feature)) . '</li>';
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo '<li>No package features available.</li>';
                                                                }
                                                                ?>
                                                            </ul>

                                                            <h3 class="pricing-card__amount" style="margin: 20px 0 10px;">
                                                                $<?= $plan_price ?> <br>
                                                                <span style="font-size: 30px;">Per <?= $plan_duration ?></span>
                                                            </h3>
                                                            <p style="padding:0 10px;">Exclusive of all taxes. Prices are in AUD.</p>
                                                            <a class="theme-btn btn-style-one" href="contact.html" style="margin-top: 20px;">
                                                                <i class="btn-curve"></i><span class="btn-title">Buy Now</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<div class="col-12"><p class="text-center">No plans available under this category.</p></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>


        <?php include('include/footer.php'); ?>
    </div>

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- Scripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom-script.js"></script>
    <script src="js/popup-effect/main.js"></script>
    <script>
        var validateForm = function() {
            var checks = $('input[type="checkbox"]:checked').map(function() {
                return $(this).val();
            }).get()
            console.log(checks);
            return false;
        }
    </script>

</body>

</html>