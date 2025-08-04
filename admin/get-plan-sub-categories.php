<?php
include 'inc/config.php';
if($_POST['id'])
{
	$id = $_POST['id'];
	
	$statement = $pdo->prepare("SELECT * FROM  tbl_plan_sub_category WHERE plan_cat_id = ?");
	$statement->execute(array($id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	?><option value="">Select Plan Sub Category</option><?php						
	foreach ($result as $row) {
		?>
        <option value="<?php echo $row['plan_sub_cat_id']; ?>"><?php echo $row['plan_sub_cat_name']; ?></option>
        <?php
	}
}