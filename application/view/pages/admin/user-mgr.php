<?php
$users = -1;
if (isset($_POST['users'])) {
    $jUs = json_decode($_POST['users']);
    if($jUs){
    $users = $jUs;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Neoludus admin - Dashboard</title>
        <?php $this->includeHeader(); ?>
        <?php $this->includeAdminHeader(); ?>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php $this->includeAdminMenu('user-mgr'); ?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">User manager</h1>
                            <div class="container-fluid">
                                <div class="row">
                                    <a href="admin/add-user-page" class="btn btn-success"><i class="fa fa-fw fa-plus"></i> Add new users</a>
                                </div>
                                <div class="row">
                                    <table id="user-table" class="table table-responsive table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Admin
                                                </th>
                                                <th>
                                                    Name
                                                </th>                                                
                                                <th>
                                                    Role
                                                </th>                                                
                                                <th>
                                                    Ops
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($users !== -1) {
                                                foreach ($users as $user) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $user->user_role->user_role_access_flag >=100 ? 'Yes':'No'?>
                                                        </td>
                                                        <td>
                                                            <?php echo $user->user_name?>
                                                        </td>                                                        
                                                        <td>
                                                            <?php echo $user->user_role->user_role_name?></td>                                                        
                                                        <td>
                                                            <a href="#"
                                                               class="btn btn-sm btn-danger confirmation-trigger disabled"
                                                               data-confirmation-type="user-delete"
                                                               data-destination="user/delete/<?php echo $user->user_id?>">
                                                                <i class="fa fa-trash-o fa-lg"></i>
                                                            </a>
<!--                                                            <a href="admin/update-user-page/<?php // echo $user->user_id?>"
                                                               class="btn btn-sm btn-primary">
                                                                <i class="fa fa-pencil fa-lg"></i>
                                                            </a>-->
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <?php $this->includeScripts(); ?>
        <?php $this->includeAdminScripts(); ?>
    </body>

</html>
