<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>
        <title>home</title>
    </head>
    <body> 
        <div id="home-loader" class="page-loader">
            <div class="page-loader-content ">
                <p><i class="fa fa-gear faa-spin animated "></i> NEOLUDUS IS LOADING<span class="faa-burst faa-fast animated"> ...</span><p>
            </div>
        </div>
        <div id="wrapper" class="no-js-push">
            <?php
            $page = basename(__FILE__);
            $this->includeMenu($page);
            ?>            
            <div class="fix"></div> 
            <main>
                <div class="mobile-latest-header">
                    <h2>Our Latest</h2>
                </div>
                <div id="inf-slider-holder">
                    <div id="inf-slider">

                    </div>
                </div>   
                <div class="mobile-new-header">
                    <h2>What's New</h2>
                </div>                
                <div id="newsfeed-holder">
                    <nav id="newsfeed-nav">
                        <ul class="menu">

                        </ul>
                    </nav>
                    <div id="newsfeeds">
                        <div id="newsfeed-items">                           
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
        <script src="<?php echo Globals::getRoot('view', 'app') ?>/js/homepage-functions.js" type="text/javascript"></script>                   
    </body>
</html>
