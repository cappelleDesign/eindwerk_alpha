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
            $obj = 'testing without print';
            $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
            $voteDb = new VoteSqlDB($connection);
            $genDistDb = new GeneralDistSqlDB($connection);
            $notifDB = new NotificationSqlDB($connection);
            $userDist = new UserDistSqlDB($connection, $genDistDb, $voteDb);
            $userDb = new UserSqlDB($connection, $userDist, $notifDB);
            $commentDb = new CommentSqlDB($connection, $userDb, $voteDb);

            $userRole = new UserRole('test', 1, 0, 0);
            $image = new Image('trut', 'test');
            $avatar = new Avatar($image, 1);
            $username = 'test';
            $donated = false;
            $poster = new UserSimple($userRole, $avatar, $username, $donated);
            $poster->setId(2);
            $comment0 = new Comment(1, 1, $poster, NULL, 'testing  subcomment added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
            $comment = $commentDb->get(1);

//            $commentDb->add($comment0);
//            $obj = $commentDb->getSubComments(1, 5);
//            $commentDb->remove(3);
//            $obj = $commentDb->addVoter(1, 2, 1, 1);
//            $commentDb->removeVoter(1, 2);
//            $commentDb->updateCommentText(2, 'updated true databaseclass');
//            $obj = $commentDb->getReviewRootComments(1);
//            $obj = $commentDb->getSuperParentId(4);
            echo '<h2 style="color:green;">SUCCESS</h2>';
            Globals::cleanDump($obj);
        } catch (Exception $ex) {
            echo '<h2 style="color:red";>ERROR</h2>';
            Globals::cleanDump($ex);
        }
        ?>
    </body>
</html>