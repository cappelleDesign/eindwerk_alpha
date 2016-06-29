<?php
//$user = $this->getCurrentUser();
//$imgSrc = $user->getAvatar()->getImage()->getUrl();
//$avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
//$avatarSrc = $this->getImgHelper()->getImgSrc('l', $avatarPath, 'user_jens_admin.png', 'avatar');
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
                            <h1 class="page-header">Review manager</h1>
                            <div class="container-fluid">
                                <div class="row">

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
