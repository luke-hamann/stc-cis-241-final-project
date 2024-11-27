<?php
/**
 * Title: Post Database
 * Purpose: To view, add, update, and delete posts
 */
class PostDB {

    private static function convertRowsToPosts($rows) {
        $posts = array();
        foreach ($rows as $row) {
            $user = new User(
                $row['userId'],
                $row['userName'],
                '',
                $row['userIsAdmin'],
                $row['userIsGhost']
            );
            $forum = new Forum($row['forumId'], $row['forumName'], []);
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['content'],
                new DateTime($row['creationDate']),
                $row['userId'],
                $user,
                $row['forumId'],
                $forum,
                [],
                $row['isDeleted']
            );
            $posts[] = $post;
        }

        return $posts;
    }

    /**
     * Get recent posts across all forums
     */
    public static function getRecentPosts(int $maxCount = 20) {
        $db = Database::getDB();
        $query = '
            SELECT
                Posts.id,
                Posts.title,
                Posts.content,
                Posts.creationDate,
                Posts.isDeleted,
                Users.id userId,
                Users.name userName,
                Users.isAdmin userIsAdmin,
                Users.isGhost userIsGhost,
                Forums.id forumId,
                Forums.name forumName
            FROM Posts
                JOIN Users ON Posts.userId = Users.id
                JOIN Forums ON Posts.forumId = Forums.id
            ORDER BY Posts.creationDate DESC
            LIMIT :maxCount
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':maxCount', $maxCount, PDO::PARAM_INT); /* [1] */
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        return self::convertRowsToPosts($rows);
    }

    /**
     * Get all posts within a given forum
     */
    public static function getForumPosts(int $forumId) {
        $db = Database::getDB();
        $query = '
            SELECT
                Posts.id,
                Posts.title,
                Posts.content,
                Posts.creationDate,
                Posts.isDeleted,
                Users.id userId,
                Users.name userName,
                Users.isAdmin userIsAdmin,
                Users.isGhost userIsGhost,
                Forums.id forumId,
                Forums.name forumName
            FROM Posts
                JOIN Users ON Posts.userId = Users.id
                JOIN Forums ON Posts.forumId = Forums.id
            WHERE Posts.forumId = :forumId
            ORDER BY Posts.creationDate DESC
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':forumId', $forumId);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        return self::convertRowsToPosts($rows);
    }

    public static function getUserPosts(int $userId) {
        $db = Database::getDB();
        $query = '
            SELECT
                Posts.id,
                Posts.title,
                Posts.content,
                Posts.creationDate,
                Posts.isDeleted,
                Users.id userId,
                Users.name userName,
                Users.isAdmin userIsAdmin,
                Users.isGhost userIsGhost,
                Forums.id forumId,
                Forums.name forumName
            FROM Posts
                JOIN Users ON Posts.userId = Users.id
                JOIN Forums ON Posts.forumId = Forums.id
            WHERE Posts.userId = :userId
            ORDER BY Posts.creationDate DESC
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        return self::convertRowsToPosts($rows);
    }

    /**
     * Get a single post
     */
    public static function getPost(int $id) {
        $db = Database::getDB();
        $query = '
            SELECT id, title, content, creationDate, userId, forumId, isDeleted
            FROM Posts
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row === false) return null;

        $comments = CommentDB::getPostComments($id);
        return new Post(
            $id,
            $row['title'],
            $row['content'],
            new DateTime($row['creationDate']),
            $row['userId'],
            UserDB::getUser($row['userId']),
            $row['forumId'],
            ForumDB::getForum($row['forumId']),
            CommentDB::getPostComments($id),
            $row['isDeleted']
        );
    }

    /**
     * Add a post
     */
    public static function addPost(Post $post) {
        $db = Database::getDB();
        $query = '
            INSERT INTO Posts (title, content, userId, forumId, isDeleted)
            VALUES (:title, :content, :userId, :forumId, FALSE)
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $post->title);
        $statement->bindValue(':content', $post->content);
        $statement->bindValue(':userId', $post->userId);
        $statement->bindValue(':forumId', $post->forumId);
        $statement->execute();
        $statement->closeCursor();
        return $db->lastInsertId();
    }

    /**
     * Update a post
     */
    public static function updatePost(Post $post) {
        $db = Database::getDB();
        $query = '
            UPDATE Posts
            SET title = :title,
                content = :content,
                userId = :userId,
                forumId = :forumId,
                isDeleted = :isDeleted
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $post->title);
        $statement->bindValue(':content', $post->content);
        $statement->bindValue(':userId', $post->userId);
        $statement->bindValue(':forumId', $post->forumId);
        $statement->bindValue(':isDeleted', $post->isDeleted);
        $statement->bindValue(':id', $post->id);
        $statement->execute();
        $statement->closeCursor();
    }

    /**
     * Toggle whether a post is marked as deleted
     */
    public static function toggleDeletedPost(Post $post) {
        $db = Database::getDB();
        $query = '
            UPDATE Posts
            SET isDeleted = NOT isDeleted
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $post->id);
        $statement->execute();
        $statement->closeCursor();
    }

    /**
     * Delete a post
     */
    public static function deletePost(Post $post) {
        $db = Database::getDB();
        $query = '
            DELETE FROM Posts
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $post->id);
        $statement->execute();
    }
}

/**
 * Footnotes
 * 
 * [1]: https://stackoverflow.com/questions/49770606/mysql-limit-clause-not-working-alongside-php-bindvalue
 */
?>
