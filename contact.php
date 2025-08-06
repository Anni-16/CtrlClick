<?php
include('./admin/inc/config.php');
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
						<h1 id="yellow-color">Contact</h1>
						<div class="page-nav">
							<ul class="bread-crumb clearfix">
								<li><a href="index.php">Home</a></li>
								<li class="active">Contact</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--End Banner Section -->

		<!--Contact Section-->
		<section class="contact-section contact-two">
			<div class="auto-container">
				<div class="row">
					<div class="col-lg-7">
						<div class="form-box">
							<div class="default-form login_form2" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; ">
								<h4 id="note-para">DROP YOUR MESSAGE HERE</h4>
								<form method="post" action="" id="contact-form" style="padding: 20px;">


									<div class="row clearfix">
										<div class="form-group col-lg-6 col-md-6 col-sm-12">
											<div class="field-inner">
												<input type="text" name="username" value="" placeholder="Your Name" required="">
											</div>
										</div>
										<div class="form-group col-lg-6 col-md-6 col-sm-12">
											<div class="field-inner">
												<input type="email" name="email" value="" placeholder="Email Address" required="">
											</div>
										</div>
										<div class="form-group col-lg-6 col-md-6 col-sm-12">
											<div class="field-inner">
												<input type="text" name="username" value="" placeholder="Phone No." required="">
											</div>
										</div>
										<div class="form-group col-lg-6 col-md-6 col-sm-12">
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
										<div class="form-group col-lg-12 col-md-12 col-sm-12">
											<div class="field-inner">
												<textarea name="message" placeholder="Write Message" required=""></textarea>
											</div>
										</div>
										<div id="captcha" class="form_div">
											<div class="preview"></div>
											<div class="field-inner captcha_form">
												<input type="text" id="captcha_form" style="background-color: #fff; font-size:16px; font-weight:900; letter-spacing :10px;" class="form_input_captcha" placeholder="Enter Code" required="">
												<button class="captcha_refersh" type="button">
													<i class="fa fa-refresh"></i>
												</button>
											</div>
										</div>
										<div class="form-group col-lg-12 col-md-12 col-sm-12">
											<button class="theme-btn btn-style-one form_button">
												<i class="btn-curve"></i>
												<span class="btn-title" style="color: white;">Send message</span>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><!-- /.col-lg-6 -->

					<div class="col-lg-5">
						<div class="form-box">
							<div class="default-form" style="background-color: #ffffff; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
								<h4 id="note-para">Get in touch with us</h4>
								<form method="post" action="" id="contact-form" style=" padding: 20px; ">
									<?php
									$statement = $pdo->prepare("SELECT * FROM  tbl_contact WHERE id=1");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										$heading = $row['heading'];
										$address = $row['address'];
										$phone_1 = $row['phone_1'];
										$phone_2 = $row['phone_2'];
										$email_id_1 = $row['email_id_1'];
										$email_id_2 = $row['email_id_2'];
										$email_id_3 = $row['email_id_3'];
										$email_id_4 = $row['email_id_4'];
										$map_url = $row['map_url'];
									}
									?>

									<div class="row">
										<div class="col-lg-12">
											<div class="row" style=" padding-bottom:20px">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
													<img src="./images/my-image/icon/address.png" alt="" width="40px">
												</div>
												<div class="col-lg-10">
													<span>
														<strong style="font-size: 20px; color: #01395c;">Address:</strong>
														<?= $address; ?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-lg-12" style="border-top: 1px solid #01395c20; padding-top:20px; padding-bottom:20px">
											<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
													<img src="./images/my-image/icon/telephone.png" alt="" width="100%">
												</div>
												<div class="col-lg-10">
													<span>
														<strong style="font-size: 20px; color: #01395c;">Call
															Us:</strong>
														<br>
														<a href="tel:<?= $phone_1; ?>"><?= $phone_1; ?></a>
														<br>
														<a href="tel:<?= $phone_2; ?>"><?= $phone_2; ?></a>
													</span>
												</div>
											</div>
										</div>
										<div class="col-lg-12" style="border-top: 1px solid #01395c20; padding-top:10px;">
											<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
													<img src="./images/my-image/icon/mail.png" alt="" width="100%">
												</div>
												<div class="col-lg-10">
													<span>
														<strong style="font-size: 20px; color: #01395c;">Mail
															Us:</strong>
														<br>
														<span><a href="mail:<?= $email_id_1; ?>"><?= $email_id_1; ?></a></span>
														<br>
														<span><a href="mail:<?= $email_id_2; ?>"><?= $email_id_2; ?></a></span>
														<br>
														<span><a href="mail:<?= $email_id_3; ?>"><?= $email_id_3; ?></a></span>
														<br>
														<span><a href="mail:<?= $email_id_4; ?>"><?= $email_id_4; ?></a></span>
													</span>
												</div>
											</div>
										</div>

										<div class="col-lg-12" style="  padding-top:10px; padding-bottom:20px">
											<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
													<img src="./images/my-image/icon/briefcase.png" alt="" width="100%">
												</div>
												<div class="col-lg-10">
													<span style="font-size: 16px; color:#01395c;"><strong style="font-size: 18px; color: #01395c;">
															5000+</strong>
														Accounts Handled</span>
												</div>
											</div>
										</div>

										<div class="col-lg-12" style="  padding-bottom:20px">
											<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
													<img src="./images/my-image/icon/multiple-users-silhouette.png" alt="" width="100%">
												</div>
												<div class="col-lg-10">
													<span style="font-size: 16px; color:#01395c;"><strong style="font-size: 18px; color: #01395c;">
															90+</strong>
														Team of Professionals</span>
												</div>
											</div>
										</div>

										<div class="col-lg-12" style="  padding-bottom:20px">
											<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
													<img src="./images/my-image/icon/earth.png" alt="" width="100%">
												</div>
												<div class="col-lg-10">
													<span style="font-size: 16px; color:#01395c;"><strong style="font-size: 18px; color: #01395c;">
															25+ </strong>
														Serving Countries</span>
												</div>
											</div>
										</div>


									</div>

								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>

		<div class="map-box">
			<iframe class="map-iframe" src="<?= $map_url; ?>" style="border:0;" aria-hidden="false" tabindex="0"></iframe>
		</div>
		<br>
		<br>
		<br>
		<br>

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

</html>