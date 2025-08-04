<?php
include 'inc/config.php';
if($_POST['id'])
{
	$id = $_POST['id'];
	
	$statement = $pdo->prepare("SELECT * FROM  tbl_plan_type WHERE plan_sub_cat_id  = ?");
	$statement->execute(array($id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?><option value="">Select Plan Type Name</option><?php						
	foreach ($result as $row) {
		?>
        <option value="<?php echo $row['plan_type_id']; ?>"><?php echo $row['plan_type_name']; ?></option>
        <?php
	}
}