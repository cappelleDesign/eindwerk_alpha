<?php

class ErrorController extends NavigationController{
    private $_subFolder;
    public function __construct() {
        parent::__construct('error/');
    }

    public function handleError($ex) {
        $nextPage = $this->getErrorPage($ex);
        $this->internalDirect($nextPage);
    }

    public function getErrorPage($ex) {
        $type = $this->getErrorType($ex);
        if ($type === 'server') {
            $this->errLog($ex);
            Global $errorMessage;
            $errorMessage = $ex->getMessage();
            return 'server-error.php';
        } else {
            return 'page-not-found.php';
        }
    }

    public function getErrorType($ex) {
        if ($ex instanceof Exception) {
            return 'server';
        } else {
            return 'not-found';
        }
    }

    public function errLog($error) {
        ErrorLogger::logError($error);
        //FIXME ADD MAIL TO ADMIN
    }

    public function restricted() {
        $this->internalDirect('restricted.php');
    }

}
