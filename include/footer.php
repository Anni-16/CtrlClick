   <!-- Call To Section -->
   <section class="call-to-section">
       <div class="auto-container">
           <div class="inner clearfix">
               <div class="shape-1 wow slideInRight" data-wow-delay="0ms" data-wow-duration="1500ms"></div>
               <div class="shape-2 wow fadeInDown" data-wow-delay="0ms" data-wow-duration="1500ms"></div>
               <h2 style="color: #ffffff;">Let's Get Your Project <br>Started!</h2>
               <div class="link-box">
                   <a class="theme-btn btn-style-two" href="contact.php">
                       <i class="btn-curve"></i>
                       <span class="btn-title1">Contact with us</span>
                   </a>
               </div>
           </div>
       </div>
   </section>
   <!-- Call To Section End -->

   <footer class="main-footer">
       <div class="auto-container">
           <!--Widgets Section-->
           <div class="widgets-section">
               <div class="row clearfix">

                   <!--Column-->
                   <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                       <div class="footer-widget logo-widget">
                           <div class="widget-content">
                               <div class="logo">
                                   <a href="index.php"><img id="fLogo" src="images/logo.png" alt="" style="width: 160px; height:auto;"/></a>
                               </div>
                               <div class="text" style="color: #ffffff;">Ctrl Click Welcomes You Because Your Website Deserves More Than Just Pretty Pixels</div>
                               <ul class="social-links clearfix">
                                   <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_social WHERE footer = 1");
                                    $statement->execute();
                                    $socials = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($socials as $row) {
                                        $i++;
                                        $social_url = $row['social_url'];
                                        $social_icon = $row['social_icon'];
                                    ?>
                                       <?php if ($social_url != ''): ?>
                                           <li>
                                               <a href="<?= $social_url; ?>" target="_blank" rel="noopener noreferrer">
                                                   <span class="<?= $social_icon; ?>" style="color: #01395c;"></span>
                                               </a>
                                           </li>
                                       <?php endif; ?>
                                   <?php } ?>
                               </ul>
                           </div>
                       </div>
                   </div>

                   <!--Column-->
                   <div class="column col-xl-2 col-lg-6 col-md-6 col-sm-12">
                       <div class="footer-widget links-widget" style="margin: 0 !important;">
                           <div class="widget-content">
                               <h6>Explore</h6>
                               <div class="row clearfix">
                                   <div class="col-md-12 col-sm-12">
                                       <ul>
                                           <li><a href="about.php">About</a></li>
                                           <li><a href="servcie.php">Services</a></li>
                                           <li><a href="portfolio.php">Our Portfolio</a></li>
                                           <li><a href="blog.php">Latest Blogs</a></li>
                                           <li><a href="contact.php">Contact</a></li>
                                           <li><a href="terms_condition.php">Terms & Condition</a></li>
                                           <li><a href="privacy_ploicy.php">Privacy & policy </a></li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>


                   <!--Column-->
                   <div class="column col-xl-2 col-lg-6 col-md-6 col-sm-12">
                       <div class="footer-widget links-widget">
                           <div class="widget-content">
                               <h6>Service Links</h6>
                               <div class="row clearfix">
                                   <div class="col-md-12 col-sm-12">
                                       <ul>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_service ORDER BY ser_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {
                                        $ser_heading = $row['ser_heading'];
                                    ?>
                                        <li><a href="service-details.php?url=<?= $row['url']; ?>"><?= ($ser_heading); ?></a></li>
                                    <?php } ?>
                                    <li><a href="service.php">View All</a></li>
                                </ul>
                                    </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <!--Column-->
                   <div class="column col-xl-2 col-lg-6 col-md-6 col-sm-12">
                       <div class="footer-widget links-widget">
                           <div class="widget-content">
                               <h6>Portfolio Links</h6>
                               <div class="row clearfix">
                                   <div class="col-md-12 col-sm-12">
                                       <ul>
                                           <?php
                                            $i = 0;
                                            $statement = $pdo->prepare("SELECT * FROM tbl_portfolio ORDER BY p_id DESC LIMIT 6");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                $i++;
                                            ?>
                                               <li><a href="portfolio-details.php?url=<?= ($row['p_name']); ?>"><?= $row['p_name']; ?></a></li>
                                           <?php } ?>
                                           <li><a href="portfolio.php">View All</a></li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <!--Column-->
                   <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                       <div class="footer-widget info-widget">
                           <?php
                            $statement = $pdo->prepare("SELECT * FROM  tbl_contact WHERE id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $address = $row['address'];
                                $phone_1 = $row['phone_1'];
                                $email_id_1 = $row['email_id_1'];
                            }
                            ?>
                           <div class="widget-content">
                               <h6>Contact</h6>
                               <ul class="contact-info">
                                   <li class="address" style="color: #ffffff;"><span class="icon flaticon-pin-1"
                                           style="color: #ffffff;"></span><?= $address; ?></li>
                                   <li><span class="icon flaticon-call" style="color: #ffffff;"></span><a
                                           href="tel:<?= $phone_1; ?>"><?= $phone_1; ?></a></li>
                                   <li><span class="icon flaticon-email-2" style="color: #ffffff;"></span><a
                                           href="mailto:<?= $email_id_1; ?>"><?= $email_id_1; ?></a></li>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>

           </div>
       </div>

       <!-- Footer Bottom -->
       <div class="footer-bottom">
           <div class="auto-container">
               <div class="copyright">
                   <span style="font-size:18px;">CtrlClick ©
                       <script>
                           document.write(new Date().getFullYear());
                       </script> All Rights Reserved | <a href="https://firstpointwebdesign.com" target="_blank"><span style="color:#999B9F;"> Website Design</span></a> - By - <a
                           href="https://firstpointwebdesign.com" target="_blank" style="color:#999B9F;">First Point Web Design</a>
                   </span>
               </div>
           </div>
       </div>

   </footer>


   <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"
           style="color: #ffffff;"></i></a>