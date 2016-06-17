<h1>MASTER SERVICE TESTING</h1>
<?php
try {
    
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
?>
<h1>UPLOAD TESTS</h1>


<form action="imgUploadTest" method="POST" enctype="multipart/form-data">      
    headerImg: <input type="file" name="uploadImg[]"><br><br>    
    gallery1: <input type="file" name="uploadImg[]"><br><br>    
    gallery2: <input type="file" name="uploadImg[]"><br><br>
    gallery3: <input type="file" name="uploadImg[]"><br><br>
    <input type="submit" name="submit" value="SEND"><br><br>
</form>