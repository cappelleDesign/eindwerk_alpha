<?php
$current = $this->getCurrentUser(FALSE);
$login = $_POST['is_login'];
if ($current) {
    $userImgSrc = $current->getAvatar()->getImage()->getUrl();
    $userAvatarPath = 'avatars/' . substr($userImgSrc, 0, strrpos($userImgSrc, '/'));
    $userAvatarSrc = $this->getImgHelper()->getImgSrc('l', $userAvatarPath, substr($userImgSrc, strrpos($userImgSrc, '/') + 1), 'avatar');
}
$avatars = json_decode($_POST['avatars']);
$tier1 = array();
$tier2 = array();
$tier3 = array();
foreach ($avatars as $tier) {
    if ($tier->avatar_tier === 1) {
        array_push($tier1, $tier);
    } else if ($tier->avatar_tier === 2) {
        array_push($tier2, $tier);
    } else if ($tier->avatar_tier === 3) {
        array_push($tier3, $tier);
    }
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
            <div id="avatar-choice-menu" hidden>
                <h3>Choose your avatar</h3>
                <div class="tier">
                    <h4>Tier 1</h4>
                    <?php
                    foreach ($tier1 as $avatar) {
                        $imgSrc = $avatar->avatar_img->img_url;
                        $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
                        $avatarSrc = $this->getImgHelper()->getImgSrc('m', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
                        ?>            
                        <img src="<?php echo $avatarSrc ?>"
                             alt="<?php echo $avatar->avatar_img->img_alt ?>"
                             class="avatar-chosen"
                             data-avatar-id="<?php echo $avatar->avatar_id ?>">
                         <?php } ?>    
                         <?php if ($current) { ?>
                        <h4>Tier 2</h4>
                        <?php
                        foreach ($tier2 as $avatar) {
                            $imgSrc = $avatar->avatar_img->img_url;
                            $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
                            $avatarSrc = $this->getImgHelper()->getImgSrc('m', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
                            ?>            
                            <img src="<?php echo $avatarSrc ?>" 
                                 alt="<?php echo $avatar->avatar_img->img_alt ?>"
                                 class="avatar-chosen disabled"
                                 data-avatar-id="<?php echo $avatar->avatar_id ?>">            
                             <?php } ?>
                        <h4>Tier 3</h4>
                        <?php
                        foreach ($tier3 as $avatar) {
                            $imgSrc = $avatar->avatar_img->img_url;
                            $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
                            $avatarSrc = $this->getImgHelper()->getImgSrc('m', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
                            ?>            
                            <img src="<?php echo $avatarSrc ?>" 
                                 alt="<?php echo $avatar->avatar_img->img_alt ?>"
                                 class="avatar-chosen" 
                                 data-avatar-id="<?php echo $avatar->avatar_id ?>">            
                             <?php } ?>
                         <?php } ?>
                </div>
            </div>
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
                                <img src="<?php echo $userAvatarSrc ?>" alt="">
                                <i class="fa fa-external-link fa-flip-horizontal"></i>                                
                            </div>
                            <p>Username: <?php echo $current->getUsername(); ?></p>
                            <p>Email: <?php echo $current->getEmail(); ?></p>
                            <p>Member since: <?php echo $current->getCreatedStr(Globals::getDateTimeFormat('be', False)); ?></p>
                            <p>Active time: <?php echo DateFormatter::secondsToTime($current->getActiveTime()); ?></p>
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
