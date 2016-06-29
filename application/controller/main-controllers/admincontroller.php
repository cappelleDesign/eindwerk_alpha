<?php

class AdminController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('admin/');
        if (!$this->getCurrentUser() || !$this->getCurrentUser()->getUserRole()->getAccessFlag() >= 100) {
            $this->getErrorController()->restricted();
            die();
        }
    }

    public function index() {
        $this->internalDirect('dashboard.php');
    }

    public function userMgr() {
        $_POST['users'] = file_get_contents($this->getBase() . 'user/get/all');
        $this->internalDirect('user-mgr.php');
    }

    public function addUserPage($id = NULL) {
        if ($id !== NULL && is_numeric($id)) {
            $_POST['user'] = file_get_contents($this->getBase() . 'user/get/' . $id);
        }
        $_POST['userRoles'] = file_get_contents($this->getBase() . 'user/userrole/all');
        $_POST['avatars'] = file_get_contents($this->getBase() . 'user/avatar/all');
        $this->internalDirect('user-add-page.php');
    }

    public function addUser() {
        $rollFlag = $_POST['user-role'];
        $mail = $_POST['user-mail'];
        $username = $_POST['user-name'];
        $pwd = $_POST['user-pwd'];
        $avatar = $_POST['avatar'];
        ErrorLogger::logError($avatar);       
        //FIXME ADD SERVER VALIDATION!!!!!!!!!!!!!
        $url = $this->getBase() . 'user/add/' . $username . '/' . $mail . '/' . $pwd . '/' . $avatar . '/' . $rollFlag;
        $add = file_get_contents($url);
        if ($add === 'success') {
            setcookie('notifSucc', 'User successfully added!', 0, '/');
            $this->redirect('admin/usermgr');           
        } else {
            setcookie('notifErr', 'Something went wrong while adding the user :(', 0, '/');
            $this->addUserPage();
        }
    }

    public function reviewMgr() {
        $this->internalDirect('review-mgr.php');
    }

    public function avatarMgr() {
        $this->internalDirect('avatar-mgr.php');
    }

    public function addAvatar() {
        $avatarArr = $this->getAvatarArr();
        if (!is_array($avatarArr)) {
            ErrorLogger::logError('add avatar post values not set');
//            FIXME show error page
            return;
        }
        $validation = $this->getValidator()->validateAddAvatarForm($avatarArr);
        $feedback = false;
        if (array_search('has-error', array_column($validation, 'errorClass')) !== FALSE || array_key_exists('extraMessage', $validation)) {
            $feedback = $validation;
        }
        if (!isset($_FILES['avatar-img'])) {
            $validation['extraMessage'] = 'You did not choose a file!';
            $feedback = $validation;
        }
        if (!$feedback) {
            $files = $_FILES['avatar-img'];
            $img = new Image('', $avatarArr['alt']);
            $avatar = new Avatar($img, $avatarArr['tier']);
            $extra = array(
                0 => $files,
                1 => $avatarArr['tier']
            );
            try {
                $this->getService()->add($avatar, 'avatar', $extra);
                $this->redirect('admin/avatar-mgr');
                return;
            } catch (Exception $ex) {
                ErrorLogger::logError($ex);
                //FIXME to error page
                $validation['extraMessage'] = 'Something went wrong adding the avatar, try again or notify the technical chief';
                $feedback = $validation;
                return;
            }
        }
        $_POST['avatar-feedback'] = $feedback;
        $this->internalDirect('avatar-mgr.php');
    }

    private function getAvatarArr() {
        $tier = '';
        $alt = '';
        $isHuman = '';
        if (isset($_POST['avatar-tier']) && isset($_POST['avatar-alt'])) {
            $tier = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'avatar-tier'));
            $alt = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'avatar-alt'));
            $isHuman = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'input-filter'));
        }
        $avatarArr = array(
            'tier' => $tier,
            'alt' => $alt,
            'isHuman' => $isHuman
        );
        return $avatarArr;
    }
}
