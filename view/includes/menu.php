<header>
    <form>
        <div class="form-group">
            <input type="text" placeholder="search games..">
            <a class="btn" href="#">
                <i class="fa fa-search"></i>
            </a>
        </div>
    </form>
    <div id="menuAddon">
        <div id="account-panel">
            <a href="#" class="list-group-item">
                <i class="fa fa-user fa-fw"></i>
                No profile
                <i class="fa fa-caret-down fa-fw"></i>
            </a>     
            <div class="account-drop-down">
                <a href="#login" class="list-group-item">
                    <i class="fa fa-sign-in fa-fw"></i>
                    Log In
                </a>
                <a href="#register" class="list-group-item">
                    <i class="fa fa-certificate fa-fw"></i>
                    Register
                </a>
            </div>
        </div>
        <div class="social-menu">
    <ul>
        <li>
            <a href="#">
                <span class="fa-stack ">
                    <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                    <i class="fa fa-envelope fa-stack-1x"></i>
                </span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="fa-stack ">
                    <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                    <i class="fa fa-facebook fa-stack-1x"></i>
                </span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="fa-stack">
                    <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                    <i class="fa fa-youtube fa-stack-1x"></i>
                </span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="fa-stack">
                    <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                    <i class="fa fa-twitch fa-stack-1x"></i>
                </span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="fa-stack">
                    <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                    <i class="fa fa-twitter fa-stack-1x"></i>
                </span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="fa-stack">
                    <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                    <i class="fa fa-paypal fa-stack-1x"></i>
                </span>
            </a>
        </li>
    </ul>
</div>
    </div>
</header>

<nav>
    <ul class="menu">
        <?php
        $menu = $this->getMenu('main');
        foreach ($menu as $menuItem) {
            ?>
            <li class="<?php echo $page === $menuItem->getPageName() ? 'active' : '' ?>">
                <a href="index.php?action=<?php echo $menuItem->getAction(); ?>" >
                    <?php echo $menuItem->getDescription(); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>    
