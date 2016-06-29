<?php
$formData = isset($_POST['user-add-feedback']) ? $_POST['user-add-feedback'] : NULL;
$userRoles = json_decode($_POST['userRoles']);
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

        <title>Neoludus admin - Dashboard</title>
        <?php $this->includeHeader(); ?>
        <?php $this->includeAdminHeader(); ?>
    </head>

    <body>

        <div id="wrapper">
            <!-- Navigation -->
            <?php $this->includeAdminMenu('user-mgr'); ?>

            <div id="avatar-choice-menu" hidden>
                <h3>Choose your avatar</h3>
                <div class="tier">
                    <h4>Tier 1</h4>
                    <?php
                    foreach ($tier1 as $avatar) {
                        $imgSrc = $avatar->avatar_img->img_url;
                        $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
                        $avatarSrc = $this->getImgHelper()->getImgSrc('l', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
                        ?>
                        <a class="avatar-chosen" href="" data-avatar-id="<?php echo $avatar->avatar_id ?>">                        
                            <img src="<?php echo $avatarSrc ?>" alt="<?php echo $avatar->avatar_img->img_alt?>">
                        </a>
                    <?php } ?>
                    <h4>Tier 2</h4>
                    <?php
                    foreach ($tier2 as $avatar) {
                        $imgSrc = $avatar->avatar_img->img_url;
                        $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
                        $avatarSrc = $this->getImgHelper()->getImgSrc('l', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
                        ?>
                        <a class="avatar-chosen" href="" data-avatar-id="<?php echo $avatar->avatar_id ?>">                        
                            <img src="<?php echo $avatarSrc ?>" alt="<?php echo $avatar->avatar_img->img_alt?>">
                        </a>
                    <?php } ?>
                    <h4>Tier 3</h4>
                    <?php
                    foreach ($tier3 as $avatar) {
                        $imgSrc = $avatar->avatar_img->img_url;
                        $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
                        $avatarSrc = $this->getImgHelper()->getImgSrc('l', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
                        ?>
                        <a class="avatar-chosen" href="" data-avatar-id="<?php echo $avatar->avatar_id ?>">                        
                            <img src="<?php echo $avatarSrc ?>" alt="<?php echo $avatar->avatar_img->img_alt?>">
                        </a>
                    <?php } ?>
                    
                </div>
            </div>
            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">User manager</h1>
                            <div class="container-fluid">                               
                                <div class="row">
                                    <form role="form" id="user-form" class="col-md-8 col-md-offset-2" action="admin/addUser" method="POST">     
                                        <fieldset class="">
                                            <legend class="text-center">Add a new User</legend>
                                            <?php
                                            $extraMsg = isset($formData['extraMessage']) ? $formData['extraMessage'] : '';
                                            $this->includeFormFeedback(TRUE);
                                            ?>                                
                                            <div class="form-group form-filter hidden">
                                                <label for="input-filter">Not to be filled in</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                                                    <input autofocus value="" type="text" class="form-control" id="input-filter" name="input-filter" placeholder="Are you a robot?">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['userRole']['errorClass'] : '' ?>">
                                                <label for="user-role">
                                                    User-role:
                                                </label>
                                                <select autofocus class="form-control validation" id="user-role" 
                                                        name="user-role" required
                                                        data-validation="req" data-addon="false">               
                                                    <option value="">
                                                        -- Select a User role
                                                    </option>
                                                    <?php foreach ($userRoles as $userRole) { 
                                                         ?>
                                                        <option value="<?php echo $userRole->user_role_access_flag ?>">
                                                            <?php echo $userRole->user_role_name ?>
                                                        </option>
                                                    <?php } ?>                                                    
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['userMail']['errorClass'] : '' ?>">
                                                <label for="user-mail">
                                                    Email:
                                                </label>
                                                <input type="text" class="user-mail-validation form-control" 
                                                       id="user-mail" data-validation="user-mail" data-addon="false"
                                                       name="user-mail" value="<?php echo $formData ? $formData['userMail']['prevVal'] : '' ?>"
                                                       placeholder="Fill in your email address">                     
                                                       <?php
                                                       $fieldName = 'user-mail';
                                                       $this->includeFormFeedback();
                                                       ?>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['userName']['errorClass'] : '' ?>">
                                                <label for="user-name">
                                                    Username:
                                                </label>
                                                <input type="text" class="user-name-validation form-control" 
                                                       id="user-name" data-validation="user-name" data-addon="false"
                                                       name="user-name" value="<?php echo $formData ? $formData['userName']['prevVal'] : '' ?>"
                                                       placeholder="Choose a username">                     
                                                       <?php
                                                       $fieldName = 'user-name';
                                                       $this->includeFormFeedback();
                                                       ?>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['userPwd']['errorClass'] : '' ?>">
                                                <label for="user-pwd">
                                                    Password:
                                                </label>
                                                <input type="password" class="validation form-control" 
                                                       id="user-pwd" data-validation="pwd" data-addon="false"
                                                       name="user-pwd" value=""
                                                       placeholder="Fill in your password">                     
                                                       <?php
                                                       $fieldName = 'user-pwd';
                                                       $this->includeFormFeedback();
                                                       ?>
                                            </div>      
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['userPwdRepeat']['errorClass'] : '' ?>">
                                                <label for="user-pwd-repeat">
                                                    Password repeat:
                                                </label>
                                                <input type="password" class="validation form-control" 
                                                       id="user-pwd-repeat" data-validation="pwd-repeat" data-addon="false"
                                                       name="user-pwd-repeat" value="<?php echo $formData ? $formData['UserPwdRepeat']['prevVal'] : '' ?>"
                                                       placeholder="Repeat your password">                     
                                                       <?php
                                                       $fieldName = 'user-pwd-repeat';
                                                       $this->includeFormFeedback();
                                                       ?>
                                            </div>      
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['avatar']['errorClass'] : '' ?>">
                                                <label for="avatar">
                                                    Picture:
                                                </label>
                                                <input type="number" class="validation" style="display:none;" 
                                                       data-validation="req" data-addon="false"
                                                       value=""
                                                       id="avatar"
                                                       name="avatar">                                                                            
                                                <button type="button" id="avatar-choice-trigger" class="form-control">Choose an avatar..</button>
                                            </div>
                                        </fieldset>  
                                        <span class="row" style="margin: 0;">                            
                                            <button disabled type="submit" id="formSubmit" 
                                                    class="btn btn-success submit-disabled col-xs-4 col-xs-offset-8"
                                                    data-toggle="contact-submit-tooltip" data-placement="bottom" title="Fill in the form first!">
                                                Add
                                            </button>                        
                                        </span>
                                    </form>
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
