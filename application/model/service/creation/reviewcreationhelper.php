<?php

/**
 * ReviewCreationHelper
 * This is a helper(factory) class to create review related objects from sql rows
 * @package service
 * @subpackage service.creation
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewCreationHelper {

    /**
     * createGame
     * Create a Game object from an SQL row, a platforms array and a genres array
     * @param array $row
     * @param array $platforms
     * @param arrya $genres
     * @return Game
     * @throws ServiceException
     */
    public function createGame($row, $platforms, $genres) {
        if (!$row || !$platforms || !$genres) {
            throw new ServiceException('Could not create game', NULL);
        }
        try {            
            $game = new Game($row['game_name'], $row['game_release'], 
                    $row['game_website'], $row['game_publisher'], 
                    $row['game_developer'], $row['min_online_players'], 
                    $row['max_online_players'], $row['max_offline_players'], 
                    $row['story_max_players'], $row['has_storymode'],
                    $genres, $platforms, Globals::getDateTimeFormat('mysql', false));
            $game->setId($row['game_id']);
            return $game;
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

}
