<?php
$current = $this->getCurrentUser(FALSE);
$login = $_POST['is_login'];
if ($current) {
    $imgSrc = $current->getAvatar()->getImage()->getUrl();
    $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
    $avatarSrc = $this->getImgHelper()->getImgSrc('l', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Account</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
            <?php
            $page = 'account.php';
            $this->includeMenu($page);
            ?>            
            <main>
                <?php
                if (!$current) {
                    ?>
                    <div class="container-fluid login-container <?php echo $login ? '' : 'hidden' ?>">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 col-xs-12">
                                <div class="panel login-panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Login</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php $this->includeLoginForm(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid login-container <?php echo $login ? 'hidden' : '' ?>">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 col-xs-12">
                                <div class="panel login-panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Register</h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php $this->includeRegisterForm(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else if ($current instanceof UserDetailed) {
                    ?>
                    <div class="row" style="color: #fff">
                        <div id="user-info" class="col-sm-2">
                            <div class="avatar-container">
                                <img src="<?php echo $avatarSrc ?>" alt="">
                                <i class="fa fa-external-link fa-flip-horizontal"></i>                                
                            </div>
                            <p>Username: <?php echo $current->getUsername(); ?></p>
                            <p>Email: <?php echo $current->getEmail(); ?></p>
                            <p>Member since: <?php echo $current->getCreatedStr(Globals::getDateTimeFormat('be', False)); ?></p>
                            <p>Active time: <?php echo DateFormatter::secondsToTime($current->getActiveTime()); ?></p>
                        </div>        
                        <div id="pwChange">

                        </div>
                    </div>

                <?php }
                ?>
            </main>
        </div>
        <footer>
            <?php $this->includeFooter();
            ?>
        </footer>

        <?php
        $this->includeScripts();
        ?> 
        <script>

        </script>
    </body>
</html>
