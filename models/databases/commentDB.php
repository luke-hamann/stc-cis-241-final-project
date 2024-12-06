<?php
/**
 * Title: Comment Database
 * Purpose: To view, add, update, and delete comments
 */
class CommentDB {
    private const BASE_QUERY = '
        SELECT
            Comments.id,
            Comments.content,
            Comments.creationDate,
            Comments.postId,
            Users.id userId,
            Users.name userName,
            Users.isAdmin userIsAdmin,
            Users.isGhost userIsGhost
        FROM Comments
            JOIN Users ON Comments.userId = Users.id
    ';

    // Convert SQL result row to comment object
    public static function convertRowToComment($row) {
        return new Comment(
            $row['id'],
            $row['content'],
            new DateTime($row['creationDate']),
            $row['postId'],
            null,
            $row['userId'],
            new User(
                $row['userId'],
                $row['userName'],
                '',
                $row['userIsAdmin'],
                $row['userIsGhost']
            )
        );
    }

    // Convert SQL result rows to a list of comment objects
    public static function convertRowsToComments($rows) {
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = self::convertRowToComment($row);
        }
        return $comments;
    }

    // Get a comment by its id
    public static function getComment(int $id) {
        $query = self::BASE_QUERY . 'WHERE Comments.id = :id';
        $rows = Database::execute($query, [':id' => $id]);
        if (count($rows) == 0) return null;
        return self::convertRowToComment($rows[0]);
    }

    // Get all comments associated with a given post
    public static function getPostComments(int $postId) {
        $query = self::BASE_QUERY . '
            WHERE Comments.postId = :postId
            ORDER BY Comments.creationDate
        ';
        $rows = Database::execute($query, [':postId' => $postId]);
        return self::convertRowsToComments($rows);
    }

    // Get all comments by a given user
    public static function getUserComments(int $userId) {
        $query = self::BASE_QUERY . '
            WHERE Comments.userId = :userId
            ORDER BY Comments.creationDate
        ';
        $rows = Database::execute($query, [':userId' => $userId]);
        return self::convertRowsToComments($rows);
    }

    // Add a comment
    public static function addComment(Comment $comment) {
        $query = '
            INSERT INTO Comments (content, postId, userId)
            VALUES (:content, :postId, :userId)
        ';
        Database::execute($query, [
            ':content' => $comment->content,
            ':postId' => $comment->postId,
            ':userId' => $comment->userId
        ]);
    }

    // Update a comment
    public static function updateComment(Comment $comment) {
        $query = '
            UPDATE Comments
            SET content = :content
            WHERE id = :id
        ';
        Database::execute($query, [
            ':content' => $comment->content,
            ':id' => $comment->id
        ]);
    }

    // Delete a comment
    public static function deleteComment(int $id) {
        $query = '
            DELETE FROM Comments
            WHERE id = :id
        ';
        Database::execute($query, [':id' => $id]);
    }
}
?>
