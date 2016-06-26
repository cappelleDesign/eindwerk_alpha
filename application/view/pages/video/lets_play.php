<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Let's plays</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'video.php';
            $this->includeMenu($page);
            ?>            
           
            <main role="main" class="content">
                <div class="video-container">
                    <!--video overview-->
                    <a href="" id="addVideos">add video's</a>
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
            $(letsPlayInit());
        </script>
    </body>
</html>
