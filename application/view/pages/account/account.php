<?php 
$current = $this->getCurrentUser(FALSE);
?>
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
                if (!$current) {
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
                } else if($current instanceof UserDetailed){                                                                                
                    ?>
                <img width="100" src="<?php echo Globals::getRoot('img', 'app') .'avatars/'. $current->getAvatar()->getImage()->getUrl();?>" alt="">
                <p style="color: #fff;">Name: <?php echo $current->getUsername()?></p>
                <p style="color: #fff;">Role: <?php echo $current->getUserRole()->getName() ?></p>

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
