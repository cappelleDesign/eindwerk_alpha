<?php

class NavigationController {

    public function getPagesRoot() {
        return Globals::getRoot('view', 'app') . '/pages/';
    }

    public function getJsonRoot() {
        return Globals::getRoot('view', 'app') . '/data/';
    }

    public function includeIncluder($fileName) {
        $root = Globals::getRoot('view', 'sys') . '/includes/';
        include $root . $fileName;
    }

    public function includeHeader() {
        $this->includeIncluder('header.php');
    }

    public function includeMenu($page) {
        $_GET['page'] = $page;
        $this->includeIncluder('menu.php');
    }

    public function includeFooter() {
        $this->includeIncluder('footer.php');
    }

    public function includeScripts() {
        $this->includeIncluder('scripts.php');
    }

    public function includeLoginForm() {
        $this->includeIncluder('login-form.php');
    }

    public function redirect($action) {
        //fixme depends on server
        $_SESSION['forward'] = 'not lost';
        session_write_close();
        header('Location: http://localhost/neoludus_alpha/' . 'index.php/' . $action);
        $this->getSessionController()->startSession();
    }

    public function direct($page) {
        require $this->getPagesRoot() . $page;
    }

}
