
<?php require_once('header.php'); ?>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_service");
$statement->execute();
$total_service = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_blog");
$statement->execute();
$total_blog = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_industry");
$statement->execute();
$total_industries = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_state");
$statement->execute();
$total_state = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_city");
$statement->execute();
$total_city = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_area");
$statement->execute();
$total_area = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_client_logo");
$statement->execute();
$total_client_logo = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_portfolio");
$statement->execute();
$total_portfolio = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_type");
$statement->execute();
$total_type = $statement->rowCount();

?>

<section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3><?php echo $total_service; ?></h3>
					<p>Services</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-arrow-down-b"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-primary">
				<div class="inner">
					<h3><?php echo $total_blog; ?></h3>
					<p>Blogs</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-android-cart"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3><?php echo $total_industries; ?></h3>
					<p>Industies</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-clipboard"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $total_type; ?></h3>
					<p>Type</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-android-checkbox-outline"></i>
				</div>

			</div>
		</div>


		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $total_state; ?></h3>
					<p>States</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo $total_city; ?></h3>

					<p>Citys</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-person-add"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-teal">
				<div class="inner">
					<h3><?php echo $total_area; ?></h3>

					<p>Areas</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-location"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?php echo $total_portfolio; ?></h3>

					<p>Portfolios</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-load-a"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?php echo $total_client_logo; ?></h3>

					<p>Clients Logos</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-load-a"></i>
				</div>

			</div>
		</div>

	</div>

</section>

<?php require_once('footer.php'); ?>