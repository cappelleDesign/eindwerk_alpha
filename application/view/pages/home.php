<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        $reviews = $_POST['reviews'];
        $reviews = json_decode($reviews);
        $newsfeed = $_POST['newsfeed'];
        $newsfeed = json_decode($newsfeed);
        $class = 'primary-slide';
        $active = 'active';
        $base = Globals::getBasePath();
        ?>
        <title>home</title>
    </head>
    <body class="customScroll">
        <div id="neo-wrapper" class="no-js-push">
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
                        <?php
                        foreach ($reviews as $review) {
                            $destin = $base . 'reviews/detailed/' + $review->review_id;
                            $path = Globals::cleanStringUnderScore($review->review_game->game_name);
                            $img = $review->review_header_img->img_url;
                            ?>
                            <div class="slider-item <?php echo ' ' . $class; ?>" 
                                 data-img-path="games/<?php echo $path; ?>" 
                                 data-img-url="<?php echo $img; ?>">
                                <div class="slider-desc">
                                    <div class="mobile-center">
                                        <p><?php echo $review->review_title; ?></p>
                                        <div class="stars">
                                            <input type="text" class="score" data-readOnly="true"
                                                   value="<?php echo $review->review_score; ?>"
                                                   data-fgColor="#ef4123" data-bgColor="#231f20">
                                        </div></div></div>
                                <img class="jsImg" src="" alt="<?php echo $review->review_header_img->img_alt ?>">
                                <div class="slider-more">
                                    <a href="<?php echo $destin; ?>" class="btn btn-default">Read more</a>
                                </div></div>
                            <?php
                            $class = 'secondary-slide';
                        }
                        ?>
                    </div>
                </div>   
                <div class="mobile-new-header">
                    <h2>What's New</h2>
                </div>                
                <div id="newsfeed-holder">
                    <nav id="newsfeed-nav">
                        <ul class="menu">
                            <?php foreach ($newsfeed as $newsfeedItem) { ?>
                                <li class="<?php echo $active; ?>">
                                    <a href="#"><?php echo $newsfeedItem->newsfeed_subject; ?></a>
                                </li>
                                <?php
                                $active = '';
                            }
                            ?>
                        </ul>
                    </nav>
                    <div id="newsfeeds">
                        <div id="newsfeed-items">    
                            <?php foreach ($newsfeed as $newsfeedItem) { ?>
                                <div class="newsfeed-item">
                                    <img data-newsfeed-img="<?php echo $newsfeedItem->newsfeed_img->img_url; ?>" 
                                         class="newsfeed-img" src="" 
                                         alt="<?php echo $newsfeedItem->newsfeed_img->img_alt ?>">
                                    <div class="newsfeed-desc">
                                        <h2><?php echo $newsfeedItem->newsfeed_subject ?></h2>
                                        <ul>     
                                            <?php echo html_entity_decode($newsfeedItem->newsfeed_body); ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
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
        <script>

            $(function () {
//                $.each($('.newsfeed-desc ul'), function ($i, $el) {
//                    console.log($($el).html());
//                    $txt = $('<li />').html($el).text();
//                    $($el).html($txt);
//                    console.log($($el).html());
//                });

                homeInit();
            });
        </script>   
    </body>
</html>
