<?php
$user = $this->getCurrentUser();
$imgSrc = $user->getAvatar()->getImage()->getUrl();
$avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
$avatarSrc = $this->getImgHelper()->getImgSrc('l', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
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
            <?php $this->includeAdminMenu('dashboard'); ?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Admin Profile settings</h1>
                            <div class="container-fluid">
                                <div class="row">
                                    <div id="user-info" class="col-sm-2">
                                        <div class="avatar-container">
                                            <img src="<?php echo $avatarSrc ?>" alt="">
                                            <i class="fa fa-external-link fa-flip-horizontal"></i>                                
                                        </div>
                                        <p>Username: <?php echo $user->getUsername(); ?></p>
                                        <p>Email: <?php echo $user->getEmail(); ?></p>
                                        <p>Member since: <?php echo $user->getCreatedStr(Globals::getDateTimeFormat('be', False)); ?></p>
                                        <p>Active time: <?php echo DateFormatter::secondsToTime($user->getActiveTime()); ?></p>
                                    </div>        
                                    <div id="pwChange">

                                    </div>
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
