<?php

/**
 * Globals
 * This abstract class keeps all globals used in the domain package
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Globals {
                                        
    const COMMENT_DIAMOND_KARMA = 50;
    const REVIEW_DIAMOND_KARMA = 100;

    static function getDateTimeFormat($type, $withTime) {
        $date = '';
        switch ($type) {
            case 'be' :
                $date = 'd/m/Y';
                break;
            case 'mysql' :
                $date = 'Y/m/d';
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
            case 'user':
                $tableName = 'users';
                break;
            case 'userRole':
                $tableName = 'user_roles';
                break;
            default :
                throw new Exception('Could not find table for ' . $instanceName, NULL);
        }
        return 'neoludus.' . $tableName;
    }

}
