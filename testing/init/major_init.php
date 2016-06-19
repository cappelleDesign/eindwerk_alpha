<!doctype html>
<html>
    <head>
        <title>init</title>
    </head>
    <body>
        <h1>
            Admin registering process
        </h1>
        <form action="initHandler" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label><br>
            <input id="username" name="username" type="text"><br><br>
            <label for="pw">password:</label><br>
            <input id="pw" name="pw" type="password"><br><br>
            <label for="email">Mail:</label><br>
            <input id="email" name="email" type="text"><br><br>
            <label for="avatar">Avatar:</label><br>
            <input id="avatar" name="uploadImg[]" type="file"><br><br>            
            <input type="submit" value="MAGIC">
        </form>
        
        
        
        <h1>
            Review registering process
        </h1>
        <form action="initHandler" method="POST" enctype="multipart/form-data">
            <label for="writerName">User:</label><br>
            <input id="writerName" name="writerName" type="text"><br><br>
            
            <!--GAME-->
            <label for="gameName">Game name:</label><br>
            <input id="gameName" name="gameName" type="text"><br><br>            
            <label for="release">Game release:</label><br>
            <input id="release" name="release" type="date"><br><br>
            <label for="website">Game official site:</label><br>
            <input id="website" name="website" type="text"><br><br>
            <label for="publisher">Publisher:</label><br>
            <input id="publisher" name="publisher" type="text"><br><br>
            <label for="developer">Developer:</label><br>
            <input id="developer" name="developer" type="text"><br><br>
            <label for="min_online">Minimum online players:</label><br>
            <input id="min_online" name="min_online" type="text"><br><br>
            <label for="max_online">Maximum online players:</label><br>
            <input id="max_online" name="max_online" type="text"><br><br>
            <label for="max_offline">Maximum offline players:</label><br>
            <input id="max_offline" name="max_offline" type="text"><br><br>
            <label for="max_story">Max story players:</label><br>
            <input id="max_story" name="max_story" type="text"><br><br>
            <label for="genre">Genere:</label><br>
            <input id="genre" name="genre[]" type="text"><br><br>
            <label for="platform">Platform:</label><br>
            <input id="platform" name="platform[]" type="text"><br><br>
            
            <label for="rev_plat">Review platform:</label><br>
            <input id="rev_plat" name="rev_plat" type="text"><br><br>
            <label for="title">Review Title:</label><br>
            <input id="title" name="title" type="text"><br><br>
            <label for="score">Review score:</label><br>
            <input id="score" name="score" type="number"><br><br>
            <label for="body">Review body:</label><br>
            <textarea id="body" name="body"></textarea><br><br>
            <label for="vid_url">Review video url:</label><br>
            <input id="vid_url" name="vid_url" type="text"><br><br>
            <label for="good1">Review goods:</label><br>
            <input id="good1" name="goods[]" type="text"><br>
            <input id="good2" name="goods[]" type="text"><br>
            <input id="good3" name="goods[]" type="text"><br><br>
            <label for="bad1">Review bads:</label><br>
            <input id="bad1" name="bads[]" type="text"><br>
            <input id="bad2" name="bads[]" type="text"><br>
            <input id="bad3" name="bads[]" type="text"><br><br>
            <label for="tag1">Review tags:</label><br>
            <input id="tag1" name="tags[]" type="text"><br>
            <input id="tag2" name="tags[]" type="text"><br>
            <input id="tag3" name="tags[]" type="text"><br><br>         
            
            <label for="headerPic">Header pic:</label><br>
            <input id="headerPic" name="uploadImg[]" type="file"><br><br>            
            <label for="gallery1">Gallery:</label><br>
            <input id="gallery1" name="uploadImg[]" type="file"><br>
            <input id="gallery2" name="uploadImg[]" type="file"><br>        
            <input id="gallery3" name="uploadImg[]" type="file"><br><br>        
            
            <input type="submit" value="MAGIC">
        </form>
    </body>
</html>
<?php
