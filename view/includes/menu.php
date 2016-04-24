<div class="noScript noScript-heading">
    <p>You have disabled javascript. This will have a great effect on how the site will work for you. we recommend you to turn javascript back on</p>
</div>
<header>
    <div class="mobile-menu-addon">
        <a id="mobile-social-trigger" href="#"><i class="fa fa-heart"></i></a>
        <a id="mobile-profile-trigger" href="#"><i class="fa fa-user"></i></a>
        <a id="mobile-search-trigger" href="#"><i class="fa fa-search"></i></a>
    </div>
    <div id="mobile-menu-addon-extended">
        <div id="mobile-addon-content">           
        </div>
        <i class="fa fa-times"></i>
    </div>
    <div class="logo">
        <img id="main-logo" src="view/images/design/logoNoBackTest.png" alt="neoludus logo">
    </div>
    <form id="search-form" class="search-form-main" method="POST" action="#">
        <div class="form-group">
            <input type="text" placeholder="search games.." tabindex="1">
            <a class="script-only" id="main-search" href="#" tabindex="2">
                <i class="fa fa-search"></i>
            </a>
            <button class="noScript" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
    <div id="menuAddon" class="no-js-push">
        <div id="account-panel" tabindex="3">
            <a href="#" class="">
                <i class="fa fa-user fa-fw"></i>
                No profile
                <i class="fa fa-caret-down fa-fw"></i>
            </a>     
            <div class="account-drop-down">
                <a href="#login" class="">
                    <i class="fa fa-sign-in fa-fw"></i>
                    Log In
                </a>
                <a href="#register" class="">
                    <i class="fa fa-pencil-square-o fa-fw"></i>
                    Register
                </a>
            </div>
        </div>
        <div class="social-menu">
            <ul>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack ">                           
                            <i class="fa fa-envelope" title="Mail us" aria-hidden="true"></i>                            
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack">                            
                            <i class="fa fa-facebook" title="Visit our Facebook page" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack">
                            <i class="fa fa-youtube" title="Visit our Youtube channel" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack">
                            <i class="fa fa-twitch" title="Visit our Twitch channel" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack">
                            <i class="fa fa-twitter" title="Visit our Twitter page" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack">
                            <i class="fa fa-paypal" title="Make a donation" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<nav>
    <div id="menu-box">
        <ul class="menu" id="main-menu">
            <?php
            $subMenuCount = 1;
            $menu = $this->getMenu('main');
            foreach ($menu as $menuItem) {
                echo getLinkHtml($menuItem, $page, $subMenuCount);
            }
            ?>
        </ul>
    </div>
</nav>    
<?php

function getLinkHtml($menuItem, $page, $subMenuCount) {
    $active = $page === $menuItem->getPageName() ? 'active' : '';
    $subMenu = $menuItem->getSubMenu();
    $subMenuClass = $subMenu ? $subMenuCount : '0';
    $html = '<li class="' . $active . ' submenu-trigger" data-submenu-trigger="' . $subMenuClass . '">';
    $html .= '<a href="index.php?action=' . $menuItem->getAction() . '">' . $menuItem->getDescription() . '</a>';
    if ($subMenu) {
        $html.= '<ul class="menu submenu submenu-' . $subMenuCount . '">';
        $subMenuCount++;
        foreach ($subMenu as $subMenuItem) {
            $html.= getLinkHtml($subMenuItem, 'N/A', 'N/A');
        }
        $html.= '</ul>';
    }
    $html .= '</li>';
    return $html;
}
?>