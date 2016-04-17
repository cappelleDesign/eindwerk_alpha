<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include 'view/includes/header.php';
        $viewRoot = Globals::getRoot('view');
        ?>
        <title>login</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'account.php';
            include 'view/includes/menu.php';
            ?>            
            <div class="fix"></div> 
            <main>
                <form id="loginForm" method="post" action="index.php.action=login" autocomplete="off" class="">
                    
                </form>
            </main>
        </div>         
        <footer>
            <?php include 'view/includes/footer.php'; ?>
        </footer>

        <?php
        include 'view/includes/scripts.php';
        ?> 
        <script>
            
        </script>
    </body>
</html>
