<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Packages</h1>
    </div>
    <div class="content-header-right">
        <a href="package-add.php" class="btn btn-primary btn-sm">Add Packages</a>
    </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Plan Category Name</th>
                    <th>Plan Sub Category Name</th>
                    <th>Plan Type Name</th>
                    <th>Plan Price</th>
                    <th>Plan Duration</th>
                    <th>Package Title</th>
                    <th>Package Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                $statement = $pdo->prepare("
                    SELECT 
                        t1.package_id, 
                        t1.package_title, 
                        t1.package_description,
                        t2.plan_type_id,
                        t2.plan_type_name,
                        t2.plan_type_price,
                        t2.plan_type_duration,
                        t3.plan_sub_cat_name,
                        t4.plan_cat_name
                    FROM tbl_package t1
                    JOIN tbl_plan_type t2 ON t1.plan_type_id = t2.plan_type_id
                    JOIN tbl_plan_sub_category t3 ON t2.plan_sub_cat_id = t3.plan_sub_cat_id
                    JOIN tbl_plan_category t4 ON t3.plan_cat_id = t4.plan_cat_id
                    ORDER BY t1.package_id DESC
                ");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
                foreach ($result as $row) {
                    $i++;

                    // Parse package_description to show icons based on data-status
                    $descHtml = '';
                    if (!empty($row['package_description'])) {
                        preg_match_all('/<li[^>]*data-status="([^"]*)"[^>]*>(.*?)<\/li>/i', $row['package_description'], $matches, PREG_SET_ORDER);

                        if ($matches) {
                            $descHtml .= '<ul>';
                            $count = 0;
                            foreach ($matches as $m) {
                                $count++;
                                if ($count > 5) break; // limit to 5

                                $status = $m[1];
                                $text = $m[2];

                                $icon = '';
                                if ($status === 'correct') {
                                    $icon = ' <i class="fa fa-check" style="color:green;" title="Correct"></i>';
                                } elseif ($status === 'wrong') {
                                    $icon = ' <i class="fa fa-times" style="color:red;" title="Wrong"></i>';
                                }

                                $descHtml .= '<li>' . $text . $icon . '</li>';
                            }
                            // If there are more than 5, indicate more
                            if (count($matches) > 5) {
                                $descHtml .= '<li>...</li>';
                            }
                            $descHtml .= '</ul>';
                        } else {
                            // fallback if no status attributes present
                            $descHtml = $row['package_description'];
                        }
                    }
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['plan_cat_name']; ?></td>
                        <td><?php echo $row['plan_sub_cat_name']; ?></td>
                        <td><?php echo $row['plan_type_name']; ?></td>
                        <td><?php echo $row['plan_type_price']; ?></td>
                        <td><?php echo $row['plan_type_duration']; ?></td>
                        <td><?php echo $row['package_title']; ?></td>
                        <td><?php echo $descHtml; ?></td>
                        <td>
                            <a href="package-edit.php?package_id=<?php echo $row['package_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="package-delete.php?package_id=<?php echo $row['package_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful! All related data for this plan type will be deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
