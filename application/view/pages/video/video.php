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
            <main role="main" class="content" id="video-main">
                <a href="videos/live-streams" class="flip-container">
                    <div class="flipper">
                        <div class="front">Live</div>
                        <div class="back">Watch our live twitch stream</div>
                    </div>
                </a>
                <a href="videos/lets-plays" class="flip-container">
                    <div class="flipper">
                        <div class="front">Lets play's</div>
                        <div class="back">Check out our recorded plays</div>
                    </div>
                </a>
                <a href="videos/podcasts" class="flip-container">
                    <div class="flipper">
                        <div class="front">Podcasts</div>
                        <div class="back">Check out our podcasts</div>
                    </div>
                </a>                
            </main>
        </div>
        <footer>
            <?php $this->includeFooter();
            ?>
        </footer>

        <?php
        $this->includeScripts();
        ?> 
        <script src="<?php echo Globals::getRoot('view', 'app') ?>/js/plugins/jq-upload/js/main.js" type="text/javascript"></script>

    </body>
</html>
