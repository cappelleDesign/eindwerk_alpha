<?php

class NavigationController {

    private $_subFolder;
    
    public function __construct($subFolder) {
        $this->init($subFolder);
    }
    
    private function init($subFolder){
        $this->_subFolder = $subFolder;
    }
    
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
    
    public function includeFileUpload() {
        $this->includeIncluder('file-upload-multi.php');
    }

    public function redirect($action) {
        $base = Globals::getBasePath();
        session_write_close();
        header('Location: ' . $base . 'index.php/' . $action);
        $this->getSessionController()->startSession();
    }

    public function direct($page) {
        require $this->getPagesRoot() . $page;
    }

    protected function internalDirect($page) {
        $this->direct($this->_subFolder . $page);
    }

}
