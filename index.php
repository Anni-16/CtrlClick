<?php include('./admin/inc/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CtrlClick - Smart Web Development Agency | Australia </title>

    <!-- Captcha-code Css Link  -->
    <link rel="stylesheet" href="./Captcha-Code/style.css">

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
        #contact-form-bg {
            background-color: rgb(1, 57, 92);
        }

        .map-australia {
            width: 100%;
            height: auto;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 100px 0px;
        }

        .text-left {
            text-align: left ! important;
        }

        @media screen and (max-width:480px) { 
            #service-icon {
                font-size: 40px !important;
                margin-top: 50px !important;
                margin-right: 30px !important;
            }

            #services-heading{
                padding-top: 30px;
            }

            .service-block .inner-box {
                padding: 30px 20px;
            }

            #portfolio-mobile {
                height: 200px !important;
            }

            .banner-carousel h1 {
                font-size: 50px !important;
            }

            .counter-block .inner-box {
                padding-left: 0;
            }

            .counter-block .inner-box h4 {
                margin-top: 120px !important;
                text-align: center;
                margin-left: -20px;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrapper">
        <!-- Main Header -->
        <?php include('include/header.php'); ?>
        <!-- End Main Header -->

        <!-- Banner Section -->
        <section class="banner-section banner-one">

            <div class="left-based-text">
                <div class="base-inner">
                    <div class="social-links">
                        <ul class="clearfix">
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM  tbl_social WHERE status = 1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <li><a href="<?= $row['social_url']; ?>" target="_blank"><span style="padding: 10px 10px;"><?= $row['social_name']; ?></span></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="banner-carousel owl-theme owl-carousel">
                <!-- Slide Item -->
                <div class="slide-item">
                    <div class="image-layer" style="background-image: url(images/main-slider/1.jpg);"></div>
                    <div class="left-top-line"></div>
                    <div class="right-bottom-curve"></div>
                    <div class="right-top-curve"></div>
                    <div class="auto-container">
                        <div class="content-box">
                            <div class="content">
                                <div class="inner">
                                    <div class="sub-title">Welcome to Ctrl Click Crafting Websites That Win Hearts & Clients.</div>
                                    <h1 style="font-size: 105px;">Australia Leading Website Design Company</h1>
                                    <div class="link-box">
                                        <a class="theme-btn btn-style-one" href="about.php">
                                            <i class="btn-curve"></i>
                                            <span class="btn-title" style="color: #ffffff;">Discover More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide Item -->
                <div class="slide-item">
                    <div class="image-layer" style="background-image: url(images/main-slider/2.jpg);"></div>
                    <div class="left-top-line"></div>
                    <div class="right-bottom-curve"></div>
                    <div class="right-top-curve"></div>
                    <div class="auto-container">
                        <div class="content-box">
                            <div class="content">
                                <div class="inner">
                                    <div class="sub-title">Welcome to Ctrl Click. Web Design with Purpose.</div>
                                    <h1 style="font-size: 105px;">Australia Trusted Website Development Company</h1>
                                    <div class="link-box">
                                        <a class="theme-btn btn-style-one" href="about.php">
                                            <i class="btn-curve"></i>
                                            <span class="btn-title">Discover More</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!--End Banner Section -->

        <!-- About Section -->
        <section id="my-about">
            <div class="container">
                <div class="row">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="sec-title">
                            <h2 style="color: #01395c;">About Us<span class="dot">.</span></h2>

                            <div class="lower-text">
                                <p style="color: #01395c;  text-align:justify; " class="text-uppercase font-teko">
                                    <?php
                                    // Limit content to 150 words
                                    $words = explode(' ', strip_tags($row['content']));
                                    if (count($words) > 150) {
                                        echo implode(' ', array_slice($words, 0, 150)) . '...';
                                    } else {
                                        echo implode(' ', $words);
                                    }
                                    ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="link-box">
                            <a class="theme-btn btn-style-one" href="about.php">
                                <i class="btn-curve"></i>
                                <span class="btn-title" style="color: #ffffff;">Read More</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About section -->

        <!--Services Section-->
        <section class="services-section" style="background-color: #01395c;">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Title Block-->
                    <div class="title-block col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2 style="text-align: center; ">Our Services <span class="dot">.</span></h2>
                                <div class="lower-text text-uppercase" style="text-align: center; padding: 0; padding-bottom: 20px; color:#fff">Ctrl Click is Australia’s trusted web design agency, delivering high-performance websites and end-to-end development solutions for businesses of all sizes. </div>
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
                        <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-6 col-6 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="bottom-curve"></div>
                                <a href="service-details.php?url=<?= $row['url']; ?>">
                                    <div class="icon-box">
                                        <i class="<?= $ser_icon; ?> service-icon-style" style="font-size:70px;" id="service-icon"></i>
                                    </div>
                                </a>
                                <h6 id="services-heading"><a href="service-details.php?url=<?= $row['url']; ?>"><?= $ser_heading; ?></a></h6>
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

        <!--Portfolio section -->
        <section class="gallery-block-three" id="portfolio">
            <div class="auto-container">
                <div class="sec-title-two text-center">
                    <h2 style="font-weight: 400; text-transform: uppercase;">Latest Portfolio</h2>
                    <div class="lower-text text-uppercase" style="text-align: center; padding: 0; padding-bottom: 20px; color: #01395c;">Custom websites, built to perform. Explore our latest work for Australian clients.</div>
                </div>
                <div class="row">
                    <?php
                    $i = 0;
                    $statement = $pdo->prepare("SELECT * FROM tbl_portfolio WHERE p_is_featured = 1  LIMIT 4");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                    ?>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="gallery-item-three">
                                <img src="./admin/uploads/portfolio/<?= $row['p_image']; ?>" alt="<?= $row['p_name']; ?>" style="width: 100%; height:300px;" id="portfolio-mobile">
                                <div class="gallery-item-three__content">
                                    <p>Visit Website</p>
                                    <h3><a href="portfolio-details.php?url=<?= ($row['p_name']); ?>"><?= $row['p_name']; ?></a></h3>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-lg-12">
                        <div class="link-box" style="display: flex; justify-content: center;">
                            <a class="theme-btn btn-style-one" href="portfolio.php">
                                <i class="btn-curve"></i>
                                <span class="btn-title" style="color: #ffffff;">View All</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Portfolio Section -->


        <!--We DO Section-->
        <section class="we-do-section">
            <div class="auto-container">

                <div class="row">
                    <h2 style="text-align: center; padding: 0; margin: 0;">FAQ</h2>
                    <div class="lower-text text-uppercase" style="text-align: center; padding: 0; padding-bottom: 30px; color: #01395c;">Want to make your brand stand out online and attract more customers through your website?</div>
                </div>

                <div class="row clearfix">

                    <!--Left Column-->
                    <div class="left-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>We are standout <br>experts in business<span class="dot">.</span></h2>
                                <div class="lower-text text-uppercase" style="color: #01395c;">We believe that success is achieved
                                    through a highly
                                    collaborative interaction, so that we can work together to identify and evaluate
                                    opportunities beyond your current operations. </div>
                            </div>
                            <div class="counter">
                                <div class="row clearfix">
                                    <div class="counter-block col-lg-6 col-md-6 col-6">
                                        <div class="inner-box">
                                            <div class="graph-outer">
                                                <input type="text" class="dial" data-fgColor="#ffaa17" data-bgColor="none" data-width="140" data-height="140" data-linecap="normal" value="90" data-thickness="0.050">
                                                <div class="inner-text count-box"><span class="count-text" data-stop="98" data-speed="2000"></span><span class="sign">%</span></div>
                                            </div>
                                            <h4>Quality <br>Services</h4>
                                        </div>
                                    </div>
                                    <div class="counter-block col-lg-6 col-md-6 col-6">
                                        <div class="inner-box">
                                            <div class="graph-outer">
                                                <input type="text" class="dial" data-fgColor="#ffaa17" data-bgColor="none" data-width="140" data-height="140" data-linecap="normal" value="50" data-thickness="0.050">
                                                <div class="inner-text count-box"><span class="count-text" data-stop="80" data-speed="2000"></span><span class="sign">%</span></div>
                                            </div>
                                            <h4>Skilled <br>Employee</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Right Column-->
                    <!--Right Column-->
                    <div class="right-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="faq-box">
                                <ul class="accordion-box clearfix">
                                    <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_faq  ORDER BY faq_id DESC LIMIT 5");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $i++;
                                    ?>
                                        <li class="accordion block ">
                                            <div class="acc-btn "><span class="count"><?= $i; ?>.</span><?= $row['faq_title']; ?></div>
                                            <div class="acc-content ">
                                                <div class="content">
                                                    <div class="text"><?= $row['faq_content']; ?></div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- We Do Section End -->

        <!-- Counties Section  -->
        <section class="funfact-six">
            <div class="auto-container">

                <div class="row">
                    <h2 style="text-align: center; padding: 0; margin: 0; text-transform: uppercase;">Reach Out</h2>
                    <div class="lower-text text-uppercase" style="text-align: center; padding: 0; padding-bottom: 30px; color: #ffffff;">Bring your vision online with Ctrl Click let’s build your dream website together</div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="funfact-six__item">
                            <i class="funfact-six__icon flaticon-architect"></i>
                            <h3 class="funfact-six__count count-box"><span class="count-text" data-stop="20" data-speed="1500">0+</span>+
                            </h3>
                            <p class="funfact-six__text">YEARS EXPERIENCE</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_portfolio");
                        $statement->execute();
                        $total_portfolio = $statement->rowCount();
                        ?>
                        <div class="funfact-six__item">
                            <i class="funfact-six__icon flaticon-architect-1"></i>
                            <h3 class="funfact-six__count count-box"><span class="count-text" data-stop="<?= $total_portfolio; ?>" data-speed="1500">0</span>0+
                            </h3>
                            <p class="funfact-six__text">Project Completed</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="funfact-six__item">
                            <i class="funfact-six__icon flaticon-buildings"></i>
                            <h3 class="funfact-six__count count-box"><span class="count-text" data-stop="200" data-speed="1500">0</span>
                            </h3>
                            <p class="funfact-six__text">Service Providing</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <div class="funfact-six__item">
                            <i class="funfact-six__icon flaticon-satisfaction"></i>
                            <h3 class="funfact-six__count count-box"><span class="count-text" data-stop="976" data-speed="1500">0</span>0+
                            </h3>
                            <p class="funfact-six__text">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Countirs Section End -->


        <!-- Contact Form -->
        <section class="about-section-two " id="contact">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="left-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>WE ARE TRUSTED BY MORE THAN 500 CLIENTS<span class="dot">.</span></h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-6 " style="margin-top: 20px;">
                                    <div class="card" id="contact-card">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="icon">
                                                    <i class="fa fa-address-book"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">
                                                <h5 style="margin: 0;">ANALYZE PROJECT</h5>
                                                <p style="line-height: 25px; color:#01395c;">First and foremost, we assess your
                                                    project, its current stage,
                                                    competitors, and future goals.</p>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-6" style="margin-top: 20px;">
                                    <div class="card" id="contact-card">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="icon">
                                                    <i class="fa fa-address-book"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">
                                                <h5 style="margin: 0;">ANALYZE PROJECT</h5>
                                                <p style="line-height: 25px;  color:#01395c;">First and foremost, we assess your
                                                    project, its current stage,
                                                    competitors, and future goals.</p>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-6" style="margin-top: 20px;">
                                    <div class="card" id="contact-card">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="icon">
                                                    <i class="fa fa-address-book"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">
                                                <h5 style="margin: 0;">ANALYZE PROJECT</h5>
                                                <p style="line-height: 25px;  color:#01395c;">First and foremost, we assess your
                                                    project, its current stage,
                                                    competitors, and future goals.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="right-col col-xl-6 col-lg-6 col-md-12 col-sm-12 get-quote-section">
                        <div class="inner">
                            <div class="form-box wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms" style="background-color: #01395c !important;" id="contact-form-bg">
                                <div class="default-form login_form2">
                                    <h4 style="color: #ffffff;"> Get a free quote <span>.</span></h4>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <div class="field-inner">
                                                <input type="text" name="username" placeholder="Your Name" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="field-inner">
                                                <input type="email" name="email" placeholder="Email Address" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="field-inner">
                                                <input type="text" name="phone" placeholder="Phone Number" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="field-inner">
                                                <select class="custom-select-box" name="service">
                                                    <?php
                                                    $i = 0;
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_service ORDER BY ser_id DESC");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        $i++;
                                                    ?>
                                                        <option value="<?= $row['ser_id']; ?>"><?= $row['ser_heading']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="field-inner">
                                                <textarea name="message" placeholder="Write Message" style="height: 150px;"></textarea>
                                            </div>
                                        </div>

                                        <!-- Captcha -->
                                        <div id="captcha" class="form_div">
                                            <div class="preview"></div>
                                            <div class="field-inner captcha_form">
                                                <input type="text" id="captcha_form" style="background-color: #fff; font-size:16px; font-weight:900; letter-spacing :10px;" class="form_input_captcha" placeholder="Enter Code" required="">
                                                <button class="captcha_refersh" type="button">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="theme-btn btn-style-one form_button">
                                                <i class="btn-curve"></i>
                                                <span class="btn-title">Request a quote</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Contact Form -->


        <!-- Customer section -->
        <section class="news-two" style="background: url(./images/background/pattern-2.png);">
            <div class="auto-container">
                <div class="sec-title-two text-center">
                    <h2 style="font-weight: 400; text-transform: uppercase;">What Are People Say<span class="dot">.</span></h2>
                    <div class="text text-uppercase" style="color:#01395c;">Authentic reviews from clients who rely on Ctrl Click for their digital success.</div>
                </div><!-- /.sec-title-two -->
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
                                            <div class="image">
                                                <?php if (!empty($testimonial_image) && file_exists("./admin/uploads/testimonial/" . $testimonial_image)) { ?>
                                                    <img src="./admin/uploads/testimonial/<?= $testimonial_image; ?>" alt="<?= $testimonial_name ?>">
                                                <?php } else { ?>
                                                    <img src="images/logo-1.png" alt="<?= $testimonial_name ?>">
                                                <?php } ?>
                                            </div>
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

        <!--Clients Section-->
        <section class="sponsors-section we-do-section">
            <div class="row">
                <div class="col-lg-12">
                    <h2 style="font-weight: 400; text-transform: uppercase; text-align: center;   margin: 0;">
                        Our Clients<span class="dot">.</span></h2>
                    <div class="text text-uppercase" style="text-align: center;  color:#01395c; ">Ctrl Click is acknowledged by clients and partners as one of the best web design companies in Australia.</div>
                </div>
            </div>
            <div class="sponsors-outer" style="margin-top: 50px;">
                <div class="auto-container">
                    <div class="sponsors-carousel owl-theme owl-carousel">
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM  tbl_client_logo ORDER BY client_id DESC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                        ?>
                            <div class="slide-item">
                                <figure class="image-box">
                                    <a href="#">
                                        <img src="./admin/uploads/client-logo/<?= $row['client_image']; ?>" alt="<?= $row['client_name']; ?>" style="width:100%; height:100px;  opacity: 1 !important;">
                                    </a>
                                </figure>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Area We Are Serve Section  -->
        <section class="map-australia" style="background-color: #01395c;">
            <div class="auto-container">
                <div class="row" style="padding-bottom:50px;">
                    <div class="col-lg-12">
                        <h2 style="font-weight: 400; text-transform: uppercase; text-align: center; color: #ffffff; margin: 0;">
                            AERA WE ARE SERVE<span class="dot">.</span></h2>
                        <div class="text text-uppercase" style="text-align: center; color: #ffffff; ">Ctrl Click is acknowledged by clients and partners as one of the best web design companies in Australia.</div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_state WHERE state_font_display = 1 ORDER BY state_name ASC");
                    $statement->execute();
                    $states = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($states as $state) {
                    ?>
                        <div class="col-6 col-md-6 col-lg-3">
                            <a href="state.php?url=<?= $state['state_cap_url']; ?>">
                                <div class="funfact-six__item">
                                    <i class="funfact-six__icon flaticon-architect"></i>
                                    <h5 style="color: #ffffff;"><a href="state.php?url=<?= $state['state_cap_url']; ?>" style="color: #ffffff;"><?= $state['state_capital']; ?></a></h5>
                                    <?php
                                    // $city_stmt = $pdo->prepare("SELECT * FROM tbl_city WHERE state_id = ? ORDER BY city_id DESC LIMIT 4");
                                    // $city_stmt->execute([$state['state_id']]);
                                    // $cities = $city_stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // foreach ($cities as $city) {
                                    ?>
                                    <!-- <a href="city-details.php?url=<?= $city['url']; ?>">
                                        <p class="funfact-six__text" style="padding-bottom: 10px;"><?= $city['city_name']; ?></p>
                                    </a> -->
                                    <?php
                                    // } 
                                    ?>
                                    <!-- <div style="padding-top: 10px;">
                                    <a href="city.php">
                                        <p class="funfact-six__text">Veiw All</p>
                                    </a>
                                </div> -->
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <br>
        <br>
        <!-- Area We Serve Section End -->


        <!-- news section -->
        <section class="news-two" style="padding-top: 0px;">
            <div class="auto-container">
                <div class="sec-title-two text-center">
                    <h2 style="font-weight: 400;">OUR BLOG</h2>
                    <div class="text text-uppercase" style="color:#01395c;">Control Click’s guide to building better websites and stronger online presence.</div>
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
                            "slidesPerView": 3,
                            "slidesPerGroup": 1,
                            "spaceBetween": 30
                        }
                    }
                }'>
                    <div class="swiper-wrapper">
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE status = 1 ORDER BY b_id DESC LIMIT 8");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            $b_name = $row['b_name'];
                            $b_image = $row['b_image'];
                            $b_description = $row['b_description'];
                            $create_at = $row['created_at'];

                            $formattedDate = date("j F Y", strtotime($create_at));

                            $wordLimit = 30; // Set your word limit
                            $limitedContent = implode(' ', array_slice(explode(' ', $b_description), 0, min($wordLimit, str_word_count($b_description)))) . (str_word_count($b_description) > $wordLimit ? '...' : '');
                        ?>
                            <div class="swiper-slide">
                                <div class="news-two__box">
                                    <a href="blog-details.php?url=<?= $row['url']; ?>">
                                        <div class="news-two__image">
                                            <img src="./admin/uploads/blog/<?= $b_image; ?>" alt="<?= $b_name; ?>" style="width: 100%; background-size:cover; height:300px;  object-fit:cover; ">
                                        </div>
                                    </a>
                                    <div class="news-two__content">
                                        <ul class="list-unstyled news-two__meta">
                                            <li><a href="blog-details.php?url=<?= $row['url']; ?>"><?= $formattedDate; ?></a></li>
                                            <li><a href="blog-details.php?url=<?= $row['url']; ?>">Admin</a></li>
                                        </ul>
                                        <h3><a href="blog-details.php?url=<?= $row['url']; ?>"><?= $b_name; ?></a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination" id="news-two-pagination"></div>
                </div>
                <div class="col-lg-12">
                    <div class="link-box" style="display: flex; justify-content: center;">
                        <a class="theme-btn btn-style-one" href="blog.php">
                            <i class="btn-curve"></i>
                            <span class="btn-title" style="color: #ffffff;">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <!-- Main Footer Start -->
        <?php include('include/footer.php'); ?>
        <!-- Main Footer End -->

    </div>
    <!--End pagewrapper-->

    <!-- Captcha-code js link  -->
    <script src="./Captcha-Code/script.js"></script>

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