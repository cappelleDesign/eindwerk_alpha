<?php

/**
 * Globals
 * This abstract class keeps all globals used in the domain package
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Globals {

    const APP_PATH = 'application/';
    const SYS_PATH = 'system/';
    const COMMENT_DIAMOND_KARMA = 50;
    const REVIEW_DIAMOND_KARMA = 100;

    static function getDateTimeFormat($type, $withTime) {
        $date = '';
        switch ($type) {
            case 'be' :
                $date = 'd/m/Y';
                break;
            case 'mysql' :
                $date = 'Y-m-d';
                break;
            case 'us' :
                $date = 'm/d/Y';
                break;
            default :
                throw new Exception('Date type ' . $type . ' was not found');
        }
        if ($withTime) {
            $date .= ' H:i:s';
        }
        return $date;
    }
//27 25
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
                $tableName = 'achievements';
                break;
            case 'achievement_user':
                $tableName = 'achievements_users';
                break;
            case 'avatar':
                $tableName = 'avatars';
                break;
            case 'comment':
                $tableName = 'comments';
                break;
            case 'comment_vote':
                $tableName = 'comment_votes';
                break;
            case 'game':
                $tableName = 'games';
                break;
            case 'game_genre':
                $tableName = 'game_genre';
                break;
            case 'game_platform':
                $tableName = 'game_platform';
                break;
            case 'genre':
                $tableName = 'genres';
                break;
            case 'tag':
            case 'good':
            case 'bad':
                $tableName = 'goods_bads_tags';
                break;
            case 'image':
                $tableName = 'images';
                break;
            case 'newsfeed':
                $tableName = 'newsfeeds';
                break;
            case 'notification':
                $tableName = 'notifications';
                break;
            case 'platform':
                $tableName = 'platforms';
                break;
            case 'review':
                $tableName = 'reviews';
                break;
            case 'review_image':
                $tableName = 'reviews_has_images';
                break;
            case 'review_userScore':
                $tableName = 'review_user_scores';
                break;
            case 'review_vote':
                $tableName = 'review_votes';
                break;
            case 'review_comment' :
                $tableName = 'reviews_has_comments';
                break;
            case 'user':
                $tableName = 'users';
                break;
            case 'userRole':
                $tableName = 'user_roles';
                break;
            case 'video' :
                $tableName = 'video';
                break;
            case 'video_comment' :
                $tableName = 'video_has_comments';
                break;
                
            default :
                throw new Exception('Could not find table for ' . $instanceName, NULL);
        }
        return 'soufitq169_neoludus.' . $tableName;
    }

    static function getIdColumnName($instance) {
        switch ($instance) {
            case 'achievement' :
                return 'achievement_id';
            case 'avatar':
                return 'avatar_id';
            case 'comment':
                return 'comment_id';
            case 'game' :
                return 'game_id';
            case 'genre' :
                return 'genre_id';
            case 'good':
            case 'bad':
            case 'tags':
                return 'good_bad_tag_id';
            case 'image' :
                return 'image_id';
            case 'newsfeed' :
                return 'newsfeed_id';
            case 'notification' :
                return 'notification_id';
            case 'platform' :
                return 'platform_id';
            case 'review':
                return 'review_id';
            case 'user':
                return 'user_id';
            case 'user_role' :
                return 'user_role_id';
            case 'achievement_user':
                return 'user_id';
            case 'comment_vote':
                return 'users_upvoter_id';
            case 'game_genre':
                return 'game_id';
            case 'game_platform':
                return 'game_id';
            case 'review_image' :
                return 'reviews_review_id';
            case 'review_userScore' :
                return 'review_id';
            case 'review_vote' :
                return 'review_id';
            default : throw new DBException('id column not found!');
        }
    }

    static function cleanDump($obj) {
        echo '<pre>';
        var_dump($obj);
        echo '</pre>';
    }

    static function getRoot($type, $superType = '', $server = false) {
        $root = '';
        $superRoot = '';
        if (!empty($superType)) {
            $superRoot = Globals::getRoot($superType);
        }
        switch ($type) {
            case 'sys' :
                return Globals::SYS_PATH;
            case 'app' :
                return Globals::APP_PATH;
            case 'view' :
                if ($server && strpos(dirname(__FILE__), 'xampp')) {
                    $root .= 'neoludus_alpha/';
                }
                return $root . $superRoot . 'view';
            case 'sysView' :

            default : throw new ServiceException($type . ' root not found');
        }
    }

    static function getUserActions() {
        $userActions = [
            'loginPage',
            'login',
            'logout',
            'register',
            'registerPage',
            'accountPage',
            'addUser',
            'rmUser',
            'getUser', //by id detailed, by id simple, by name/mail
            'checkAvailable',
            'getUserDist', //user role, avatar, achievements,..
            'getUsers',
            'updateUser', //update methods,
            'addToUser',
            'removeFromUser'
        ];
        return $userActions;
    }

    static function getHelperActions() {
        $helperActions = [
            'getCarouselSrcs',
            'getNewsfeedSrcs'
        ];
        return $helperActions;
    }

}
