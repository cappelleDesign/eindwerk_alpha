<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        $imgRoot = Globals::getRoot('img', 'app') . 'games/';
        ?>                 
        <title>Reviews</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
            <?php
            $page = 'reviews.php';
            $this->includeMenu($page);
            ?>                        
            <main role="main" id="reviews-main">
                <div id="reviews-content">

                </div> 

                <div class="load-more" id="review-more-load">
                    <p class="animated faa-flash faa-slow">loading reviews..</p>             
                </div>
                <div id="no-mass" class="hidden alert alert-danger text-center">
                    No more reviews left you greedy pig..
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
            $(document).ready(function () {
                reviewPageInit();
            });
        </script>
    </body>
</html>