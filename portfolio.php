<?php
include('./admin/inc/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CtrlClick - Smart Web Development Agency | Australia </title>
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
                        <h1 id="yellow-color">Portfolio</h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li class="active" style="color: #158cac;">Portfolio</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner Section -->

        <!-- Gallery Section -->
        <section class="gallery-section">
            <div class="auto-container">
                <div class="mixitup-gallery">
                    <!-- Filter -->
                    <!--Filter-->
                    <div class="filters centered clearfix">
                        <ul class="filter-tabs filter-btns clearfix">
                            <li class="active filter" data-role="button" data-filter="all">All</li>
                            <?php
                            // Fetch all states for filter buttons
                            $statement = $pdo->prepare("SELECT * FROM tbl_state ORDER BY state_id");
                            $statement->execute();
                            $states = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($states as $state) {
                                echo '<li class="filter" data-role="button" data-filter=".' . $state['state_id'] . '">' . $state['state_capital'] . '</li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="filter-list row">
                        <?php
                        // Join portfolio with area, city, state and industry
                        $statement = $pdo->prepare("SELECT 
                                            p.*, 
                                            s.state_id, 
                                            s.state_name, 
                                            c.city_name, 
                                            a.area_name, 
                                            i.ind_name
                                        FROM tbl_portfolio p
                                        JOIN tbl_area a ON p.area_id = a.area_id
                                        JOIN tbl_city c ON a.city_id = c.city_id
                                        JOIN tbl_state s ON c.state_id = s.state_id
                                        JOIN tbl_industry i ON p.ind_id = i.ind_id
                                        WHERE p.status = 1
                                        ORDER BY p.p_id DESC
                                    ");
                        $statement->execute();
                        $portfolios = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($portfolios as $portfolio) {
                            // Use state_id as the class for filtering
                            $state_class = $portfolio['state_id'];
                        ?>
                            <div class="gallery-item mix all <?= $state_class; ?> col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <figure class="image">
                                        <img src="./admin/uploads/portfolio/<?= $portfolio['p_image']; ?>" alt="<?= $portfolio['p_name']; ?>">
                                    </figure>
                                    <a href="./admin/uploads/portfolio/<?= $portfolio['p_image']; ?>" class="lightbox-image overlay-box" data-fancybox="gallery"></a>
                                    <div class="cap-box">
                                        <div class="cap-inner">
                                            <div>
                                                <a href="portfolio-industry.php?id=<?= urlencode($portfolio['ind_id']); ?>" style="color: #fff; text-decoration: underline;">
                                                    <?= $portfolio['ind_name']; ?>
                                                </a>

                                            </div>
                                            <div class="cat">
                                                <h5 id="yellow-color"><?= $portfolio['p_name']; ?></h5>
                                            </div>
                                            <div class="cat">
                                                <a href="<?= $portfolio['p_url']; ?>" target="_blank" style="color: #fff; text-decoration: underline;">Visit Website</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>


                </div>
            </div>
        </section>
        <!-- Portfolio Section End -->

        <!-- Include jQuery and MixItUp (If not already included) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/mixitup@3.3.1/dist/mixitup.min.js"></script>

        <script>
            $(document).ready(function() {
                // Initialize MixItUp
                var mixer = mixitup('.filter-list', {
                    selectors: {
                        target: '.gallery-item'
                    },
                    load: {
                        filter: 'all' // Default filter
                    }
                });

                // Filter click event
                $('.filter').on('click', function() {
                    var filterValue = $(this).data('filter');
                    mixer.filter(filterValue); // Apply filter based on state
                });
            });
        </script>


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
    <script src="js/color-switcher.js"></script>

    <!-- Include MixItUp library -->
    <script src="https://cdn.jsdelivr.net/npm/mixitup@3.3.1/dist/mixitup.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var container = document.querySelector('.filter-list');
            var mixer = mixitup(container);
        });
    </script>

</body>

</html>