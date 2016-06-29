<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Donations</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
            <?php
            $page = 'donate.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" class="content container-fluid construction">
                <div class="row">
                    <div class="col-lg-offset-3 col-lg-6">
                        <div class="panel panel-warning text-center">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    BUY US A BEER <i class="fa fa-beer"></i>
                                </div> 
                            </div>
                            <div class="panel-body">
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="UD4VG2DQKEHYY">
                                    <input type="image" src="https://www.paypalobjects.com/en_US/BE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
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
