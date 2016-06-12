<?php

/**
 * CommentCreationHelper
 * This is a helper(factory) class to create comment related objects from sql rows
 * @package service
 * @subpackage service.creation
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class CommentCreationHelper {

    /**
     * createComment
     * Creates a comment object from an SQL row, a UserSimple and a voters array
     * @param array $row
     * @param UserSimple $poster
     * @param array $voters
     * @return Comment
     * @throws ServiceException
     */
    public function createComment($row, UserSimple $poster, $voters) {
        if (!$row || !$poster) {
            throw new DBException('could not create last comment', NULL);
        }
        try {
            $comment = new Comment($row['parent_id'], $row['parent_root_id'], $poster, $row['commented_on_notif_id'], $row['comment_txt'], $row['comment_created'], $voters, Globals::getDateTimeFormat('mysql', true));
            $comment->setId($row['comment_id']);
            return $comment;
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * createVote
     * Creates a Vote object from an SQL row
     * @param array $row
     * @return Vote
     * @throws ServiceException
     */
    public function createVote($row, $idCol) {
        try {
            $vote = new Vote($row['user_id'], $row[$idCol], $row['voted_on_notif_id'], $row['user_name'], $row['vote_flag']);
            return $vote;
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
    }

}
