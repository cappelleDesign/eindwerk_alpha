<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include dirname(__FILE__) . '/../includes/header.php';
        $root = 'eindwerk_alpha/view';
        ?>
        <title>home</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'home';
            include dirname(__FILE__) . '/../includes/menu.php';
            ?>            
            <div class="fix"></div> 
            <main>
                <div id="inf-slider-holder">
                    <div id="inf-slider">
                        <a href="#" class="slider-item">
                            <img src="view/phpscripts/image.php/hitman.jpg?width=800&AMP;height=300&AMP;cropratio=8:3&AMP;image=/<?php echo $root?>/images/tmpimages/hitman.jpg" alt="picture of hitman">
                            <div class="slider-desc">
                                <p>Hitman review<p>                                
                                <div class="starts">
                                    <i>8<i/>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="slider-item">
                            <img src="view/phpscripts/image.php/skyrim.jpg?width=800&AMP;height=300&AMP;cropratio=8:3&AMP;image=/<?php echo $root?>/images/tmpimages/skyrim.jpg" alt="picture of skyrim">
                            <div class="slider-desc">
                                <p>The elder scrolls V: Skyrim<p>                                
                                <div class="starts">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="slider-item">
                            <img src="view/phpscripts/image.php/fallout4.png?width=800&AMP;height=300&AMP;cropratio=8:3&AMP;image=/<?php echo $root?>/images/tmpimages/fallout4.png" alt="picture of fallout 4">
                            <div class="slider-desc">
                                <p>Fallout 4<p>                                
                                <div class="starts">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>                

                <!--<img src="view/images/tmpimages/hitman.jpg">-->
            </main>
        </div> 
        <footer></footer>

        <?php
        include dirname(__FILE__) . '/../includes/scripts.php';
        ?> 
        <script>
            $(document).ready(function () {
                $('#inf-slider').slick({
                    prevArrow : '<div class="slider-left">Previous Review</div>',
                    nextArrow : '<div class="slider-right">Next Review</div>'
                });
            });
        </script>
    </body>
</html>
