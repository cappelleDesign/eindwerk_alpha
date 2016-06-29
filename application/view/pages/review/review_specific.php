<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        $review = json_decode($_POST['review'])[0];
        $vidUrl = $review->review_video_url;
        $vidId = explode('=', $vidUrl)[1];
        $game = $review->review_game;
        $userScore = '5';
        $user = $this->getCurrentUser();
        $userId = $user ? $user->getId() : '-1';

        if ($userId) {
            foreach ($review->review_user_scores as $id => $score) {
                if ($id == $userId) {
                    $userScore = $score;
                }
            }
        }
        ?>        
        <title>Review specific</title>
        <!--FIXME TITLE SHOULD BE CHANGED TO THE NAME OF THE REVIEW-->
    </head>
    <body class="customScroll">
        <div id="neo-wrapper">
            <?php
            $page = 'reviews.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" class="content review-specific">
                <div id="mobile-rating">
                    <div id="rating-sub">                        
                        <div class = "rate-score-holder">
                            <input type="text" id="user-score-set-mobile"
                            <?php echo $user ? '' : 'data-readOnly="true"'
                            ?>
                                   value="<?php echo $userScore ?>"  
                                   data-review-id="<?php echo $review->review_id; ?>"
                                   data-user-id="<?php echo $userId; ?>">
                        </div>
                        <div class="rate-btn">
                            <a href="#" id="send-user-score-mobile"
                               class="btn neo-btn neo-btn-inversed <?php echo $user ? '' : 'disabled' ?>">
                                Rate!
                            </a>
                        </div>
                        <div class="fix"></div>
                    </div>                                         
                </div>
                <div id="mobile-review-tabs">
                    <!--<a data-destin="main-review" href="">Main review</a>-->
                    <!--<a data-destin="review-side-panel" href="">User reviews</a>-->
                </div>
                <div id="main-review"> 
                    <div id="vidBuildTmp" style="display: none"
                         data-alt="<?php echo $review->review_title; ?>"
                         data-type="youtube"  data-src="<?php echo Globals::getGameHeaderRoot($game->game_name) . $review->review_header_img->img_url; ?>"
                         data-image="<?php echo Globals::getGameHeaderRoot($game->game_name) . $review->review_header_img->img_url; ?>"
                         data-description="<?php echo $review->review_title ?>"
                         data-videoid="<?php echo $vidId ?>">
                    </div>
                    <div id="review-carousel" class="slides">       
                        <?php foreach ($review->review_gallery as $gal) { ?>
                            <div>
                                <a href="<?php echo Globals::getGameGalleryRoot($game->game_name) . $gal->img_url ?>" data-lightbox="gallery" data-title="<?php $game->game_name ?> gallery">                                
                                    <img alt="Himan gallery pic"                       
                                         src="<?php echo Globals::getImagePhpUrl(100, 100, Globals::getGameGalleryRoot($game->game_name, true), $gal->img_url); ?>">     
                                </a>
                            </div>
                        <?php } ?>
                    </div>      
                    <div class="fix"></div>
                    <div id="review-bgt">
                        <div class="left bgt-panel">

                            <ul>
                                <?php foreach ($review->review_goods as $good) { ?>                                
                                    <li><i class="fa fa-fw fa-plus"></i><?php echo $good; ?></li>

                                <?php } ?>
                            </ul>                            
                        </div>
                        <div class="right bgt-panel">                            
                            <ul>
                                <?php foreach ($review->review_bads as $bad) { ?>
                                    <li><i class="fa fa-fw fa-minus"></i><?php echo $bad; ?></li>                                   
                                <?php } ?>
                            </ul>
                        </div>
                        <div style="clear:both;"></div>
                    </div>                    
                    <div id="review-body">
                        <p>
                            <?php echo html_entity_decode($review->review_text); ?>
                        </p>
                    </div>
                </div>
                <div id="review-side-panel">
                    <div id="trigger-side">
                        <a href="" class="">
                            <i class="fa fa-fw fa-list animated faa-pulse faa-slow">                            
                            </i>
                        </a>
                    </div>
                    <div id="side-content">
                        <div class="user-score-related">
                            <?php
                            if ($user) {
                                ?>
                                <h3>Rate this game</h3>
                                <?php
                            } else {
                                ?>
                                <h3><a href="account/" class="inline-link">Log in</a> to rate this game</h3>
                                <?php
                            }
                            ?>
                            <div id="user-score-container">
                                <input type="text" id="user-score-set"
                                <?php echo $user ? '' : 'data-readOnly="true"' ?>
                                       value="<?php echo $userScore ?>"  
                                       data-review-id="<?php echo $review->review_id; ?>"
                                       data-user-id="<?php echo $userId; ?>">
                            </div>
                            <a href="#" id="send-user-score"
                               class="btn neo-btn neo-btn-inversed <?php echo $user ? '' : 'disabled' ?>">
                                Rate!
                            </a>
                            <div id="avg-score">
                                <p>AVG: <strong class="user-avg"><?php echo $review->review_avg > -1 ? $review->review_avg : 'N/A' ?></strong></p>
                            </div>
                        </div>
                        <div id="user-review-container">
                            <div class="user-review"></div>
                        </div>
                    </div>
                </div>
                <div class="fix"></div>
            </main> 
            <?php ?>
        </div>
        <footer>
            <?php $this->includeFooter();
            ?>
        </footer>

        <?php
        $this->includeScripts();
        ?> 
        <script>
            $(reviewSpecificInit);
        </script>
    </body>
</html>
