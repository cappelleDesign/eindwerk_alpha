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
                        <div class="slider-item" data-destin="the destionation page url" data-imgSrc="view/phpscripts/image.php/hitman.jpg?width=150&AMP;height=400&AMP;cropratio=15:40&AMP;image=/<?php echo $root ?>/images/tmpimages/hitman.jpg">
                            <img src="view/phpscripts/image.php/hitman.jpg?width=1100&AMP;height=400&AMP;cropratio=11:4&AMP;image=/<?php echo $root ?>/images/tmpimages/hitman.jpg" alt="picture of hitman">
                            <div class="slider-desc">
                                <p>Hitman review</p>                                
                                <div class="starts">
                                    <input type="text" class="score" data-readOnly='true' value="8" data-fgColor='#ef4123' data-bgColor='#231f20'>
                                </div>
                            </div>
                        </div>
                        <div class="slider-item" data-imgSrc="view/phpscripts/image.php/skyrim.jpg?width=150&AMP;height=400&AMP;cropratio=15:40&AMP;image=/<?php echo $root ?>/images/tmpimages/skyrim.jpg">
                            <img src="view/phpscripts/image.php/skyrim.jpg?width=1100&AMP;height=400&AMP;cropratio=11:4&AMP;image=/<?php echo $root ?>/images/tmpimages/skyrim.jpg" alt="picture of skyrim">
                            <div class="slider-desc">
                                <p>The elder scrolls V: Skyrim<p>                                
                                <div class="starts">
                                    <input type="text" class="score" data-readOnly='true' value="9" data-fgColor='#ef4123' data-bgColor='#231f20'>
                                </div>
                            </div>
                        </div>
                        <div class="slider-item" data-imgSrc="view/phpscripts/image.php/fallout4.png?width=150&AMP;height=400&AMP;cropratio=15:40&AMP;image=/<?php echo $root ?>/images/tmpimages/fallout4.png">
                            <img src="view/phpscripts/image.php/fallout4.png?width=1100&AMP;height=400&AMP;cropratio=11:4&AMP;image=/<?php echo $root ?>/images/tmpimages/fallout4.png" alt="picture of fallout 4">
                            <div class="slider-desc">
                                <p>Fallout 4<p>                                
                                <div class="starts">
                                    <input type="text" class="score" data-readOnly='true' value="8" data-fgColor='#ef4123' data-bgColor='#231f20'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <div id="newsfeed-holder">
                    <nav id="newsfeed-nav">
                        <ul class="menu">
                            <li class="active">
                                <a href="#">newsfeed1</a>
                            </li>
                            <li>
                                <a href="#">newsfeed2</a>
                            </li>
                            <li>
                                <a href="#">newsfeed3</a>
                            </li>
                            <li>
                                <a href="#">newsfeed4</a>
                            </li>
                            <li>
                                <a href="#">newsfeed5</a>
                            </li>
                            <li>
                                <a href="#">newsfeed6</a>
                            </li>                        
                        </ul>
                    </nav>
                    <div id="newsfeeds">
                        <div id="newsfeed-items">
                            <div class="newsfeed-item">
                                <img class="newsfeed-img" src="view/phpscripts/image.php/newsfeed1.jpg?width=800&AMP;height=320&AMP;cropratio=80:32&AMP;image=/<?php echo $root ?>/images/newsfeeditems/newsfeed_dummy1.jpg" alt="newsfeed1">
                                <div class="newsfeed-desc">
                                    <h2>
                                        Newsfeed item 1
                                    </h2>
                                    <ul>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="newsfeed-item">
                                <img class="newsfeed-img" src="view/phpscripts/image.php/newsfeed2.jpg?width=800&AMP;height=320&AMP;cropratio=80:32&AMP;image=/<?php echo $root ?>/images/newsfeeditems/newsfeed_dummy2.jpg" alt="newsfeed2">
                                <div class="newsfeed-desc">
                                    <h2>
                                        Newsfeed item 2
                                    </h2>
                                    <ul>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="newsfeed-item">
                                <img class="newsfeed-img" src="view/phpscripts/image.php/newsfeed3.jpg?width=800&AMP;height=320&AMP;cropratio=80:32&AMP;image=/<?php echo $root ?>/images/newsfeeditems/newsfeed_dummy3.jpg" alt="newsfeed3">
                                <div class="newsfeed-desc">
                                    <h2>
                                        Newsfeed item 3
                                    </h2>
                                    <ul>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="newsfeed-item">
                                <img class="newsfeed-img" src="view/phpscripts/image.php/newsfeed4.jpg?width=800&AMP;height=320&AMP;cropratio=80:32&AMP;image=/<?php echo $root ?>/images/newsfeeditems/newsfeed_dummy4.jpg" alt="newsfeed4">
                                <div class="newsfeed-desc">
                                    <h2>
                                        Newsfeed item 4
                                    </h2>
                                    <ul>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="newsfeed-item">
                                <img class="newsfeed-img" src="view/phpscripts/image.php/newsfeed5.jpg?width=800&AMP;height=320&AMP;cropratio=80:32&AMP;image=/<?php echo $root ?>/images/newsfeeditems/newsfeed_dummy5.jpg" alt="newsfeed5">
                                <div class="newsfeed-desc">
                                    <h2>
                                        Newsfeed item 5
                                    </h2>
                                    <ul>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="newsfeed-item">
                                <img class="newsfeed-img" src="view/phpscripts/image.php/newsfeed6.jpg?width=800&AMP;height=320&AMP;cropratio=80:32&AMP;image=/<?php echo $root ?>/images/newsfeeditems/newsfeed_dummy6.jpg" alt="newsfeed6">
                                <div class="newsfeed-desc">
                                    <h2>
                                        Newsfeed item 6
                                    </h2>
                                    <ul>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit.</p>
                                        </li>
                                        <li>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio quis vel iste distinctio impedit adipisci.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>         
        <footer>
            <?php include dirname(__FILE__) . '/../includes/footer.php'; ?>
        </footer>

        <?php
        include dirname(__FILE__) . '/../includes/scripts.php';
        ?> 
        <script>
            $(document).ready(function () {
                $('.score').knob({
                    'min': 0,
                    'max': 10,
                    'width': 50,
                    'height': 50,
                    'font': 'Play'
                });
                $('#inf-slider').slick({
                    prevArrow: '<div class="slider-left"><img src=""><i class="fa fa-chevron-left"></i></div>',
                    nextArrow: '<div class="slider-right"><img src=""><i class="fa fa-chevron-right"></i></div>'
                });
                setPrevAndNext();
            });
        </script>
    </body>
</html>
