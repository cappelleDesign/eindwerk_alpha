<!DOCTYPE>
<html>
    <head>

    </head>
    <body>
        <h1>
            Testing comment db functions
        </h1>
        <?php
        try {
            $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
            $userDb = new UserSqlDB($connection);
            $db = new CommentSqlDB($connection, $userDb);
            $userRole = new UserRole('test', 1, 0, 0);
            $image = new Image('trut', 'test');
            $avatar = new Avatar($image, 1);
            $username = 'test';
            $donated = false;
            $poster = new UserSimple($userRole, $avatar, $username, $donated);
            $poster->setId(1);
            $comment = new Comment(1, $poster, NULL, 'testing  subcomment added using db', '21/10/2015 00:00:00', NULL, Globals::getDateTimeFormat('be', true));
//            $db->add($comment);
//            $obj = $db->getByString('yeah buddy');
//            $db->remove(48);
            $obj = $db->addVoter(1, 2, 1);
            echo '<h2 style="color:green;">SUCCESS</h2>';
            Globals::cleanDump($obj);
        } catch (Exception $ex) {
            echo '<h2 style="color:red";>ERROR</h2>';
            Globals::cleanDump($ex);
        }
        ?>
    </body>
</html>