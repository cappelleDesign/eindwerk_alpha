<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Live streams</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
            <?php
            $page = 'video.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" class="content">              
                <div class="twitch-container">
                    <div class="twitch-offline" style="display: none;">
                        <div class="multi-text-center">                            
                            <p>We are currently not streaming :(</p>
                            <p>checkout our <a class="inline-link" href="videos/lets-plays">recorded videos</a></p>
                        </div>
                    </div>
                    <div id="neoludus-twitch">

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
        <script src="http://player.twitch.tv/js/embed/v1.js"></script>
        <script>
            $(liveInit());
        </script>
    </body>
</html>
