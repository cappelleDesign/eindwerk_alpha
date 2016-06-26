<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Podcasts</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'video.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" class="content">              
                <div class="twitch-container">
                    <div class="twitch-offline" style="display: none;">
                        <div class="multi-text-center">                            
                            <p>Podcasts are comming soon!</p>
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
        <script>
            $(podcastInit());
        </script>
    </body>
</html>
