<header class="main-header header-style-one">

    <!-- Header Upper -->
    <div class="header-upper">
        <div class="inner-container clearfix">
            <!--Logo-->
            <div class="logo-box" style="  padding-top:30px;">
                <div class="logo"><a href="index.php"><img src="./images/logo.png" style="width: 150px; max-height:150px;"></a></div>
            </div>
            <div class="nav-outer clearfix">
                <!--Mobile Navigation Toggler-->
                <div class="mobile-nav-toggler"><span class="icon flaticon-menu-2"></span><span class="txt">Menu</span></div>

                <!-- Main Menu -->
                <nav class="main-menu navbar-expand-md navbar-light">
                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                        <ul class="navigation clearfix">
                            <li><a href="index.php">Home</a>

                            </li>
                            <li>
                                <a href="about.php">About Us</a>
                            </li>

                            <li class="dropdown"><a href="service.php">Services</a>
                                <ul>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_service WHERE status = 1 ORDER BY ser_id DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {
                                    ?>
                                        <li><a href="service-details.php?url=<?= $row['url']; ?>"><?= $row['ser_heading']; ?></a></li>
                                    <?php } ?>
                                </ul>


                            </li>
                            <li><a href="portfolio.php">Portfolio</a>
                            </li>

                            <li class="dropdown">
                                <a href="package-list.php">Packages</a>
                                <ul>
                                    <?php

                                    $statement = $pdo->prepare("SELECT * FROM tbl_plan_category ORDER BY plan_cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) :
                                        $plan_cat_name = ($row['plan_cat_name']);
                                        $plan_cat_id = (int)$row['plan_cat_id'];

                                        if (!empty($plan_cat_name)) :
                                    ?>
                                            <li>
                                                <a href="package-sub-cat.php?id=<?= $plan_cat_id ?>">
                                                    <?= $plan_cat_name ?>
                                                </a>
                                            </li>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            </li>
                            <li><a href="blog.php">Blog</a>
                            </li>
                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <?php
            $statement = $pdo->prepare("SELECT * FROM  tbl_contact WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $phone_1 = $row['phone_1'];

            }
            ?>

            <div class="other-links clearfix">
                <div class="link-box">
                    <div class="call-us">
                        <a class="link" href="tel:61<?= $phone_1; ?>">
                            <span class="icon"></span>
                            <span class="sub-text">Call Anytime</span>
                            <span class="number">+61 <?= $phone_1; ?></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--End Header Upper-->
</header>


<div class="side-menu__block">
    <div class="side-menu__block-overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div>
    <div class="side-menu__block-inner ">
        <div class="side-menu__top justify-content-end">
            <a href="#" class="side-menu__toggler side-menu__close-btn"><img src="images/icons/close-1-1.png" alt=""></a>
        </div>
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
                <?php
                $i = 0;
                $statement = $pdo->prepare("SELECT * FROM  tbl_social WHERE status = 1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $i++;
                ?>
                    <a href="<?= $row['social_url']; ?>" target="_blank"><i class="<?= $row['social_icon']; ?>"></i></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>