<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Video's</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
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
                <div class="fix"></div>
            </main>
        </div>
        <footer>
            <?php $this->includeFooter();
            ?>
        </footer>

        <?php
        $this->includeScripts();
        ?>         
    </body>
</html>
