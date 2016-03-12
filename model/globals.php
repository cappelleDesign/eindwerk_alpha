<?php

/**
 * Globals
 * This abstract class keeps all globals used in the domain package
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Globals {

    private $_database = 'souffe_revies';
    private $_achievementsTable = 'achievements';
    private $_userAchievementCombo = 'achievements_users';
    private $_avatarsTable = 'avatars';
    private $_commentsTable = 'comments';
    private $_commentsVotesTable = 'comments_votes';
    private $_gamesTable = 'games';
    private $_gameGenresTable = 'game_genre';
    private $_gamePlatformsTable = 'game_platform';
    private $_genresTable = 'genres';
    private $_goodsBadsTagsTable = 'goods_bads_tags';
    private $_imagesTable = 'images';
    private $_newsfeedsTable = 'newsfeeds';
    private $_notificationsTable = 'notifications';
    private $_platformsTable = 'platforms';
    //poll tables not used yet; would come here
    private $_reviewsTable = 'reviews';
    private $_reviewsImagesComboTable = 'reviews_has_images';
    private $_reviewsUserScoresComboTable = 'review_user_scores';
    private $_reviewVotesCombo = 'review_votes';
    private $_userTable = 'users';
    private $_userRolesTable = 'user_roles';

    //FIXME handle locale ?    
    const BE_DATE_FORMAT = 'd/m/Y';    
    const MYSQL_DATE_FORMAT = 'Y/m/d';    
    const US_DATE_FORMAT ='m/d/Y';    
    const COMMENT_DIAMOND_KARMA = 50;
    const REVIEW_DIAMOND_KARMA = 100;

    static function getDateTimeFormat($type, $withTime) {
        $date = '';
        switch ($type) {
            case 'be' :
                $date = self::BE_DATE_FORMAT;
                break;
            case 'mysql' :
                $date = self::MYSQL_DATE_FORMAT;
                break;
            case 'us' :
                $date = self::US_DATE_FORMAT;
                break;
            default :
                throw new Exception('Date type ' . $type . ' was not found');
        }
        if($withTime) {
            $date += ' H:i:s';
        }        
    }

    static function randomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    static function getTableName($instanceName) {
        $tableName = '';
        switch ($instanceName) {
            case 'achievement':
                $tableName = $this->_achievementsTable;
                break;
            case 'achievement_user':
                $tableName = $this->_userAchievementCombo;
                break;
            case 'avatar':
                $tableName = $this->_avatarsTable;
                break;
            case 'comment':
                $tableName = $this->_commentsTable;
                break;
            case 'comment_vote':
                $tableName = $this->_commentsVotesTable;
                break;
            case 'game':
                $tableName = $this->_gamesTable;
                break;
            case 'game_genre':
                $tableName = $this->_gameGenresTable;
                break;
            case 'game_platform':
                $tableName = $this->_gamePlatformsTable;
                break;
            case 'genre':
                $tableName = $this->_genresTable;
                break;
            case 'tag':
            case 'good':
            case 'bad':
                $tableName = $this->_goodsBadsTagsTable;
                break;
            case 'image':
                $tableName = $this->_imagesTable;
                break;
            case 'newsfeed':
                $tableName = $this->_newsfeedsTable;
                break;
            case 'notification':
                $tableName = $this->_notificationsTable;
                break;
            case 'platform':
                $tableName = $this->_platformsTable;
                break;
            case 'review':
                $tableName = $this->_reviewsTable;
                break;
            case 'review_image':
                $tableName = $this->_reviewsImagesComboTable;
                break;
            case 'review_userScore':
                $tableName = $this->_reviewsUserScoresComboTable;
                break;
            case 'review_vote':
                $tableName = $this->_reviewVotesCombo;
                break;
            case 'user':
                $tableName = $this->_userTable;
                break;
            case 'userRole':
                $tableName = $this->_userRolesTable;
                break;
            default :
                throw new Exception('Could not find table for ' . $instanceName, NULL);
        }
        return $this->_database . '.' . $tableName;
    }

}
