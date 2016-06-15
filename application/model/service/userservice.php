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

    /**
     * addUser
     * Adds a user to the database
     * @param UserDetailed $user
     * @throws ServiceException
     */
    public function addUser(UserDetailed $user) {
        try {
            $this->_userDB->add($user);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeUser
     * Removes a user from the database
     * @param int $userId
     * @throws ServiceException
     */
    public function removeUser($userId) {
        try {
            $this->_userDB->remove($userId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUser
     * Returns the user with this id from the database as a user object
     * @param int $userId
     * @return UserDetailed $user
     * @throws DBException if the no user with this id was found
     */
    public function getUser($userId) {
        try {
            return $this->_userDB->get($userId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getByStringId
     * Returns a user by searching for it's username or email
     * @param string $identifier being the username or the email of a user
     * @return UserDetailed
     * @throws DBException if no users with this username or email exists
     */
    public function getUserByStringId($identifier) {
        try {
            return $this->_userDB->getByString($identifier);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * checkEmailAvailable
     * Checks if an email is already in use on the site
     * @param string $mail
     * @return bool
     */
    public function checkEmailAvailable($mail) {
        try {
            return $this->_userDB->emailAvailable($mail);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * checkUsernameAvailable
     * Checks if a username is already in use on the site
     * @param string $username
     * @return bool
     */
    public function checkUsernameAvailable($username) {
        try {
            return $this->_userDB->usernameAvailable($username);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getSimpleUser
     * returns a UserSimple object with id when no detailed information is needed
     * @param int $userId
     * @return UserSimple 
     * @throws DBException if no user with this id was found
     */
    public function getSimpleUser($userId) {
        try {
            return $this->_userDB->getSimple($userId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUserRole
     * Returns the user role with this id 
     * @param int $accessFlag
     * @return UserRole
     */
    public function getUserRole($accessFlag) {
        try {
            return $this->_userDB->getUserRole($accessFlag);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getAvatar
     * Returns the avatar with this id
     * @param int $avatarId
     * @return Avatar
     */
    public function getAvatar($avatarId) {
        try {
            return $this->_userDB->getAvatar($avatarId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUsers
     * Returns all users in the database
     * @return array of UserSimple objects
     */
    public function getUsers() {
        try {
            return $this->_userDB->getUsers();
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getAvatars
     * Returns all the avatars
     * @return array
     */
    public function getAvatars() {
        try {
            return $this->_userDB->getAvatars();
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUserRoles
     * Returns all the user roles
     * @return array
     */
    public function getUserRoles() {
        try {
            return $this->_userDB->getUserRoles();
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getAllAchievements
     * Returns all the achievements
     * @return array
     */
    public function getAllAchievements() {
        try {
            return $this->_userDB->getAllAchievements();
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updatePw
     * updates the password for a user with this id
     * @param UserDetailed $user
     * @param string $pwOld
     * @param string $pwNew as new encrypted password
     */
    public function updatePw(UserDetailed $user, $pwOld, $pwNew) {
        if (password_verify($pwOld, $user->getPwEncrypted())) {
            try {
                $pwEnc = password_hash($pwNew, PASSWORD_BCRYPT);
                $this->_userDB->updatePw($user->getId(), $pwEnc);
                $user->setPwEncrypted($pwEnc);
            } catch (Exception $ex) {
                throw new ServiceException($ex->getMessage(), $ex);
            }
        } else {
            throw new ServiceException('No match for this username and password', NULL);
        }
        return null;
    }

    /**
     * updateUserUserRole
     * Updates the user role in the users table if the user id matches
     * @param UserDetailed $user
     * @param UserRole $userRole
     */
    public function updateUserUserRole(UserDetailed $user, UserRole $userRole) {
        try {
            $this->_userDB->updateUserUserRole($user->getId(), $userRole->getId());
            $user->setUserRole($userRole);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserAvatar
     * Updates the avatar in the users table if the user id matches
     * @param UserDetailed $user
     * @param Avatar $avatar
     */
    public function updateUserAvatar(UserDetailed $user, Avatar $avatar) {
        try {
            $this->_userDB->updateUserAvatar($user->getId(), $avatar->getId());
            $user->setAvatar($avatar);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserDonated
     * updates the amount donated for the user with this id
     * @param UserDetailed $user
     * @param int $donation to be added
     */
    public function updateUserDonated(UserDetailed $user, $donation) {
        try {
            $donated = $user->getDonated() + $donation;
            $this->_userDB->updateUserDonated($user->getId(), $donated);
            $user->setDonated($donated);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserKarma
     * Updates the karma of the user to a new amount
     * @param UserDetailed $user
     * @param int $karma to be added
     */
    public function updateUserKarma(UserDetailed $user, $karma) {
        try {
            $user->updateKarma($karma);
            $this->_userDB->updateUserKarma($user->getId(), $user->getKarma());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserRegKey
     * Updates the reg key for user with this id
     * @param UserDetailed $user
     * @param string $regKey
     */
    public function updateUserRegKey(UserDetailed $user, $regKey) {
        try {
            $this->_userDB->updateUserRegKey($user->getId(), $regKey);
            $user->setRegKey($regKey);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserWarnings
     * Updates the amount of warnings for user with this id
     * @param UserDetailed $user     
     */
    public function updateUserWarnings(UserDetailed $user) {
        try {
            $user->addWarning();
            $this->_userDB->updateUserWarnings($user->getId(), $user->getWarnings());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserDiamonds
     * updates the amount of diamonds for user with this id
     * @param UserDetailed $user
     * @param int $diamonds total amount
     * @param int $karma
     */
    public function updateUserDiamonds(UserDetailed $user, $diamonds, $karma) {
        try {
            $user->updateDiamonds($diamonds, $karma);
            $this->_userDB->updateUserKarma($user->getId(), $user->getKarma());
            $this->_userDB->updateUserDiamonds($user->getId(), $user->getDiamonds());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserDateTimePref
     * Updates the time preference setting for the user with this id
     * @param UserDetailed $user
     * @param string $dateTimePref
     * @throws ServiceException
     */
    public function updateUserDateTimePref(UserDetailed $user, $dateTimePref) {
        try {
            $this->_userDB->updateUserDateTimePref($user->getId(), $dateTimePref);
            $user->setDateTimePref($dateTimePref);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserLastLogin
     * Updates the last login time of the user with this id
     * @param UserDetailed $user
     * @param DateTime $lastLogin
     * @param string $format
     * @throws ServiceException
     */
    public function updateUserLastLogin(UserDetailed $user, $lastLogin, $format) {
        try {
            $user->setLastLogin($lastLogin, $format);
            $this->_userDB->updateUserLastLogin($user->getId(), $user->getLastLogin());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateUserActiveTime
     * Updates the total seconds of active time of user with this id
     * @param UserDetailed $user
     * @param int $activeTime
     * @throws ServiceException
     */
    public function updateUserActiveTime(UserDetailed $user, $activeTime) {
        try {
            $user->updateActiveTime($activeTime);
            $this->_userDB->updateUserActiveTime($user->getId(), $user->getActiveTime());
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addNotification
     * Adds a notification for a user to the Notifications table
     * @param UserDetailed $user
     * @param Notification $notifcation
     * @throws ServiceException
     */
    public function addNotification(UserDetailed $user, Notification $notifcation) {
        try {
            $this->_userDB->addNotification($user->getId(), $notifcation);
            $user->addNewRecentNotification($notifcation);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateNotification
     * Updates a notification in the Notifications table if id matches 
     * @param UserDetailed $user
     * @param int $notificationId
     * @param bool $isRead
     * @throws ServiceException
     */
    public function updateNotification(UserDetailed $user, $notificationId, $isRead) {
        try {
            $this->_userDB->updateNotification($notificationId, $isRead);
            $user->updateNotification($notificationId, $isRead);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeNotification
     * Removes a notification from the Notifications table if the user id matches
     * @param UserDetailed $user
     * @param int $notificationId
     * @throws ServiceException
     */
    public function removeNotification(UserDetailed $user, $notificationId) {
        try {
            $this->_userDB->removeNotification($notificationId);
            $user->removeRecentNotification($notificationId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addAchievement
     * Adds a record to the achievements_users table.
     * This means that a user now has this achievement
     * @param UserDetailed $user
     * @param Achievement $achievement
     * @throws ServiceException
     */
    public function addAchievement(UserDetailed $user, Achievement $achievement) {
        try {
            $this->_userDB->addAchievement($user->getId(), $achievement->getId());
            $user->addAchievement($achievement);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getAchievement
     * Returns the achievement if the name matches
     * @param string $name
     * @return Achievement
     * @throws ServiceException
     */
    public function getAchievement($name) {
        try {
            return $this->_userDB->getAchievement($name);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

}
