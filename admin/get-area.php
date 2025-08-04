<?php
include 'inc/config.php';
if($_POST['id'])
{
	$id = $_POST['id'];
	
	$statement = $pdo->prepare("SELECT * FROM tbl_area WHERE city_id=?");
	$statement->execute(array($id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?><option value="">Select Area Name</option><?php						
	foreach ($result as $row) {
		?>
        <option value="<?php echo $row['area_id']; ?>"><?php echo $row['area_name']; ?></option>
        <?php
	}
}