<?php
include('./admin/inc/config.php');
// Check for 'url' parameter in GET request
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Prepare SQL statement to fetch blog details by URL
    $statement = $pdo->prepare("SELECT * FROM tbl_state WHERE state_cap_url = ? AND  state_font_display = 1");
    $statement->execute([$url]);
    $blog = $statement->fetch(PDO::FETCH_ASSOC);

    // If blog not found, redirect to main blog listing page
    if (!$blog) {
        header('Location: index.php');
        exit;
    }
    // Assign Blog Details
    $state_id = $blog['state_id'];
    $state_capital = $blog['state_capital'];
    $state_name = $blog['state_name'];

    // Canonical URL (optional)
    $canonicalUrl = "https://ctrlclick.com.au/state.php?url=" . urlencode($blog['state_cap_url']);
} else {
    // Redirect if 'url' parameter is missing
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CtrlClick - Smart Web Development Agency | Australia </title>
    <meta name="description" content="Terms & Condition | Smart Web Design Agency| Australia">
    <meta name="keywords" content="Terms & Condition | Smart Web Design Agency| Australia">

    <!-- Canonical Tag -->
    <link rel="canonical" href="<?= $canonicalUrl; ?>" />

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;family=Teko:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
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

    <!-- Color css -->
    <link rel="stylesheet" id="jssDefault" href="css/colors/color-default.css">

    <link rel="shortcut icon" href="images/favicon.png" id="fav-shortcut" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" id="fav-icon" type="image/x-icon">

    <!-- Responsive Settings -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- fontawesome cnd links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .sidebar .recent-posts .post-thumb {
            width: 70px;
            height: 70px;
            border-radius: 50% !important;
        }

        .sidebar .recent-posts .post-thumb img {
            border-radius: 50% !important;
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
    </style>

</head>

<body>

    <div class="page-wrapper">
        <!-- Main Header -->
        <?php include('include/header.php'); ?>
        <!-- End Main Header -->

        <!-- Banner Section -->
        <section class="page-banner">
            <div class="image-layer" style="background-image:url(images/background/image-7.jpg);"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1 id="yellow-color">Website Designing In <?= $state_capital; ?> </h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">Website Designing In <?= $state_capital; ?> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner Section -->

        <div class="sidebar-page-container">
            <div class="auto-container">
                <div class="row clearfix">

                    <!--Content Side-->
                    <div class="content-side col-lg-8 col-md-12 col-sm-12">
                        <div class="blog-details">
                            <!--News Block-->
                            <div class="post-details">
                                <div class="inner-box">
                                    <div class="lower-box">
                                        <h4>Website Designing In <?= $state_capital; ?></h4>
                                        <div class="text">
                                            <p>Website Development in Brisbane, Gold Coast & Sunshine Coast
                                                As a leading <?= $state_capital; ?> website development company, Ctrl Click builds powerful, performance-driven websites tailored for local industries across Brisbane, Gold Coast, and the Sunshine Coast. From tourism operators to service-based businesses, we create fast, mobile-responsive, and visually compelling websites that help you connect, convert, and grow.

                                                Proud to be recognized as an Australia trusted website design company, we combine clean code, local SEO strategy, and seamless functionality to ensure your site delivers results — not just traffic.</p>
                                        </div>
                                        <h5>Why Choose Ctrl Click?</h5>
                                        <div class="text">
                                            <p>Australia’s trusted website design company
                                                Secure, scalable, and future-ready
                                                Proven results across industries
                                                Specialists in WordPress, Shopify, Webflow & custom CMS
                                                Fast, responsive, and SEO-optimized</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Sidebar Side-->
                    <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                        <aside class="sidebar blog-sidebar">
                            <div class="sidebar-widget archives">
                                <div class="widget-inner" style="background-color: #01395c !important;">
                                    <div class="sidebar-title">
                                        <h4 style="color: white;"><?= $state_capital;?> Belong - City </h4>
                                    </div>
                                    <ul>
                                        <?php
                                        $city_stmt = $pdo->prepare("SELECT * FROM tbl_city WHERE state_id = ? ORDER BY city_name ASC");
                                        $city_stmt->execute([$state_id]);
                                        $cities = $city_stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($cities as $city) {
                                        ?>

                                            <li><a href="city-details.php?url=<?= $city['url']; ?>" style="color: #ffffff;"><?= $city['city_name']; ?></a></li>
                                            <?php } ?>
                                            <li><a href="city.php" style="color: #ffffff;">View All</a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Start -->
        <?php include('include/footer.php'); ?>
        <!-- Main Footer End -->

    </div>
    <!--End pagewrapper-->

    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/TweenMax.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/owl.js"></script>
    <script src="js/mixitup.js"></script>
    <script src="js/knob.js"></script>
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

</html>