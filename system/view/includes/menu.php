<?php
$viewRoot = Globals::getRoot('view', 'app');
$user = $this->getCurrentUser(FALSE);
$userN = 'No profile';
if($user){
    $userN = $user->getUsername();
}
$iconsNotLoggedIn = '<a href="index.php/account/loginpage" class="">' .
        '<i class="fa fa-sign-in fa-fw"></i>' .
        'Log In' .
        '</a>' .
        '<a href="index.php/account/registerpage" class="">' .
        '<i class="fa fa-pencil-square-o fa-fw"></i>' .
        'Register' .
        '</a>';
$iconsLoggedIn = '<a href="index.php/account/logout" class="">' .
        '<i class="fa fa-sign-out fa-fw"></i>' .
        'Sign out' .
        '</a>' .
        '<a href="index.php/account/getNotifications" class="">' .
        '<i class="fa fa-bell fa-fw"><span class="notif-count">1 new</span></i>' . 
        'Notifications' . 
        '</a>';
$accountHtml = '<a href="#" class="">' .
        '<i class="fa fa-user fa-fw"></i>' .
        '<p>' . ($userN) . '</p>' .
        '<i class="fa fa-caret-down fa-fw"></i>' .
        '</a>' . '<div class="fix"></div>' .
        '<div class="account-drop-down">' .
        ($user ? $iconsLoggedIn : $iconsNotLoggedIn) .
        '</div>';
?>
<div class="noScript noScript-heading">
    <p>You have disabled javascript. This will have a great effect on how the site will work for you. we recommend you to turn javascript back on</p>
</div>
<header>
    <div class="mobile-menu-addon">
        <a id="mobile-social-trigger" href="#"><i class="fa fa-heart"></i></a>
        <a id="mobile-profile-trigger" href="#"><i class="fa fa-user"></i></a>
        <a id="mobile-search-trigger" href="#"><i class="fa fa-search"></i></a>
        <a id="mobile-notification-trigger" href="#"><i class="fa fa-bell"></i></a>
    </div>
    <div id="mobile-menu-addon-extended">
        <div id="mobile-addon-content">           
        </div>
        <i class="fa fa-times"></i>
    </div>
    <div class="logo">
        <img id="main-logo" src="<?php echo $viewRoot?>/images/design/logoNoBackTest.png" alt="neoludus logo">
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
        <div id="account-panel" tabindex="3" data-logged-on="<?php echo $user ? 'true' : 'false'?>">
            <?php echo $accountHtml; ?>
        </div>
        <div class="social-menu">
            <ul>
                <li>
                    <a class="fa-icon" href="#">
                        <span class=" faa-parent animated-hover fa-stack ">                           
                            <i class="fa fa-envelope faa-wrench faa-slow" title="Mail us" aria-hidden="true"></i>                            
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="https://www.facebook.com/Neoludus">
                        <span class="faa-parent animated-hover fa-stack fa-stack">                            
                            <i class="fa fa-facebook faa-wrench faa-slow" title="Visit our Facebook page" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack faa-parent animated-hover fa-stack">
                            <i class="fa fa-youtube faa-wrench faa-slow" title="Visit our Youtube channel" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack faa-parent animated-hover fa-stack">
                            <i class="fa fa-twitch faa-wrench faa-slow" title="Visit our Twitch channel" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="https://twitter.com/Neoludus">
                        <span class="fa-stack faa-parent animated-hover fa-stack">
                            <i class="fa fa-twitter faa-wrench faa-slow" title="Visit our Twitter page" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="fa-icon" href="#">
                        <span class="fa-stack faa-parent animated-hover fa-stack">
                            <i class="fa fa-paypal faa-wrench faa-slow" title="Make a donation" aria-hidden="true"></i>
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
            $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
            
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
    $html .= '<a href="index.php/' . $menuItem->getAction() . '">' . $menuItem->getDescription() . '</a>';
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