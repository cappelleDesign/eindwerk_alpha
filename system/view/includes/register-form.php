<?php
$isReturn = isset($_POST['registerReturn']);
$formData = isset($_POST['register-feedback']) ? $_POST['register-feedback'] : NULL;
?>
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