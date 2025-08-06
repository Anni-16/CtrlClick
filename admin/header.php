<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css" />
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">
	<link href="../css/fontawesome-all.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">Ctrl Click</span>
			</a>

			<nav class="navbar navbar-static-top">

				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>
				<!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="./uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>
		<!-- Side Bar to Manage Shop Activities -->
		<aside class="main-sidebar">
			<section class="sidebar">

				<ul class="sidebar-menu">

					<li class="treeview <?php if ($cur_page == 'index.php') {
											echo 'active';
										} ?>">
						<a href="index.php">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'page.php')) {
											echo 'active';
										} ?>">
						<a href="page.php">
							<i class="fa fa-tasks"></i> <span>Manage CMS</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'service.php')) {
											echo 'active';
										} ?>">
						<a href="service.php">
							<i class="fa fa-tasks"></i> <span>Manage Services</span>
						</a>
					</li>

					
					<li class="treeview <?php if (($cur_page == 'portfolio.php') || ($cur_page == 'portfolio-add.php') || ($cur_page == 'portfolio-edit.php')) {
											echo 'active';
										} ?>">
						<a href="portfolio.php">
							<i class="fa fa-briefcase"></i> <span>Manage Portfolio</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'country.php') || ($cur_page == 'country-add.php') || ($cur_page == 'country-edit.php') || ($cur_page == 'state.php') || ($cur_page == 'state-add.php') || ($cur_page == 'state-edit.php') || ($cur_page == 'city.php') || ($cur_page == 'city-add.php') || ($cur_page == 'city-edit.php') || ($cur_page == 'area.php') || ($cur_page == 'area-edit.php') || ($cur_page == 'area-add.php')) {
											echo 'active';
										} ?>">
						<a href="#">
							<i class="fa fa-map-marker"></i>
							<span>Manage Location</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="state.php"><i class="fa fa-circle-o"></i>Add State</a></li>
							<li><a href="city.php"><i class="fa fa-circle-o"></i>Add City</a></li>
							<li><a href="area.php"><i class="fa fa-circle-o"></i>Add Area</a></li>
						</ul>
					</li>


					<li class="treeview <?php if (($cur_page == 'client-logo.php')) {
											echo 'active';
										} ?>">
						<a href="client-logo.php">
							<i class="fa fa-users"></i> <span>Manage Clients Logo</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'package-category.php') || ($cur_page == 'package-category-add.php') || ($cur_page == 'package-category-edit.php') || ($cur_page == 'pachage-sub-category.php') || ($cur_page == 'pachage-sub-category-add.php') || ($cur_page == 'pachage-sub-category-edit.php') || ($cur_page == 'package-type.php') || ($cur_page == 'package-type-add.php') || ($cur_page == 'package-type-edit.php') || ($cur_page == 'package.php.php') || ($cur_page == 'package.php-edit.php') || ($cur_page == 'package.php-add.php')) {
											echo 'active';
										} ?>">
						<a href="#">
							<i class="fa fa-tasks"></i>
							<span>Manage Packages</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="plan-category.php"><i class="fa fa-circle-o"></i>Add Category</a></li>
							<li><a href="plan-sub-category.php"><i class="fa fa-circle-o"></i>Add Sub Category</a></li>
							<li><a href="plan-type.php"><i class="fa fa-circle-o"></i>Add Package Type</a></li>
							<li><a href="package.php"><i class="fa fa-circle-o"></i>Add Package </a></li>
						</ul>
					</li>

					<li class="treeview <?php if (($cur_page == 'faq.php')) {
											echo 'active';
										} ?>">
						<a href="faq.php">
							<i class="fa fa-question-circle"></i> <span>Manage FAQ</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'blog.php')) {
											echo 'active';
										} ?>">
						<a href="blog.php">
							<i class="fa fa-tasks"></i> <span>Manage Blog</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'social-media.php')) {
											echo 'active';
										} ?>">
						<a href="social-media.php">
							<i class="fa fa-globe"></i> <span>Social Media</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'testimonial.php')) {
											echo 'active';
										} ?>">
						<a href="testimonial.php">
							<i class="fa fa-globe"></i> <span>Manage Testimonial</span>
						</a>
					</li>

				<li class="treeview <?php if (($cur_page == 'industry.php') || ($cur_page == 'industry-add.php') || ($cur_page == 'industry-edit.php') || ($cur_page == 'technologies.php') || ($cur_page == 'technologies-add.php') || ($cur_page == 'technologies-edit.php') || ($cur_page == 'type.php') || ($cur_page == 'type-add.php') || ($cur_page == 'type-edit.php')) {
											echo 'active';
										} ?>">
						<a href="#">
							<i class="fa fa-cogs"></i>
							<span>Masster Settings</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="industry.php"><i class="fa fa-circle-o"></i>Add Industry</a></li>
							<li><a href="type.php"><i class="fa fa-circle-o"></i>Add  Portfolio Types</a></li>
							<li><a href="technology.php"><i class="fa fa-circle-o"></i>Add Technologies</a></li>
						</ul>
					</li> 
				</ul>
			</section>
		</aside>

		<div class="content-wrapper">