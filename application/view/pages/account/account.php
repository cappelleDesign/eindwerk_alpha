<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Account</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'account.php';
            $this->includeMenu($page);
            ?>            
            <main>
                <?php
                if (!$this->getCurrentUser(FALSE)) {
                    ?>
                    <div class="container-fluid login-container">
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
                <?php
                } else {                                                            
                    Globals::cleanDump($this->getCurrentUser(FALSE)->getRecentNotifications());
                    ?>

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
