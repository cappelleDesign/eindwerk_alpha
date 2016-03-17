<?php

interface UserRoleDao extends Dao{

    public function updateUserUserRole($userId, $userRoleId);

    public function getUserRole($userRoleId);
}
