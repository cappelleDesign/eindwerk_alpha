<?php

/**
 * NewsfeedSqlDB
 * This is a class that handles newsfeed SQL database functions
 * @package dao
 * @subpackage dao.general.newsfeed
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class NewsfeedSqlDB extends SqlSuper implements NewsfeedDao {

    /**
     * The user database
     * @var UserDao
     */
    private $_userDB;

    /**
     * The general dist database
     * @var GeneralDistDao
     */
    private $_genDistDB;
    private $_newsfeedT;

    public function __construct($connection, $userDB, $genDistDB) {
        parent::__construct($connection);
        $this->init($userDB, $genDistDB);
    }

    private function init($userDB, $genDistDB) {
        $this->_userDB = $userDB;
        $this->_genDistDB = $genDistDB;
        $this->_newsfeedT = Globals::getTableName('newsfeed');
    }

    /**
     * add
     * Adds a newsfeed item to the database
     * @param NewsfeedItem $newsfeedItem
     * @return int $id
     * @throws DBException
     */
    public function add(DaoObject $newsfeedItem) {
        if (!($newsfeedItem instanceof NewsfeedItem)) {
            throw new DBException('The item you tried to add was not a newsfeed item');
        }
        if ($this->getByString($newsfeedItem->getSubject())) {
            throw new DBException('It seems like you alreday added a newsfeed item with this subject', NULL);
        }
        $t = $this->_newsfeedT;
        $imgId = $this->_genDistDB->addImage($newsfeedItem->getImage());
        $query = 'INSERT INTO ' . $t;
        $query .= ' (writer_id, image_id, newsfeed_subject, newsfeed_body, newsfeed_created)';
        $query .= ' VALUES (:writer, :img, :subject, :body, :created)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':writer' => $newsfeedItem->getWriterId(),
            ':img' => $imgId,
            ':subject' => $newsfeedItem->getSubject(),
            ':body' => $newsfeedItem->getBody(),
            ':created' => $newsfeedItem->getCreatedStr(Globals::getDateTimeFormat('mysql', TRUE))
        );
        $statement->execute($queryArgs);
        $id = parent::getLastId();
        return $id;
    }

    /**
     * get
     * Returns the newsfeed item with this id
     * @param int $id
     * @return NewsfeedItem
     */
    public function get($id) {
        parent::triggerIdNotFound($id, 'newsfeed');
        return $this->getNewsfeedItem('newsfeed_id', $id);
    }

    /**
     * getByString
     * returns the newsfeed item with this subject if there is one
     * @param string $identifier
     * @return NewsfeedItem
     */
    public function getByString($identifier) {
        return $this->getNewsfeedItem('newsfeed_subject', $identifier);
    }

    /**
     * getNewsfeedItem
     * Helper function to assist the get and getbystring to return a newsfeed item.
     * searcher the id for the given column name
     * @param string $idCol
     * @param int $id
     * @return NewsfeedItem
     */
    private function getNewsfeedItem($idCol, $id) {
        $t = $this->_newsfeedT;
        $query = 'SELECT * FROM ' . $t;
        $query .= ' WHERE ' . $idCol . ' = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        if ($result) {
            $newsfeedItem = $this->createNewsfeedItem($result);
            return $newsfeedItem;
        }
    }

    /**
     * remove
     * Removes the newsfeed item with this id from the database
     * @param int $id
     */
    public function remove($id) {
        parent::triggerIdNotFound($id, 'newsfeed');
        $t = $this->_newsfeedT;
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE newsfeed_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

    /**
     * getNewsfeed
     * Returns all newsfeed items with these options.
     * possible options: string subject, string body, int limit
     * @param array $options      
     * @return NewsfeedItem[]
     */
    public function getNewsfeed($options) {
        $t = $this->_newsfeedT;
        $queryArgs = array();
        $query = 'SELECT * FROM ' . $t;
        $query .= $this->buildWhereQuery($options, $queryArgs);
        $query .= ' GROUP BY newsfeed_id';
        $query .= ' ORDER BY newsfeed_created DESC';
        $query .= $this->buildLimitQuery($options, $queryArgs);
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, TRUE);
        if ($result) {
            $newsfeeds = array();
            foreach ($result as $row) {
                $newsfeedItem = $this->createNewsfeedItem($row);
                array_push($newsfeeds, $newsfeedItem);
            }
            return $newsfeeds;
        }
        return -1;
    }

    /**
     * buildWhere query
     * Helper function to assiste the getNewsfeed function
     * Builds the where part using the options
     * @param array $options
     * @param array $queryArgs
     * @return string
     */
    private function buildWhereQuery($options, &$queryArgs) {
        $where = '';
        if (key_exists('subject', $options)) {
            $where .= empty($where) ? ' WHERE ' : ' OR ';
            $where .= ' newsfeed_subject LIKE :subj ';
            $queryArgs[':subj'] = '%' . $options['subject'] . '%';
        }
        if (key_exists('body', $options)) {
            $where .= empty($where) ? ' WHERE ' : ' OR ';
            $where .= ' newsfeed_body LIKE :body ';
            $queryArgs[':body'] = '%' . $options['body'] . '%';
        }

        return $where;
    }

    /**
     * buildLimitQuery
     * Helper function to assist the getNewsfeed function
     * Builds the limit part using the options
     * @param array $options
     * @param array $queryArgs
     * @return string
     */
    private function buildLimitQuery($options, &$queryArgs) {
        $limit = '';
        if (key_exists('limit', $options)) {
            $limit = ' LIMIT :limit';
            $queryArgs[':limit'] = $options['limit'];
        }
        return $limit;
    }

    /**
     * updateNewsfeedItemSubject
     * Updates the subject of the newsfeed item
     * @param int $newsfeedItemId
     * @param string $subject
     */
    public function updateNewsfeedItemSubject($newsfeedItemId, $subject) {
        parent::triggerIdNotFound($newsfeedItemId, 'newsfeed');
        $this->updateNewsfeed($newsfeedItemId, 'newsfeed_subject', $subject);
    }

    /**
     * updateNewsfeedItemBody
     * Updates the body of the newsfeed item
     * @param int $newsfeedItemId
     * @param string $body
     */
    public function updateNewsfeedItemBody($newsfeedItemId, $body) {
        parent::triggerIdNotFound($newsfeedItemId, 'newsfeed');
        $this->updateNewsfeed($newsfeedItemId, 'newsfeed_body', $body);
    }

    /**
     * updateNewsfeedItemImage
     * Updates the image linked to the newsfeed item
     * @param int $newsfeedItemId
     * @param Image $image
     */
    public function updateNewsfeedItemImage($newsfeedItemId, Image $image) {
        parent::triggerIdNotFound($newsfeedItemId, 'newsfeed');
        $imgId = $this->_genDistDB->addImage($image);
        $this->updateNewsfeed($newsfeedItemId, 'image_id', $imgId);
    }

    /**
     * updateNewsfeed
     * Helper function to assist the updateNewsfeedItemBody, updateNewsfeedItemSubject
     * and updateNewsfeedItemImage. 
     * It uses the column where the name is the same as $updCol
     * @param int $nfiId
     * @param string $updCol
     * @param mixed $val
     */
    private function updateNewsfeed($nfiId, $updCol, $val) {
        $t = $this->_newsfeedT;
        $query = 'UPDATE ' . $t;
        $query .= ' SET ' . $updCol . ' = :upd';
        $query .= ' WHERE newsfeed_id = :id';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':upd' => $val,
            ':id' => $nfiId
        );
        $statement->execute($queryArgs);
    }

    /**
     * createNewsfeedItem
     * Helper function to create and return a newsfeed item object
     * @param array $row
     * @return NewsfeedItem
     * @throws DBException
     */
    private function createNewsfeedItem($row) {
        $format = Globals::getDateTimeFormat('mysql', TRUE);
        try {
            $writer = $this->_userDB->get($row['writer_id']);
            $img = $this->_genDistDB->getImage($row['image_id']);
            $newsfeedItem = new NewsfeedItem($writer->getid(), $writer->getUserName(), $img, $row['newsfeed_subject'], $row['newsfeed_body'], $row['newsfeed_created'], $format);
            $newsfeedItem->setId($row['newsfeed_id']);
            return $newsfeedItem;
        } catch (Exception $ex) {
            throw new DBException('Could not create newsfeed item');
        }
    }

}
