<?php

abstract class userrolesqldb extends SqlSuper implements UserRoleDao{
    
    public function __construct($host, $username, $passwd, $database) {
        parent::__construct($host, $username, $passwd, $database);
    }
    
    public function add(DaoObject $daoObject) {
        
    }

    public function containsId($id) {
        
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

    
       /**
     * updateUserUserRole
     * Updates the user role of a user
     * @param type $userId
     * @param type $userRoleId
     * @return UserRole the new user role
     */
    public function updateUserUserRole($userId, $userRoleId) {
        $this->triggerIdNotFound($userId);
        $userT = Globals::getTableName('user');
        //FIXME should userRoleId existence be checked?
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.user_roles_user_role_id = :userRoleId WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':userRoleId' => $userRoleId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
        return $this->getUserRole($userRoleId);
    }
    public function getUserRole($userRoleId) {
        $query = 'SELECT * FROM ' . Globals::getTableName('userRole') . ' WHERE user_role_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $userRoleId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $row = $result[0];
        $userRole = $this->createUserRole($row);
        return $userRole;
    }
    protected function createUserRole($row) {
        $userRole = new UserRole($row['user_role_name'], $row['user_role_access_flag'], $row['user_role_karma_min'], $row['user_role_diamond_min']);
        $userRole->setId($row['user_role_id']);
        return $userRole;
    }
}
