<?php
$imgHelper = new imageHelper();

$hitmanSrcs = $imgHelper->getCarouselSourceArray('tmpimages', 'hitman.jpg');

$skySrcs = $imgHelper->getCarouselSourceArray('tmpimages', 'skyrim.jpg');

$foSrcs = $imgHelper->getCarouselSourceArray('tmpimages', 'fallout4.png');
$newsfeedPics = [
    'newsfeed_dummy1.jpg',
    'newsfeed_dummy2.jpg',
    'newsfeed_dummy3.jpg',
    'newsfeed_dummy4.jpg',
    'newsfeed_dummy5.jpg',
    'newsfeed_dummy6.jpg'
];
$newsfeedSrcs = $imgHelper->getNewsfeedSourceArray($newsfeedPics);
//Globals::cleanDump($newsfeedSrcs['newsfeed_dummy6.jpg']);
//Globals::cleanDump($hitmanSrcs['sideXL']);
//Globals::cleanDump($skySrcs['sideXL']);
//Globals::cleanDump($foSrcs['sideXL']);
//die(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'view/includes/header.php';
        ?>
        <title>home</title>
    </head>
    <body> 
        <?php
        include 'view/includes/no-js.php';
        ?>
        <div id="wrapper" class="no-js-push">
            <?php
            $page = basename(__FILE__);
            include 'view/includes/menu.php';
            ?>            
            <div class="fix"></div> 
            <main>
                <div id="inf-slider-holder">
                    <div id="inf-slider">
                        <div class="slider-item primary-slide" data-destin="the destionation page url" data-img-path="tmpimages" data-img-url="hitman.jpg" data-img-src="<?php echo $hitmanSrcs['sideXL']; ?> ">                            
                            <div class="noScript">
                                <picture>
                                    <source srcset="<?php echo $hitmanSrcs['m-pri']; ?>" media="(max-width: 1040px)"> 
                                    <source srcset="<?php echo $hitmanSrcs['l']; ?>" media="(max-width: 1500px)"> 
                                    <img src="<?php echo $hitmanSrcs['xl']; ?>" alt="picture of hitman">
                                </picture>            
                                <div class="slider-desc">
                                    <p>Hitman review</p>                                
                                    <div class="stars">
                                        <i>8</i>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $html = '<div class="slider-desc">' +
                                        '<p>Hitman review</p>' +
                                        '<div class="stars">' +
                                        '<input type="text" class="score" data-readOnly="true" value="8" data-fgColor="#ef4123" data-bgColor="#231f20">' +
                                        '</div>' +
                                        '</div>' +
                                        '<img class="jsImg" src="<?php echo $hitmanSrcs['xl']; ?>" alt="picture of hitman">';
                                document.write($html);
                            </script>

                        </div>
                        <div class="slider-item secondary-slide" data-destin="the destionation page url" data-img-path="tmpimages" data-img-url="skyrim.jpg" data-img-src="<?php echo $skySrcs['sideXL']; ?>">
                            <div class="noScript">
                                <picture>
                                    <source srcset="<?php echo $skySrcs['m-sec']; ?>" media="(max-width: 1040px)">
                                    <source srcset="<?php echo $skySrcs['l']; ?>" media="(max-width: 1500px)">
                                    <img src="<?php echo $skySrcs['xl']; ?>" alt="picture of skyrim">
                                </picture>
                                <div class="slider-desc">
                                    <p>The elder scrolls V: Skyrim<p>                                
                                    <div class="stars">
                                        <i>9</i>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $html = '<div class="slider-desc">' +
                                        '<p>The elder scrolls V: Skyrim<p>   ' +
                                        '<div class="stars">' +
                                        '<input type="text" class="score" data-readOnly="true"value="9" data-fgColor="#ef4123" data-bgColor="#231f20">' +
                                        '</div>' +
                                        '</div>' +
                                        '<img class="jsImg" src="<?php echo $skySrcs['xl']; ?>" alt="picture of skyrim">';
                                document.write($html);
                            </script>

                        </div>
                        <div class="slider-item secondary-slide" data-destin="the destionation page url" data-img-path="tmpimages" data-img-url="fallout4.png" data-img-src="<?php echo $foSrcs['sideXL']; ?>">                                                       
                            <div class="noScript">
                                <picture>                                
                                    <source srcset="<?php echo $foSrcs['m-sec']; ?>" media="(max-width: 1040px)">
                                    <source srcset="<?php echo $foSrcs['l']; ?>" media="(max-width: 1500px)">
                                    <img src="<?php echo $foSrcs['xl']; ?>" alt="picture of fallout 4">
                                </picture>      
                                <div class="slider-desc">
                                    <p>Fallout 4<p>                                
                                    <div class="stars">
                                        <i>9</i>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $html = '<div class="slider-desc">' +
                                        '<p>Fallout 4<p>' +
                                        '<div class="stars">' +
                                        '<input type="text" class="score" data-readOnly="true" value="8" data-fgColor="#ef4123" data-bgColor="#231f20" >' +
                                        '</div>' +
                                        '</div>' +
                                        '<img class="jsImg" src="<?php echo $foSrcs['xl']; ?>" alt="picture of fallout 4">';
                                document.write($html);
                            </script>                            
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
                                <div class="noScript">
                                    <picture>
                                        <source srcset="<?php echo $newsfeedSrcs['newsfeed_dummy1.jpg']['l']; ?>" media="(max-width: 1500px)">
                                        <img class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy1.jpg']['xl']; ?>" alt="newsfeed1">
                                    </picture>                                    
                                </div>
                                <script>
                                    $html = '<img data-newsfeed-img="newsfeed_dummy1.jpg" class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy1.jpg']['xl']; ?>" alt="newsfeed1">';
                                    document.write($html);
                                </script>
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
                                <div class="noScript">
                                    <picture>
                                        <source srcset="<?php echo $newsfeedSrcs['newsfeed_dummy2.jpg']['l']; ?>" media="(max-width: 1500px)">
                                        <img class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy2.jpg']['xl']; ?>" alt="newsfeed2">
                                    </picture>
                                </div>
                                <script>
                                    $html = '<img data-newsfeed-img="newsfeed_dummy2.jpg" class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy2.jpg']['xl']; ?>" alt="newsfeed2">';
                                    document.write($html);
                                </script>
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
                                <div class="noScript">
                                    <picture>
                                        <source srcset="<?php echo $newsfeedSrcs['newsfeed_dummy3.jpg']['l']; ?>" media="(max-width: 1500px)">
                                        <img class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy3.jpg']['xl']; ?>" alt="newsfeed3">
                                    </picture>
                                </div>
                                <script>
                                    $html = '<img data-newsfeed-img="newsfeed_dummy3.jpg" class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy3.jpg']['xl']; ?>" alt="newsfeed3">';
                                    document.write($html);
                                </script>
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
                                <div class="noScript">
                                    <picture>
                                        <source srcset="<?php echo $newsfeedSrcs['newsfeed_dummy4.jpg']['l']; ?>" media="(max-width: 1500px)">
                                        <img class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy4.jpg']['xl']; ?>" alt="newsfeed4">
                                    </picture>
                                </div>
                                <script>
                                    $html = '<img data-newsfeed-img="newsfeed_dummy4.jpg" class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy4.jpg']['xl']; ?>" alt="newsfeed4">';
                                    document.write($html);
                                </script>
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
                                <div class="noScript">
                                    <picture>
                                        <source srcset="<?php echo $newsfeedSrcs['newsfeed_dummy5.jpg']['l']; ?>" media="(max-width: 1500px)">
                                        <img class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy5.jpg']['xl']; ?>" alt="newsfeed5">
                                    </picture>
                                </div>
                                <script>
                                    $html = '<img data-newsfeed-img="newsfeed_dummy5.jpg" class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy5.jpg']['xl']; ?>" alt="newsfeed5">';
                                    document.write($html);
                                </script>
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
                                <div class="noScript">
                                    <picture>
                                        <source srcset="<?php echo $newsfeedSrcs['newsfeed_dummy5.jpg']['l']; ?>" media="(max-width: 1500px)">
                                        <img class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy6.jpg']['xl']; ?>" alt="newsfeed6">
                                    </picture>
                                </div>
                                <script>
                                    $html = '<img data-newsfeed-img="newsfeed_dummy6.jpg" class="newsfeed-img" src="<?php echo $newsfeedSrcs['newsfeed_dummy6.jpg']['xl']; ?>" alt="newsfeed6">';
                                    document.write($html);
                                </script>
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
            <?php include 'view/includes/footer.php'; ?>
        </footer>

        <?php
        include 'view/includes/scripts.php';
        ?> 
        <script>
            $viewRoot = '<?php echo Globals::getRoot('view') ?>';
            $(document).ready(function () {
                $('.score').knob({
                    'min': 0,
                    'max': 10,
                    'width': 50,
                    'height': 50,
                    'font': 'Play'
                });
                homePageRepaint();
                $(window).resize(function () {
                    homePageRepaint();
                });

            });
        </script>
    </body>
</html>
