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
            <input type="hidden" id="avatarField" name="avatarField" value="avatarField">
            <label for="avatar">Avatar pic:</label><br>
            <input id="avatar" name="uploadImg[]" type="file"><br><br>    
            <input type="submit" value="MAGIC">
        </form>
        <hr>
         <form action ="autoInit" method ="POST" enctype="multipart/form-data">
             <input type="number" id="lorem" name="lorem" value=""><br><br>
            <label for="headerPicLorem">lorem Header pic:</label><br>
            <input id="headerPicLorem" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery1Lorem">Lorem Gallery:</label><br>
            <input id="gallery1Lorem" name="uploadImg[]" type="file"><br>
            <input id="gallery2Lorem" name="uploadImg[]" type="file"><br>        
            <input id="gallery4Lorem" name="uploadImg[]" type="file"><br>
            <input id="gallery5Lorem" name="uploadImg[]" type="file"><br>
            <input id="gallery6Lorem" name="uploadImg[]" type="file"><br>
            <input id="gallery7Lorem" name="uploadImg[]" type="file"><br>
            <input id="gallery8Lorem" name="uploadImg[]" type="file"><br><br>        
            <input type="submit" value="MAGIC">
         </form>
        <hr>
        <form action ="autoInit" method ="POST" enctype="multipart/form-data">
            <input type="hidden" id="hitmanField" name="hitmanField" value="hitmanField">
            <label for="headerPic">Hitman Header pic:</label><br>
            <input id="headerPic" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery1">Hitman Gallery:</label><br>
            <input id="gallery1" name="uploadImg[]" type="file"><br>
            <input id="gallery2" name="uploadImg[]" type="file"><br>        
            <input id="gallery3" name="uploadImg[]" type="file"><br><br>        
            <input type="submit" value="MAGIC">
        </form>
        <hr>
        <form action ="autoInit" method ="POST" enctype="multipart/form-data">
            <input type="hidden" id="foField" name="foField" value="foField">
            <label for="headerPic2">Fallout 4 Header pic:</label><br>
            <input id="headerPic2" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery2">Fallout 4 Gallery:</label><br>
            <input id="gallery4" name="uploadImg[]" type="file"><br>
            <input id="gallery5" name="uploadImg[]" type="file"><br>        
            <input id="gallery6" name="uploadImg[]" type="file"><br><br>    
            <input type="submit" value="MAGIC">
        </form>
        <hr>
        <form action ="autoInit" method ="POST" enctype="multipart/form-data">
            <input type="hidden" id="skyField" name="skyField" value="skyField">
            <label for="headerPic3">Skyrim Header pic:</label><br>
            <input id="headerPic3" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery7">Skyrim Gallery:</label><br>
            <input id="gallery7" name="uploadImg[]" type="file"><br>
            <input id="gallery8" name="uploadImg[]" type="file"><br>        
            <input id="gallery9" name="uploadImg[]" type="file"><br><br>    
            <input type="submit" value="MAGIC">
        </form>
        <hr>
        <form action ="autoInit" method ="POST" enctype="multipart/form-data">
            <input type="hidden" id="newsfeedField" name="newsfeedField" value="newsfeedField">
            <label for="newsfeed1">Newsfeed images</label><br>
            <input id="newsfeed1" name="uploadImg[]" type="file"><br>
            <input id="newsfeed2" name="uploadImg[]" type="file"><br>
            <input id="newsfeed3" name="uploadImg[]" type="file"><br>        
            <input id="newsfeed4" name="uploadImg[]" type="file"><br>        
            <input id="newsfeed5" name="uploadImg[]" type="file"><br>        
            <input id="newsfeed6" name="uploadImg[]" type="file"><br><br>    
            <input type="submit" value="MAGIC">
        </form>
    </body>
</html>
<?php
