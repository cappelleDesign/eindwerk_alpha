<?php
$isReturn = isset($_POST['registerReturn']);
$formData = isset($_POST['register-feedback']) ? $_POST['register-feedback'] : NULL;
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
        <h4>Tier 2</h4>
        <?php
        foreach ($tier2 as $avatar) {
            $imgSrc = $avatar->avatar_img->img_url;
            $avatarPath = 'avatars/' . substr($imgSrc, 0, strrpos($imgSrc, '/'));
            $avatarSrc = $this->getImgHelper()->getImgSrc('m', $avatarPath, substr($imgSrc, strrpos($imgSrc, '/') + 1), 'avatar');
            ?>            
            <img src="<?php echo $avatarSrc ?>" 
                 alt="<?php echo $avatar->avatar_img->img_alt ?>"
                 class="avatar-chosen"
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

    </div>
</div>
<form class="neo-form" id="registerForm" method="POST" action="account/register" autocomplete="off">
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
            <input type="number" class="validation" style="display: none;"
                   data-validation="req" data-addon="false"
                   value=""
                   id="avatar"
                   name="avatar">                                                                            
            <button type="button" id="avatar-choice-trigger" class="form-control">Choose an avatar..</button>
        </div>
    </fieldset>  
    <span class="row login-links">
        <a href="account/loginPage">Login</a>
        <i>/</i>                                                        
        <a href="account/forgotPassForm">Forgot password</a>
    </span>
    <span class="row" style="margin: 0;">                            
        <button disabled type="submit" id="formSubmit" 
                class="btn btn-success submit-disabled col-md-4 col-md-offset-8 col-xs-12"
                data-toggle="contact-submit-tooltip" data-placement="bottom" title="Fill in the form first!">
            Register
        </button>                        
    </span>
</form>