<?php
include('./admin/inc/config.php');

// Check for 'url' parameter in GET request
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Prepare SQL statement to fetch blog details by URL
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE url = ? AND status = 1");
    $statement->execute([$url]);
    $blog = $statement->fetch(PDO::FETCH_ASSOC);

    // If blog not found, redirect to main blog listing page
    if (!$blog) {
        header('Location: blog.php');
        exit;
    }

    // Assign Blog Details
    $b_name         = $blog['b_name'];
    $b_image        = $blog['b_image'];
    $b_description  = $blog['b_description'];
    $b_meta_title   = $blog['b_meta_title'];
    $b_meta_keyword = $blog['b_meta_keyword'];
    $b_meta_desc    = $blog['b_meta_desc'];
    $create_at      = $blog['created_at'];

    // Canonical URL (optional)
    $canonicalUrl = "https://ctrlclick.com.au/blog-details.php?url=" . urlencode($blog['url']);

    // Format Date
    $formattedDate = date("j F Y", strtotime($create_at));
} else {
    // Redirect if 'url' parameter is missing
    header('Location: blog.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= !empty($b_meta_title) ? $b_meta_title : $b_name; ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="format-detection" content="telephone=no">

    <meta name="title" content="<?= $b_meta_title; ?>">
    <meta name="keywords" content="<?= $b_meta_keyword; ?>">
    <meta name="description" content="<?= $b_meta_desc; ?>">

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
                        <h1 id="yellow-color"><?= $b_name; ?></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="blog.php">Blog</a></li>
                                <li class="active"><?= $b_name; ?></li>
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
                                    <div class="image-box">
                                        <img src="./admin/uploads/blog/<?= $b_image; ?>" alt="<?= $b_name; ?>">
                                    </div>
                                    <div class="lower-box">
                                        <div class="post-meta">
                                            <ul class="clearfix">
                                                <li><span class="far fa-clock"></span> <?= $formattedDate; ?></li>
                                                <li><span class="far fa-user-circle"></span> Admin</li>
                                            </ul>
                                        </div>
                                        <h4><?= $b_name; ?></h4>
                                        <div class="text">
                                            <p><?= $b_description; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Sidebar Side-->
                    <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                        <aside class="sidebar blog-sidebar">
                            <!--Sidebar Widget-->
                            <div class="sidebar-widget search-box">
                                <div class="widget-inner">
                                    <form method="post" action="http://layerdrops.com/linoorhtml/blog.html">
                                        <div class="form-group">
                                            <input type="search" name="search-field" value="" placeholder="Search" required="" style="color: white;">
                                            <button type="submit"><span class="icon flaticon-magnifying-glass-1" style="color: white;"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="sidebar-widget recent-posts">
                                <div class="widget-inner" style="background-color: #01395c;">
                                    <div class="sidebar-title">
                                        <h4 style="color: white;">Recents Posts</h4>
                                    </div>
                                    <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE status = 1 ORDER BY created_at DESC LIMIT 4");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $i++;
                                        $b_name = $row['b_name'];
                                        $b_image = $row['b_image'];
                                    ?>
                                        <div class="post">
                                            <a href="blog-details.php?url=<?= $b_name; ?>">
                                                <figure class="post-thumb">
                                                    <img src="./admin/uploads/blog/<?= $b_image; ?>" alt="<?= $b_name; ?>">
                                                </figure>
                                            </a>
                                            <h5 class="text">
                                                <a href="blog-details.php?url=<?= $row['url'] ; ?>" style="color: white !important;"><?= $b_name; ?>
                                                    <br><span><?= $formattedDate; ?></span></a>
                                            </h5>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="sidebar-widget archives">
                                <div class="widget-inner" style="background-color: #01395c !important;">
                                    <div class="sidebar-title">
                                        <h4 style="color: white;">Latest Blog</h4>
                                    </div>
                                    <ul>
                                        <?php
                                        $i = 0;
                                        $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE status = 1 ORDER BY b_id ASC LIMIT 14");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                            $b_name = $row['b_name'];
                                        ?>
                                            <li><a href="blog-details.php?url=<?= $row['url'] ; ?>" style="color: #ffffff;"><?= $b_name; ?></a></li>
                                        <?php } ?>
                                        <li><a href="blog.php" style="color: #ffffff;">View All </a></li>
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