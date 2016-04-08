<?php

class UserService {

    /**
     * The user database.
     * The type of database depends on the config file
     * @var UserDao
     */
    private $_userDB;

    public function __construct($userDB) {
        $this->init($userDB);
    }

    private function init($userDB) {
        if (!($userDB instanceof UserDao)) {
            throw new ServiceException('Could not initialize the user database', NULL);
        }
        $this->_userDB = $userDB;
    }

    public function addUser(UserDetailed $user) {
        try {
            $this->_userDB->add($user);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function removeUser($userId) {
        try {
            $this->_userDB->remove($userId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getUser($userId) {
        try {
            return $this->_userDB->get($userId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getUserByUserName($username) {
        try {
            return $this->_userDB->getByString($username);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getSimpleUser($user_id) {
        try {
            return $this->_userDB->getSimple($user_id);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updatePw(UserDetailed $user, $pwOld, $pwNew) {
        if (password_verify($pwOld, $user->getPwEncrypted())) {
            try {
                $pwEnc = password_hash($pwNew, PASSWORD_BCRYPT);
                $this->_userDB->updatePw($user->getId(), $pwEnc);
                $user->setPwEncrypted($pwEnc);
            } catch (Exception $ex) {
                throw new ServiceException($ex->getMessage(), $ex);
            }
        }
        return null;
    }

    public function updateUserUserRole(UserDetailed $user, UserRole $userRole) {
        try {
            $this->_userDB->updateUserUserRole($user->getId(), $userRole->getId());
            $user->setUserRole($userRole);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserAvatar(UserDetailed $user, Avatar $avatar) {
        try {
            $this->_userDB->updateUserAvatar($user->getId(), $avatar->getId());
            $user->setAvatar($avatar);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserDonated(UserDetailed $user, $donation) {
        try {
            $donated = $user->getDonated() + $donation;
            $this->_userDB->updateUserDonated($user->getId(), $donated);
            $user->setDonated($donated);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserKarma(UserDetailed $user, $karma) {
        try {
            $user->updateKarma($karma);
            $this->_userDB->updateUserKarma($user->getId(), $user->getKarma());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserRegKey(UserDetailed $user, $regKey) {
        try {
            $this->_userDB->updateUserRegKey($user->getId(), $regKey);
            $user->setRegKey($regKey);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserWarnings(UserDetailed $user) {
        try {
            $user->addWarning();
            $this->_userDB->updateUserWarnings($user->getId(), $user->getWarnings());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserDiamonds(UserDetailed $user, $diamonds, $karma) {
        try {
            $user->updateDiamonds($diamonds, $karma);
            $this->_userDB->updateUserKarma($user->getId(), $user->getKarma());
            $this->_userDB->updateUserDiamonds($user->getId(), $user->getDiamonds());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserDateTimePref(UserDetailed $user, $dateTimePref) {
        try {
            $this->_userDB->updateUserDateTimePref($user->getId(), $dateTimePref);
            $user->setDateTimePref($dateTimePref);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserLastLogin(UserDetailed $user, $lastLogin, $format) {
        try {
            $user->setLastLogin($lastLogin, $format);
            $this->_userDB->updateUserLastLogin($user->getId(), $user->getLastLogin());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateUserActiveTime(UserDetailed $user, $activeTime) {
        try {
            $user->updateActiveTime($activeTime);
            $this->_userDB->updateUserActiveTime($user->getId(), $user->getActiveTime());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function addNotification(UserDetailed $user, Notification $notifcation) {
        try {
            $this->_userDB->addNotification($user->getId(), $notifcation);
            $user->addNewRecentNotification($notifcation);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateNotification(UserDetailed $user, $notificationId, $isRead) {
        try {
            $this->_userDB->updateNotification($notificationId, $isRead);
            $user->updateNotification($notificationId, $isRead);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }
    
    public function removeNotification(UserDetailed $user, $notificationId) {
        try {
            $this->_userDB->removeNotification($notificationId);
            $user->removeRecentNotification($notificationId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function addAchievement(UserDetailed $user, Achievement $achievement) {
        try {
            $this->_userDB->addAchievement($user->getId(), $achievement->getId());
            $user->addAchievement($achievement);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

}
