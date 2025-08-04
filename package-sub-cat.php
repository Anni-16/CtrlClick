<?php
include('admin/inc/config.php');
if (isset($_GET['id'])) {
    $plan_cat_id = $_GET['id'];

    // ✅ Updated to correct table and column
    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category WHERE plan_cat_id = ?");
    $statement->execute([$plan_cat_id]);
    $plan_cat = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$plan_cat) {
        header('location: index.php');
        exit;
    }

    $cat_id = $plan_cat['plan_cat_id'];
    $cat_name = $plan_cat['plan_cat_name'];
}
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <title>CtrlClick - Smart Web Development Agency | Australia </title>
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;family=Teko:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- BASE CSS -->
    <link href="css/popup-effect/portfolio-style.css" rel="stylesheet">
    <link href="css/popup-effect/menu.css" rel="stylesheet">
    <!--for-animations-->
    <link href="css/popup-effect/vendors.min.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <link href="css/owl.css" rel="stylesheet">
    <link href="css/flaticon.css" rel="stylesheet">
    <link href="css/linoor-icons-2.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="css/hover.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jarallax.css">
    <link href="css/custom-animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/swiper.min.css" rel="stylesheet">
    <!-- rtl css -->
    <link href="css/rtl.css" rel="stylesheet">
    <!-- Responsive File -->
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/mycss.css" rel="stylesheet">
</head>

<body>

    <div class="page-wrapper">
        <!-- Main Header -->
        <?php include('include/header.php'); ?>
        <!-- End Main Header -->



        <!-- Continue your HTML as it is -->

        <section class="page-banner">
            <div class="image-layer" style="background-image:url(images/background/image-7.jpg);"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1><?= $cat_name; ?></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li>Packages</li>
                                <li class="active"><?= $cat_name; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main class="pricing-one" style="padding: 0 !important;">
            <div class="container">
                <div id="wizard_container">
                    <form name="example-1" id="wrapped" method="POST">
                        <div id="middle-wizard">
                            <div class="step" data-state="branchtype">
                                <div class="question_title">
                                    <h3 style="color: #01395c;" id="header"><?= $cat_name; ?></h3>
                                    <p style="padding-bottom: 30px;">Explore subcategories under <?= $cat_name; ?>.</p>
                                </div>

                                <div class="row">
                                    <?php
                                    // ✅ Fetch subcategories using correct foreign key
                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_sub_category WHERE plan_cat_id = ?");
                                    $statement->execute([$cat_id]);
                                    $subcategories = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($subcategories as $row) {
                                        $sub_cat_name = $row['plan_sub_cat_name'];
                                        $sub_cat_id = $row['plan_sub_cat_id'];
                                    ?>
                                        <div class="col-sm-12 col-md-6 col-lg-4 form-item" id="price-main-card">
                                            <div class="pricing-card-wrapper" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                                <div class="pricing-card" style="padding-top: 0; background:#fff;">
                                                    <h3 class="pricing-card__amount" style="font-size: 35px; margin: 0; background:#01395c; color:#fff; padding-bottom:20px;">
                                                        <img src="./images/my-image/rocket.png" alt="" style="padding-bottom: 10px;" width="70px">
                                                        <br>
                                                        <?= ($sub_cat_name); ?>
                                                    </h3>
                                                    <div class="pricing-card__bottom">
                                                        <ul>
                                                            <li><a href="mailto:business@firstpointcreations.com">business@firstpointcreations.com</a></li>
                                                            <li><a href="tel:+91-9871688800">+91-9871688800</a></li>
                                                        </ul>
                                                        <div class="theme-btn btn-style-one" style="margin-top: 30px;">
                                                            <i class="btn-curve"></i>
                                                            <a href="package-details.php?id=<?= $sub_cat_id ?>"><span class="btn-title">View Details</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <?php include('include/footer.php'); ?>


        <!-- Main Footer Start -->
        <?php include('include/footer.php'); ?>
        <!-- Main Footer End -->

    </div>
    <!--End pagewrapper-->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>



    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/TweenMax.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/owl.js"></script>
    <script src="js/mixitup.js"></script>
    <script src="js/appear.js"></script>
    <script src="js/wow.js"></script>
    <script src="js/jQuery.style.switcher.min.js"></script>
    <script type="text/javascript" src="../../cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.min.js">
    </script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/jarallax.min.js"></script>
    <script src="js/swiper.min.js"></script>
    <script src="js/custom-script.js"></script>

    <script src="js/lang.js"></script>
    <script src="../../translate.google.com/translate_a/elementa0d8.js?cb=googleTranslateElementInit"></script>


    <!-- COMMON SCRIPTS -->
    <script src="js/popup-effect/jquery-3.7.1.min.js"></script>
    <script src="js/popup-effect/common_scripts.min.js"></script>
    <script src="js/popup-effect/main.js"></script>
    <script src="js/popup-effect/wizard_func_multiple_branch.js"></script>
    <script src="js/popup-effect/my-price-calculator.js"></script>

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