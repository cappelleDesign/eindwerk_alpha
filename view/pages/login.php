<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'view/includes/header.php';
        $viewRoot = Globals::getRoot('view');
        $isReturn = isset($_POST['loginReturn']);
        $loginFormData = '';
        if ($isReturn) {
            $loginFormData = $this->_sessionController->getSessionAttr('loginFormData');
        } else {
            $this->_sessionController->deleteSessionAttr('loginFormData');
        }
        ?>
        <title>login</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'account.php';
            include 'view/includes/menu.php';
            ?>            
            <div class="fix"></div> 
            <main>
                <div class="container login-container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6 col-xs-12">

                            <div class="panel login-panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Login</h3>
                                </div>
                                <div class="panel-body">

                                    <form id="loginForm" method="post" action="index.php?action=login" autocomplete="off" class="">
                                        <fieldset>
                                            <?php
                                            if (isset($loginFormData) && !empty($loginFormData)) {
                                                if (array_key_exists('extraMessage', $loginFormData)) {
                                                    echo '<div class="alert alert-danger">';
                                                    echo $loginFormData['extraMessage'];
                                                    echo '</div>';
                                                }
                                            }
                                            ?>
                                            <div class="form-group form-filter hidden">
                                                <label for="input-filter">Not to be filled in</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                                                    <input value="" type="text" class="form-control" id="input-filter" name="input-filter" placeholder="Are you a robot?">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback <?php echo empty($loginFormData) ? '' : $loginFormData['loginNameState']['errorClass']; ?>">
                                                <label for="loginName">
                                                    Username/Email
                                                </label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input type="text" class="form-control"
                                                           id="loginName"
                                                           name="loginName" value="<?php echo empty($loginFormData) ? '' : $loginFormData['loginNameState']['prevVal']; ?>"
                                                           placeholder="Username of Email here"  autofocus required>                                                  
                                                </div>
                                                <?php
                                                if (!empty($loginFormData)) {
                                                    if ($loginFormData['loginNameState']['errorClass'] === 'has-error') {
                                                        echo '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>';
                                                        echo '<span id="inputLoginNameError" class="sr-only">(error)</span>';
                                                        echo '<span class="text-danger">' . $loginFormData['loginNameState']['errorMessage'] . '</span>';
                                                    } else {
                                                        echo '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>';
                                                        echo '<span id="inputLoginNameSuccess" class="sr-only">(success)</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group has-feedback <?php echo empty($loginFormData) ? '' : $loginFormData['loginPwState']['errorClass']; ?>">
                                                <label for="loginPw">
                                                    Password
                                                </label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                    <input type="password" class="form-control"
                                                           id="loginPw"
                                                           name="loginPw"
                                                           placeholder="Password here" required>                                                  
                                                </div>
                                                <?php
                                                if (!empty($loginFormData)) {
                                                    if ($loginFormData['loginPwState']['errorClass'] === 'has-error') {
                                                        echo '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>';
                                                        echo '<span id="inputLoginPwError" class="sr-only">(error)</span>';
                                                        echo '<span class="text-danger">' . $loginFormData['loginPwState']['errorMessage'] . '</span>';
                                                    } else {
                                                        echo '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>';
                                                        echo '<span id="inputPwSuccess" class="sr-only">(success)</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="pull-left login-links">
                                                <!--//TODO ajax-->
                                                <a href="index.php?action=registerForm">Register</a>
                                                <i>/</i>                                                        
                                                <a href="index.php?action=forgotPassForm">Forgot password</a>
                                            </div>
                                            <div class="pull-right login-buttons">              

                                                <a href="index.php?action=home" class="btn btn-outline btn-danger">Cancel</a>
                                                <button type="submit" class="btn btn-outline btn-success" id="submitButton">Login</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>         
        <footer>
<?php include 'view/includes/footer.php'; ?>
        </footer>

        <?php
        include 'view/includes/scripts.php';
        ?> 
        <script>

        </script>
    </body>
</html>
