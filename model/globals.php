<?php

/**
 * Globals
 * This abstract class keeps all globals used in the domain package
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Globals {

    const DATABASE = 'souffe_reviews';
    const ACHIEVEMENTS_TABLE = 'achievements';
    const USER_ACHIEVEMENT_COMBO_TABLE = 'achievements_users';
    const AVATARS_TABLE = 'avatars';
    const COMMENTS_TABLE = 'comments';
    const COMMENTS_VOTES_TABLE = 'comment_votes';
    const GAMES_TABLE = 'games';
    const GAMES_GENRES_TABLE = 'game_genre';
    const GAMES_PLATFORMS_TABLE = 'game_platform';
    const GENRES_TABLE = 'genres';
    const GOOD_BADS_TAGS_TABLE = 'goods_bads_tags';
    const IMG_TABLE = 'images';
    const NEWSFEED_TABLE = 'newsfeeds';
    const NOTIFICATIONS_TABLE = 'notifications';
    const PLATFORMS_TABLE = 'platforms';
    //poll tables not used yet; would come here
    const REVIEWS_TABLE = 'reviews';
    const REVIEWS_IMG_COMBO_TABLE = 'reviews_has_images';
    const REVIEWS_USER_SCORES_COMBO_TABLE = 'review_user_scores';
    const REVIEW_VOTES_COMBO = 'review_votes';
    const USERS_TABLE = 'users';
    const USER_ROLES_TABLE = 'user_roles';

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
                $tableName = self::ACHIEVEMENTS_TABLE;
                break;
            case 'achievement_user':
                $tableName = self::USER_ACHIEVEMENT_COMBO_TABLE;
                break;
            case 'avatar':
                $tableName = self::AVATARS_TABLE;
                break;
            case 'comment':
                $tableName = self::COMMENTS_TABLE;
                break;
            case 'comment_vote':
                $tableName = self::COMMENTS_VOTES_TABLE;
                break;
            case 'game':
                $tableName = self::GAMES_TABLE;
                break;
            case 'game_genre':
                $tableName = self::GAMES_GENRES_TABLE;
                break;
            case 'game_platform':
                $tableName = self::GAMES_PLATFORMS_TABLE;
                break;
            case 'genre':
                $tableName = self::GENRES_TABLE;
                break;
            case 'tag':
            case 'good':
            case 'bad':
                $tableName = self::GOOD_BADS_TAGS_TABLE;
                break;
            case 'image':
                $tableName = self::IMG_TABLE;
                break;
            case 'newsfeed':
                $tableName = self::NEWSFEED_TABLE;
                break;
            case 'notification':
                $tableName =self::NOTIFICATIONS_TABLE;
                break;
            case 'platform':
                $tableName = self::PLATFORMS_TABLE;
                break;
            case 'review':
                $tableName = self::REVIEWS_TABLE;
                break;
            case 'review_image':
                $tableName = self::REVIEWS_IMG_COMBO_TABLE;
                break;
            case 'review_userScore':
                $tableName = self::REVIEWS_USER_SCORES_COMBO_TABLE;
                break;
            case 'review_vote':
                $tableName = self::REVIEW_VOTES_COMBO;
                break;
            case 'user':
                $tableName = self::USERS_TABLE;
                break;
            case 'userRole':
                $tableName = self::USER_ROLES_TABLE;
                break;
            default :
                throw new Exception('Could not find table for ' . $instanceName, NULL);
        }
        return self::DATABASE . '.' . $tableName;
    }

}
