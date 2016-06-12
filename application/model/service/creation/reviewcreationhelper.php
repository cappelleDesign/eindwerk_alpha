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
            $game = new Game($row['game_name'], $row['game_release'], $row['game_website'], $row['game_publisher'], $row['game_developer'], $row['min_online_players'], $row['max_online_players'], $row['max_offline_players'], $row['story_max_players'], $row['has_storymode'], $genres, $platforms, Globals::getDateTimeFormat('mysql', false));
            $game->setId($row['game_id']);
            return $game;
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * createReview
     * Creates a Review object from an SQL row, a UserSimple Object, a Game object,
     * an Image object, an Image array, an array for userScores, a Comments array
     * and 3 string arrays for goods, bads and tags
     * @param string[] $row
     * @param UserSimple $writer
     * @param Game $game
     * @param string $reviewedOn
     * @param Image $headerPic
     * @param Image[] $gallery
     * @param array $userScores (int userId, int score)
     * @param Comment[] $rootComments
     * @param array $voters
     * @param string[] $goods
     * @param string[] $bads
     * @param string[] $tags
     */
    public function createReview($row, UserSimple $writer, Game $game, $reviewedOn, $headerPic, $gallery, $userScores, $rootComments, $voters, $goods, $bads, $tags) {
        try {
            $format = Globals::getDateTimeFormat('mysql', TRUE);
            $review = new Review($writer, $game, $reviewedOn, $row['review_title'], $row['review_score'], $row['review_txt'], $row['review_video_url'], $row['review_created'], $headerPic, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format, $row['is_user_review']);
            $review->setId($row['review_id']);
            return $review;
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }
}
