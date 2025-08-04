<?php
include('./admin/inc/config.php');
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <title>Linoor - DIgital Agency HTML Template | Contact</title>
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;family=Teko:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
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


        <!-- Banner Section -->
        <section class="page-banner">
            <div class="image-layer" style="background-image:url(images/background/image-7.jpg);"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1>WEBSITE PACKAGES</h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index-main.html">Home</a></li>
                                <li class="active">ONLINE PAYMENT</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner Section -->


        <main class="pricing-one" style="padding: 0 !important;">
            <div class="container">
                <div id="wizard_container">
                    <form name="example-1" id="wrapped" method="POST">
                        <input id="website" name="website" type="text" value="">
                        <!-- Leave input above for security protection, read docs for details -->
                        <div id="middle-wizard">

                            <!-- Start ============================== -->
                            <div class="step" data-state="branchtype">
                                <div class="question_title">
                                    <h3 style="color: #01395c;"> WEBSITE PACKAGES</h3>
                                    <p>Selection with Branch (First Branch). Web Development have a <strong>Second
                                            Branch</strong>.</p>
                                </div>
                                <div class="row">
                                    <?php
                                    // Fetch all plan categories
                                    $statement = $pdo->prepare("SELECT plan_cat_id, plan_cat_name FROM tbl_plan_category");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $i => $row):
                                        $radioId = "static-category-" . $i;
                                        $catId = (int)$row['plan_cat_id'];
                                        $catName = ($row['plan_cat_name']);
                                    ?>
                                        <div class="col-sm-12 col-md-6 col-lg-4 form-item" id="price-main-card">
                                            <div class="pricing-card-wrapper">
                                                <label for="<?= $radioId ?>">
                                                    <div class="pricing-card">
                                                        <h3 class="pricing-card__amount" style="font-size: 35px; margin: 0;">
                                                            <img src="./images/my-image/icon/rocket.png" alt="" style="padding-bottom: 10px;" width="70px">
                                                            <br>
                                                            <?= $catName ?>
                                                        </h3>

                                                        <h4 style="margin: 10px 0; font-size: 20px;">
                                                            <a href="packages-by-category.php?id=<?= $catId ?>">View Packages</a>
                                                        </h4>

                                                        <div class="pricing-card__bottom">
                                                            <ul>
                                                                <li>
                                                                    <a href="mailto:business@firstpointcreations.com">business@firstpointcreations.com</a>
                                                                </li>
                                                                <li>
                                                                    <a href="tel:+91-9871688800">+91-9871688800</a>
                                                                </li>
                                                            </ul>

                                                            <div class="theme-btn btn-style-one" style="margin-top: 30px;">
                                                                <i class="btn-curve"></i>
                                                                <a href="package-sub-cat.php?id=<?= $catId ?>"><span class="btn-title">Select Package</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>




                            </div>
                            <!-- /row-->
                        </div>
                        <!-- /Main ============================== -->




                </div>

                </form>
            </div>
            <!-- /Wizard container -->
    </div>
    <!-- /Container -->
    </main>
    <!-- /main -->


    <!-- 
        <div class="map-box">
            <iframe class="map-iframe"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d230899.1642407818!2d145.06327708904033!3d-37.792102974783376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65cd0db468a97%3A0xb61fde84306fc38a!2sMelbourne%20Zoo!5e0!3m2!1sen!2s!4v1592307685926!5m2!1sen!2s"
                style="border:0;" aria-hidden="false" tabindex="0"></iframe>
        </div> -->


    <!-- Main Header -->
    <?php include('include/footer.php'); ?>
    <!-- End Main Header -->

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