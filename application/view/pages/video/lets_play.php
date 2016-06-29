<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Let's plays</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
            <?php
            $page = 'video.php';
            $this->includeMenu($page);
            ?>            

            <main role="main" class="content">
                <div class="video-container">

                </div>
                <div class="load-more" id="review-more-load">
                    <p class="animated faa-flash faa-slow">loading videos..</p>             
                </div>
                <div id="no-mass" class="hidden alert alert-danger text-center">
                    No more video's left you greedy pig..
                    <!--                    <a id="reviews-toTop" href="#">
                                            <i class="fa fa-arrow-up"></i>
                                        </a>-->
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
