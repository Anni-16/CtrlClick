<?php include('./admin/inc/config.php');

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
    <script src="js/respond.js"></script>
</head>

<body>

    <div class="page-wrapper">


        <!-- Preloader -->
        <!-- <div class="preloader">
			<div class="icon"></div>
		</div> -->

        <!-- Main Header -->
        <?php include('include/header.php'); ?>
        <!-- End Main Header -->

        <!--Mobile Menu-->
        <div class="side-menu__block">


            <div class="side-menu__block-overlay custom-cursor__overlay">
                <div class="cursor"></div>
                <div class="cursor-follower"></div>
            </div><!-- /.side-menu__block-overlay -->
            <div class="side-menu__block-inner ">
                <div class="side-menu__top justify-content-end">

                    <a href="#" class="side-menu__toggler side-menu__close-btn"><img src="images/icons/close-1-1.png"
                            alt=""></a>
                </div><!-- /.side-menu__top -->


                <nav class="mobile-nav__container">
                    <!-- content is loading via js -->
                </nav>
                <div class="side-menu__sep"></div><!-- /.side-menu__sep -->
                <div class="side-menu__content">
                    <p>Linoor is a premium Template for Digital Agencies, Start Ups, Small Business and a wide range of
                        other agencies.</p>
                    <p><a href="mailto:needhelp@linoor.com">needhelp@linoor.com</a> <br> <a href="tel:888-999-0000">888
                            999 0000</a></p>
                    <div class="side-menu__social">
                        <a href="#"><i class="fab fa-facebook-square"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div><!-- /.side-menu__content -->
            </div><!-- /.side-menu__block-inner -->
        </div><!-- /.side-menu__block -->

        <!--Search Popup-->
        <div class="search-popup">
            <div class="search-popup__overlay custom-cursor__overlay">
                <div class="cursor"></div>
                <div class="cursor-follower"></div>
            </div><!-- /.search-popup__overlay -->
            <div class="search-popup__inner">
                <form action="#" class="search-popup__form">
                    <input type="text" name="search" placeholder="Type here to Search....">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div><!-- /.search-popup__inner -->
        </div><!-- /.search-popup -->

        <!-- Banner Section -->
        <section class="page-banner">
            <div class="image-layer" style="background-image:url(images/background/image-7.jpg);"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1>PACKAGE-DETAILS</h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index-main.html">Home</a></li>
                                <li class="active">Package-Details</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner Section -->
        <?php
        // Get subcategory ID from URL
        $sub_cat_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // If no sub_cat_id provided, redirect or show error
        if ($sub_cat_id <= 0) {
            echo "<p style='text-align:center;color:red;'>Invalid subcategory ID.</p>";
            exit;
        }

        // Get subcategory name (optional, for heading)
        $sub_statement = $pdo->prepare("SELECT plan_sub_cat_name FROM tbl_plan_sub_category WHERE plan_sub_cat_id = ?");
        $sub_statement->execute([$sub_cat_id]);
        $sub_row = $sub_statement->fetch(PDO::FETCH_ASSOC);
        $sub_cat_name = $sub_row ? $sub_row['plan_sub_cat_name'] : "Packages";
        ?>

        <main class="pricing-one" id="package-pricing">
            <div class="auto-container">
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h2 style="color:#01395c;"><?= ($sub_cat_name) ?> - Packages</h2>
                    </div>

                    <?php
                    // Fetch packages under the selected subcategory
                    $statement = $pdo->prepare("
                SELECT 
                    t1.package_id, 
                    t1.package_title, 
                    t1.package_description,
                    t2.plan_type_id,
                    t2.plan_type_name,
                    t2.plan_type_price,
                    t2.plan_type_duration,
                    t3.plan_sub_cat_name,
                    t4.plan_cat_name
                FROM tbl_package t1
                JOIN tbl_plan_type t2 ON t1.plan_type_id = t2.plan_type_id
                JOIN tbl_plan_sub_category t3 ON t2.plan_sub_cat_id = t3.plan_sub_cat_id
                JOIN tbl_plan_category t4 ON t3.plan_cat_id = t4.plan_cat_id
                WHERE t3.plan_sub_cat_id = ?
                ORDER BY t1.package_id DESC
            ");
                    $statement->execute([$sub_cat_id]);
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) === 0): ?>
                        <div class="col-12 text-center">
                            <p>No packages found for this subcategory.</p>
                        </div>
                        <?php else:
                        foreach ($result as $row):
                            $package_title = $row['package_title'];
                            $package_desc = $row['package_description'];
                            $plan_name = $row['plan_type_name'];
                            $plan_price = $row['plan_type_price'];
                            $plan_duration = $row['plan_type_duration'];
                            $plan_cat = $row['plan_cat_name'];
                            $plan_sub_cat = $row['plan_sub_cat_name'];

                            // Split features
                            $features = explode(',', $package_desc);
                        ?>
                            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                                <div class="pricing-card" style="height:100%;">
                                    <h3 style="font-size: 24px; background: #01395c; color: #fff; padding: 20px;">
                                        <?= ($plan_cat) ?><br>
                                        <?= ($plan_sub_cat) ?><br>
                                        <?= ($plan_name) ?>
                                    </h3>
                                    <div class="pricing-card__bottom" style="padding: 20px;">
                                        <ul class="package-list">
                                            <?php foreach ($features as $feature): ?>
                                                <li><i class="flaticon-check"></i> <?= (trim($feature)) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <h3 class="pricing-card__amount mt-3">
                                            $<?= ($plan_price) ?> /-
                                            <br>
                                            <span style="font-size: 20px;">Per <?= ($plan_duration) ?></span>
                                        </h3>
                                        <p style="font-size: 14px;">EXCLUSIVE OF ALL TAXES & PRICES ARE IN AUD</p>
                                        <a class="theme-btn btn-style-one mt-3" href="contact.php">
                                            <i class="btn-curve"></i>
                                            <span class="btn-title">Buy Now</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </main>

        <?php include('include/footer.php'); ?><!-- /.footer-nine -->
        <div class="footer-nine__bottom">
            <div class="auto-container">
                <p class="footer-nine__copyright">© Copyright 2022 by Layerdrops.com</p>
                <!-- /.footer-nine__copyright -->
                <div class="footer-nine__social">
                    <a href="#" class="fab fa-facebook"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-pinterest-p"></a>
                </div><!-- /.footer-nine__social -->
            </div><!-- /.auto-container -->
        </div><!-- /.footer-nine__bottom -->

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
    <script src="js/knob.js"></script>
    <script src="js/validate.js"></script>
    <script src="js/appear.js"></script>
    <script src="js/wow.js"></script>
    <script src="js/jQuery.style.switcher.min.js"></script>
    <script type="text/javascript" src="../../cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.min.js">
    </script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/custom-script.js"></script>


    <script src="js/lang.js"></script>
    <script src="../../translate.google.com/translate_a/elementa0d8.js?cb=googleTranslateElementInit"></script>
    <script src="js/color-switcher.js"></script>

</body>


<!-- Mirrored from layerdrops.com/linoorhtml/contact-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 23 May 2023 11:10:17 GMT -->

</html>