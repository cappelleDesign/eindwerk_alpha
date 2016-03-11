<?php
/**
 * DaoObject
 * This is an abstract class for all classes that handle user SQL databases
 * @package dao
 * @subpackage dao.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
abstract class UserSqlDB extends SqlSuper implements UserDao {

    const USERTABLE = 'souffe_reviews.users';
    public function __construct($host, $username, $passwd, $database) {
        parent::__construct($host, $username, $passwd, $database);
    }
   
    public function add(UserDetailed $user) {
        if (!$user instanceof UserDetailed) {
            throw new DBException('The object you tried to add was not a user object', NULL);
        }
        if ($this->containsId($user->getId())) {
            throw new DBException('The database already contains a user with this id', NULL);
        }
        $query = 'INSERT INTO `'.self::USERTABLE.'` (`user_roles_user_role_id`, `images_image_id`, `user_name`, `user_hash_salt`, `user_email`, `user_karma`, `user_reg_key`, `user_warnings`, `user_diamonds`, `preference_datetime_format`, `user_created`, `last_login`, `dontated_amomunt`, `active_seconds`)';
        $query .= 'VALUES(:user_role_id, :image_id, :username, :pw, :email, :karma, :reg_key, :warnings, :diamonds, :date_pref, :created, :last_login, :donated, :active);';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':user_role_id' => $user->getUserRole()->getId(),
            ':image_id' => $user->getAvatar()->getId(),
            ':username' => $user->getUsername(),
            ':pw' => $user->getPwEncrypted(),
            ':email' => $user->getEmail(),
            ':karma' => $user->getKarma(),
            ':reg_key' => $user->getRegKey(),
            ':warnings' => $user->getWarnings(),
            ':diamonds' => $user->getDiamonds(),
            ':date_pref' => $user->getDateTimePref(),
            ':created' => $user->getCreated(),
            ':last_login' => $user->getLastLogin(),
            ':donated' => $user->getDonated(),
            ':active' => $user->getActiveTime()
        );
        $statement->execute($queryArgs);
    }

    public function containsId($id) {
        $query = 'SELECT * FROM `'.self::USERTABLE.'` WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result;
    }
    
    public function getNotifications($id, $limit) {
        
    }   
    
    public function getAchievements($id) {
        
    }
    
    public function getAvatar($id) {
        
    }

    public function get($id) {
        $result = $this->containsId($id)['0'];
        if (!$result || empty($result)) {
            throw new DBException('could not find a user with this id. id was: ' . $id, NULL);
        }
        $user = $this->createUser($result, $true);
        return $user;
    }
    
    public function getSimple($id) {
         $result = $this->containsId($id)['0'];
        if (!$result || empty($result)) {
            throw new DBException('could not find a user with this id. id was: ' . $id, NULL);
        }
        $user = $this->createUser($result, false);
        return $user;
    }

    protected function createUser($row, $detailed) {
        if (!$row) {
            throw new DBException('could not create user', NULL);
        }
        try {
            $user = new User($row['user_name'], 'use_hash', $row['user_email'], $row['hash_salt']);
            $user->setId($row['user_id']);
            return $user;
        } catch (DomainModelException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    public function getUsers() {
        $query = "SELECT * FROM farao.users";
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $users = array();
        foreach ($result as $row) {
            try {
                $user = $this->createUser($row);
                $users[$user->getId()] = $user;
            } catch (DomainModelException $ex) {
                throw new DBException($ex->getMessage(), $ex);
            }
        }
        return $users;
    }

    public function getByString($identifier) {
        $userWithName = '';
        try {
            $query = 'SELECT * FROM farao.users WHERE user_name = ?';
            $statement = parent::prepareStatement($query);
            $statement->bindParam(1, $identifier);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $user = $this->createUser($row);
                $userWithName = $user;
            }
        } catch (PDOException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        } catch (DomainModelException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
        return $userWithName;
    }

    public function remove($id) {
        if (!$this->containsId($id)) {
            throw new DBException('No user with this id was found', NULL);
        }
        $query = 'DELETE FROM farao.users WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

    public function updatePw($user_id, $pw_old, $pw_new) {
        try {
            $user = $this->get($user_id);
            $user->update($pw_old, $pw_new);
            $query = 'UPDATE farao.users SET hash_salt= :hash_salt WHERE users.user_id= :id;';
            $statement = parent::prepareStatement($query);
            $gueryArgs = array(
                ':hash_salt' => $user->getHash_salt(),
                ':id' => $user_id
            );
            $statement->execute($gueryArgs);
        } catch (DomainModelException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

}
