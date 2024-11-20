<?php
class CommentDB {
    public static function getComment(int $id) {
        $db = Database::getDB();
        $query = '
            SELECT
                Comments.id,
                Comments.content,
                Comments.creationDate,
                Users.id userId,
                Users.name userName,
                Posts.id postId
            FROM Comments
                JOIN Users ON Comments.userId = Users.id
                JOIN Posts ON Comments.postId = Posts.id
            WHERE Comments.id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row === false) return null;

        return new Comment(
            $row['id'],
            $row['content'],
            new DateTime($row['creationDate']),
            $row['postId'],
            $row['userId'],
            new User($row['userId'], $row['userName'], '')
        );
    }

    public static function getPostComments(int $postId) {
        $db = Database::getDB();
        $query = '
            SELECT
                Comments.id,
                Comments.content,
                Comments.creationDate,
                Users.id userId,
                Users.name userName,
                Posts.id postId
            FROM Comments
                JOIN Users ON Comments.userId = Users.id
                JOIN Posts ON Comments.postId = Posts.id
            WHERE Comments.postId = :postId
            ORDER BY Comments.creationDate
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':postId', $postId);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        $comments = array();
        foreach ($rows as $row) {
            $comment = new Comment(
                $row['id'],
                $row['content'],
                new DateTime($row['creationDate']),
                $row['postId'],
                $row['userId'],
                new User($row['userId'], $row['userName'], '')
            );
            $comments[] = $comment;
        }

        return $comments;
    }

    public static function addComment(Comment $comment) {
        $db = Database::getDB();
        $query = '
            INSERT INTO Comments (content, postId, userId)
            VALUES (:content, :postId, :userId)
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':content', $comment->content);
        $statement->bindValue(':postId', $comment->postId);
        $statement->bindValue(':userId', $comment->userId);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function updateComment(Comment $comment) {
        $db = Database::getDB();
        $query = '
            UPDATE Comments
            SET content = :content
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':content', $comment->content);
        $statement->bindValue(':id', $comment->id);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function deleteComment(int $id) {
        $db = Database::getDB();
        $query = '
            DELETE FROM Comments
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
}
?>
