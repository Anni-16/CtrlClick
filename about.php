<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

$statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $heading = $row['heading'];
    $sub_heading = $row['sub_heading'];
    $content = $row['content'];
    $description = $row['description'];
    $our_mission = $row['our_mission'];
    $our_vision = $row['our_vision'];
    $meta_title = $row['meta_title'];
    $meta_keyword = $row['meta_keyword'];
    $meta_desc = $row['meta_desc'];
    $about_image_1 = $row['about_image_1'];
    $about_image_2 = $row['about_image_2'];
    $alt_tag = $row['alt_tag'];
    $alt_tag_2 = $row['alt_tag_2'];
}
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title><?= !empty($meta_title) ? $meta_title : $heading; ?></title>


<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="DexignZone">
<meta name="robots" content="index, follow">
<meta name="format-detection" content="telephone=no">

<meta name="title" content="<?= $meta_title; ?>">
<meta name="keywords" content="<?= $meta_keyword; ?>">
<meta name="description" content="<?= $meta_desc; ?>">

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
                        <h1 id="yellow-color">About </h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">About</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Banner Section -->


        <!--About Section-->
        <section class="about-section" id="about">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Image Column-->
                    <div class="image-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="image-block wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms"><img src="./admin/uploads/about/<?php echo $about_image_1; ?>" alt="<?= $alt_tag; ?>"></div>
                            <div class="image-block wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms"><img src="./admin/uploads/about/<?php echo $about_image_2; ?>" alt="<?= $alt_tag_2; ?>"></div>
                        </div>
                    </div>
                    <!--Text Column-->
                    <div class="text-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2><?= $heading; ?></h2>
                                <div class="lower-text"><?= $sub_heading; ?></div>
                            </div>
                            <div class="text">
                                <p><?= $content; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="text-column col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="text">
                                <p><?= $description; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--About Section-->
        <section class="" style="background-color: #01395c; padding: 100px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 style="text-align: center; color: #ffffff;">OUR MISSION</h2>
                        <p style="text-align: center; color: #ffffff;"><?= $our_mission; ?></p>
                    </div>
                </div>
            </div>
        </section>


        <!--About Section-->
        <section class="" style="background-color: #ffffff; padding: 100px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 style="text-align: center; ">OUR Vision</h2>
                        <p style="text-align: center;  "><?= $our_vision; ?></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section -->

        <!--Services Section-->
        <section class="services-section" style="background-color: #01395c;">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Title Block-->
                    <div class="title-block col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2 style="text-align: center; ">Our Services <span class="dot">.</span></h2>
                                <div class="lower-text" style="text-align: center; padding: 0; padding-bottom: 20px;">We
                                    are committed to
                                    providing our
                                    customers with exceptional
                                    service while offering our employees the best training.</div>
                            </div>
                        </div>
                    </div>
                    <!--Service Block-->
                    <?php
                    $i = 0;
                    $statement = $pdo->prepare("SELECT * FROM tbl_service WHERE status = 1 ORDER BY ser_id DESC LIMIT 8");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                        $ser_heading = $row['ser_heading'];
                        $ser_icon = $row['ser_icon'];
                        $ser_image = $row['ser_image'];
                    ?>
                        <!--Service Block-->
                        <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="bottom-curve"></div>
                                <a href="service-details.php?url=<?= $row['url']; ?>">
                                    <div class="icon-box">
                                        <i class="<?= $ser_icon; ?> service-icon-style" style="font-size:70px;"></i>
                                    </div>
                                </a>
                                <h6><a href="service-details.php?url=<?= $row['url']; ?>"><?= $ser_heading; ?></a></h6>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="link-box" style="display: flex; justify-content: center;">
                    <a class="theme-btn btn-style-one" href="service.php">
                        <i class="btn-curve"></i>
                        <span class="btn-title" style="color: #01395c; background:#fff  ;">View All</span>
                    </a>
                </div>
            </div>
        </section>
        <!-- Services Section End -->


        <!-- Testimotrial section -->
        <section class="news-two" style="background: url(./images/background/pattern-2.png);">
            <div class="auto-container">
                <div class="sec-title-two text-center">
                    <h2 style="font-weight: 400;">Customer feedbacks<span class="dot">.</span></h2>
                    <div class="text">Lorem Ipsum is simply proin gravida nibh vel velit auctor aliquet.
                        Aenean sollicitudin, lorem is simply free text quis bibendum.</div>
                </div>
                <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "spaceBetween": 0, "loop": true, "slidesPerGroup": 2,
                        "pagination": {
                            "el": "#news-two-pagination",
                            "type": "bullets",
                            "clickable": true
                        },
                        "autoplay": {
                            "delay": 5000
                        },
                        "breakpoints": {
                            "0": {
                                "slidesPerView": 1,
                                "slidesPerGroup": 1,
                                "spaceBetween": 0
                            },
                            "768": {
                                "slidesPerView": 2,
                                "slidesPerGroup": 1,
                                "spaceBetween": 30
                            },
                            "1920": {
                                "slidesPerView": 2,
                                "slidesPerGroup": 1,
                                "spaceBetween": 30
                            }
                        }
                    }'>
                    <div class="swiper-wrapper">
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE status = 1 ORDER BY testimonial_id DESC");

                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            $testimonial_name = $row['testimonial_name'];
                            $testimonial_desi = $row['testimonial_desi'];
                            $testimonial_rating = $row['testimonial_rating'];
                            $testimonial_image = $row['testimonial_image'];
                            $testimonial_content = $row['testimonial_content'];
                        ?>
                            <div class="swiper-slide">
                                <div class="testi-block">
                                    <div class="inner">
                                        <div class="icon">
                                            <span style="float:right; font-size:30px;">
                                                <?php echo str_repeat('&#9733;', $testimonial_rating); ?>
                                            </span>
                                        </div>
                                        <div class="info">
                                            <div class="image"><img src="./admin/uploads/testimonial/<?= $testimonial_image; ?>" alt="<?= $testimonial_name; ?>"></div>
                                            <div class="name"><?= $testimonial_name; ?></div>
                                            <div class="designation"><?= $testimonial_desi; ?></div>
                                        </div>
                                        <div class="text"><?= $testimonial_content; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination" id="news-two-pagination"></div>
                </div>
            </div>
        </section>

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
</body>

</html>