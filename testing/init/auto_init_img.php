<!doctype html>
<html>
    <head>
        <title>init master</title>
    </head>
    <body>     

        <h1>    
            add review images
        </h1>
        <form action="autoInit" method="POST" enctype="multipart/form-data">          
            <label for="avatar">Avatar pic:</label><br>
            <input id="avatar" name="uploadImg[]" type="file"><br><br>                                
            <label for="headerPic">Hitman Header pic:</label><br>
            <input id="headerPic" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery1">Hitman Gallery:</label><br>
            <input id="gallery1" name="uploadImg[]" type="file"><br>
            <input id="gallery2" name="uploadImg[]" type="file"><br>        
            <input id="gallery3" name="uploadImg[]" type="file"><br><br>        

            <label for="headerPic2">Fallout 4 Header pic:</label><br>
            <input id="headerPic2" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery2">Fallout 4 Gallery:</label><br>
            <input id="gallery4" name="uploadImg[]" type="file"><br>
            <input id="gallery5" name="uploadImg[]" type="file"><br>        
            <input id="gallery6" name="uploadImg[]" type="file"><br><br>    

            <label for="headerPic3">Skyrim Header pic:</label><br>
            <input id="headerPic3" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery7">Skyrim Gallery:</label><br>
            <input id="gallery7" name="uploadImg[]" type="file"><br>
            <input id="gallery8" name="uploadImg[]" type="file"><br>        
            <input id="gallery9" name="uploadImg[]" type="file"><br><br>    

            <input type="submit" value="MAGIC">
        </form>
    </body>
</html>
<?php
