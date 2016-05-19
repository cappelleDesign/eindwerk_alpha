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
            $poster->setId(2);
            $comment0 = new Comment(1, 1, $poster, NULL, 'testing  subcomment added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
            $comment = $db->get(1);

//            $db->add($comment);
//            $obj = $db->getSubComments(1, 5);
//            $db->remove(7);
//            $obj = $db->addVoter(1, 2, 1, 1);
//            $db->removeVoter(1, 2);
//            $db->updateCommentText(6, 'updated true databaseclass');
            $obj = $db->getReviewRootComments(1);
            echo '<h2 style="color:green;">SUCCESS</h2>';
            Globals::cleanDump($obj);
        } catch (Exception $ex) {
            echo '<h2 style="color:red";>ERROR</h2>';
            Globals::cleanDump($ex);
        }
        ?>
    </body>
</html>