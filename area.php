<?php
include('./admin/inc/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CtrlClick - Smart Web Development Agency | Australia </title>
    <meta name="description" content="Terms & Condition | Smart Web Design Agency| Australia">
    <meta name="keywords" content="Terms & Condition | Smart Web Design Agency| Australia">

    <!-- Canonical Tag -->
    <link rel="canonical" href="https://ctrlclick.com.au/area.php" />

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

        #find_list {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            gap: 0 20px;
        }

        #find_list .border-line {
            padding-left: 15px;
        }

        .az-pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        .az-link {
            display: inline-block;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .az-link:hover,
        .az-link.active {
            background-color: #01395c;
            color: #fff;
            border-color: #01395c;
        }

        .border-line {
            margin: 0 5px;
            color: #01395c;
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
                        <h1 id="yellow-color">Serving You Locally with Expert Website Design</h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">Serving You Locally with Expert Website Design</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner Section -->


        <!-- Area Search Start -->
        <div class="sidebar-page-container">
            <div class="auto-container">
                <div class="row clearfix">

                    <!-- State Area Name -->
                    <div class="tf-sp-2 flat-animate-tab" style="margin-bottom: 80px;">
                        <div class="container">
                            <h3 class="mb-5" style=" border-bottom:1px solid #e4e4e4; padding-bottom: 30px;">Serving You Locally with Expert Website Design</h3>
                            <?php
                            // Get selected letter from URL, default to 'A'
                            $selectedLetter = isset($_GET['letter']) ? strtoupper($_GET['letter']) : 'A';

                            // Validate the letter (A-Z or #)
                            if (!preg_match('/^[A-Z]$/', $selectedLetter) && $selectedLetter !== '#') {
                                $selectedLetter = 'A';
                            }

                            // Fetch area_name and url from database
                            $statement = $pdo->prepare("SELECT area_name, url FROM tbl_area ORDER BY area_name ASC");
                            $statement->execute();
                            $areas = $statement->fetchAll(PDO::FETCH_ASSOC);

                            // Group areas alphabetically
                            $groupedAreas = [];
                            foreach ($areas as $area) {
                                $firstChar = strtoupper(substr($area['area_name'], 0, 1));
                                if (!ctype_alpha($firstChar)) {
                                    $firstChar = '#';
                                }
                                if (!isset($groupedAreas[$firstChar])) {
                                    $groupedAreas[$firstChar] = [];
                                }
                                $groupedAreas[$firstChar][] = $area;
                            }

                            // Create full alphabet array
                            $alphabet = range('A', 'Z');
                            ?>

                            <!-- Alphabetical Pagination -->
                            <div class="row mb-4">
                                <div class="col-lg-12 text-center">
                                    <div class="az-pagination">
                                        <?php foreach ($alphabet as $char) : ?>
                                            <a href="?letter=<?= $char; ?>" class="az-link <?= ($char === $selectedLetter) ? 'active' : ''; ?>"><?= $char; ?></a>
                                        <?php endforeach; ?>
                                        <?php if (isset($groupedAreas['#'])) : ?>
                                            <a href="?letter=#" class="az-link <?= ($selectedLetter === '#') ? 'active' : ''; ?>">#</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if (isset($groupedAreas[$selectedLetter])) { ?>
                                        <div class="col-lg-12 pb-5">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul id="find_list">
                                                        <?php foreach ($groupedAreas[$selectedLetter] as $areaData) { ?>
                                                            <li>
                                                                <a href="area-details.php?url=<?= urlencode($areaData['url']); ?>" class="border-right">
                                                                    <?= ($areaData['area_name']); ?>
                                                                </a>
                                                                <span class="border-line">|</span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center">No areas found for this letter.</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end Area Name -->

                </div>
            </div>
        </div>
        <!-- Area Search End -->

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