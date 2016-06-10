<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Video's</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'video.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" class="content container-fluid construction">
                <div class="row">
                    <div class="col-lg-offset-3 col-lg-6">
                        <div class="panel panel-warning text-center">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    videos
                                </div>
                            </div>
                            <div class="panel-body">
                                <h3>
                                    <i class="fa fa-lg fa-warning"></i>
                                    This page is still under construction
                                    <i class="fa fa-lg fa-warning"></i>
                                </h3>
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
