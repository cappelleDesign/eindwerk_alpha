<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        $imgRoot = Globals::getRoot('img', 'app') . 'games/';
        ?>                 
        <title>Reviews</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'reviews.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" id="reviews-content">
                <div id="reviews-gallery-pt1" class="rev-gall" style="display: none;">
                    <a href="reviews/detailed/1" data-score="8">
                        <img 
                            src="<?php echo $imgRoot ?>Fallout_4/Fallout_4.png" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Fallout_4/Fallout_4.png"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img                         
                            src="<?php echo $imgRoot ?>Hitman/Hitman.jpeg" 
                            alt="fallout 4" data-image="<?php echo $imgRoot ?>Hitman/Hitman.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >

                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Skyrim/Skyrim.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Skyrim/Skyrim.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_1/Lorem_1.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_1/Lorem_1.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_2/Lorem_2.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_2/Lorem_2.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_3/Lorem_3.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_3/Lorem_3.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">                        
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_4/Lorem_4.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_4/Lorem_4.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">                        
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_5/Lorem_5.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_5/Lorem_5.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">                        
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_6/Lorem_6.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_6/Lorem_6.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                </div>
                <div id="reviews-gallery-pt2" style="display: none;">
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Fallout_4/Fallout_4.png" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Fallout_4/Fallout_4.png"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img                         
                            src="<?php echo $imgRoot ?>Hitman/Hitman.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Hitman/Hitman.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        

                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Skyrim/Skyrim.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Skyrim/Skyrim.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_1/Lorem_1.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_1/Lorem_1.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_2/Lorem_2.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_2/Lorem_2.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_3/Lorem_3.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_3/Lorem_3.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">                        
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_4/Lorem_4.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_4/Lorem_4.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">                        
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_5/Lorem_5.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_5/Lorem_5.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
                    <a href="">                        
                        <img 
                            src="<?php echo $imgRoot ?>Lorem_6/Lorem_6.jpeg" 
                            alt="Fallout 4" data-image="<?php echo $imgRoot ?>Lorem_6/Lorem_6.jpeg"
                            data-description="Fallout 4 <span class='scores'> [ 8/10 ] </span>" >                        
                    </a>
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
                $w = $('#wrapper').width();
                $w = $w / 3;
                $("#reviews-gallery-pt1").unitegallery({
                    tile_as_link: true,
                    tile_link_newpage: false,
                    tile_enable_textpanel: true,
                    tile_textpanel_source: "desc_title",
                    tile_textpanel_title_text_align: "center",
                    tile_textpanel_always_on: true,
                    tiles_col_width: $w,
                    tiles_space_between_cols: 8,
                    tile_textpanel_bg_opacity: 0.8,	
                    tile_textpanel_title_font_size:15	 
                });
            });
        </script>
    </body>
</html>