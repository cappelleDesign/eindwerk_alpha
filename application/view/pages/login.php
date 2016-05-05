<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();        
        $isReturn = isset($_POST['loginReturn']);
        $loginFormData = '';
        if ($isReturn) {
            $loginFormData = $this->getSessionController()->getSessionAttr('loginFormData');
        } else {
            $this->getSessionController()->deleteSessionAttr('loginFormData');
        }
        ?>
        <title>login</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'account.php';
            $this->includeMenu($page);
            ?>          
            <div class="fix"></div> 
            <main>
                <div class="container-fluid login-container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6 col-xs-12">

                            <div class="panel login-panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Login</h3>
                                </div>
                                <div class="panel-body">
                                    <?php $this->includeLoginForm();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>         
        <footer>
            <?php $this->includeFooter(); ?>
        </footer>

        <?php
        $this->includeScripts();
        ?> 
        <script>

        </script>
    </body>
</html>
