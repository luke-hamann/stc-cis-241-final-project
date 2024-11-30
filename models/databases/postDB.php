<?php
/**
 * Title: Post Database
 * Purpose: To view, add, update, and delete posts
 */
class PostDB {
    private const BASE_QUERY = '
        SELECT
            Posts.id,
            Posts.title,
            Posts.content,
            Posts.creationDate,
            Posts.isHidden,
            Users.id userId,
            Users.name userName,
            Users.isAdmin userIsAdmin,
            Users.isGhost userIsGhost,
            Forums.id forumId,
            Forums.name forumName
        FROM Posts
            JOIN Users ON Posts.userId = Users.id
            JOIN Forums ON Posts.forumId = Forums.id
    ';    

    /**
     * Convert a SQL row to a post object
     */
    private static function convertRowToPost($row) {
        return new Post(
            $row['id'],
            $row['title'],
            $row['content'],
            new DateTime($row['creationDate']),
            $row['userId'],
            new User(
                $row['userId'],
                $row['userName'],
                '',
                $row['userIsAdmin'],
                $row['userIsGhost']
            ),
            $row['forumId'],
            new Forum($row['forumId'], $row['forumName'], []),
            [],
            $row['isHidden']
        );
    }

    /**
     * Convert SQL rows to a list of post objects
     */
    private static function convertRowsToPosts($rows) {
        $posts = [];
        foreach ($rows as $row) {
            $posts[] = self::convertRowToPost($row);
        }
        return $posts;
    }

    /**
     * Get recent posts across all forums
     */
    public static function getRecentPosts(int $maxCount = 20) {
        $db = Database::getDB();
        $query = self::BASE_QUERY . '
            ORDER BY Posts.creationDate DESC
            LIMIT :maxCount
        ';
        $statement = $db->prepare($query);
        // https://stackoverflow.com/questions/49770606/mysql-limit-clause-not-working-alongside-php-bindvalue
        $statement->bindValue(':maxCount', $maxCount, PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        return self::convertRowsToPosts($rows);
    }

    /**
     * Get all posts within a given forum
     */
    public static function getForumPosts(int $forumId) {
        $query = self::BASE_QUERY . '
            WHERE Posts.forumId = :forumId
            ORDER BY Posts.creationDate DESC
        ';
        $rows = Database::execute($query, [':forumId' => $forumId]);
        return self::convertRowsToPosts($rows);
    }

    /**
     * Get all posts by a given user
     */
    public static function getUserPosts(int $userId) {
        $query = self::BASE_QUERY . '
            WHERE Posts.userId = :userId
            ORDER BY Posts.creationDate DESC
        ';
        $rows = Database::execute($query, [':userId' => $userId]);
        return self::convertRowsToPosts($rows);
    }

    /**
     * Get a single post with its comments
     */
    public static function getPost(int $id) {
        $query = self::BASE_QUERY . 'WHERE Posts.id = :id';
        $rows = Database::execute($query, [':id' => $id]);
        if (count($rows) == 0) return false;
        $post = self::convertRowToPost($rows[0]);
        $post->comments = CommentDB::getPostComments($id);
        return $post;
    }

    /**
     * Add a post
     */
    public static function addPost(Post $post) {
        $query = '
            INSERT INTO Posts (title, content, userId, forumId, isHidden)
            VALUES (:title, :content, :userId, :forumId, FALSE)
        ';
        Database::execute($query, [
            ':title' => $post->title,
            ':content' => $post->content,
            ':userId' => $post->userId,
            ':forumId' => $post->forumId
        ]);
        return Database::getDB()->lastInsertId();
    }

    /**
     * Update a post
     */
    public static function updatePost(Post $post) {
        $query = '
            UPDATE Posts
            SET title = :title,
                content = :content,
                userId = :userId,
                forumId = :forumId,
                isHidden = :isHidden
            WHERE id = :id
        ';
        Database::execute($query, [
            ':title' => $post->title,
            ':content' => $post->content,
            ':userId' => $post->userId,
            ':forumId' => $post->forumId,
            ':isHidden' => $post->isHidden,
            ':id' => $post->id
        ]);
    }

    /**
     * Toggle whether a post is marked as hidden
     */
    public static function togglePostVisibility(Post $post) {
        $query = '
            UPDATE Posts
            SET isHidden = NOT isHidden
            WHERE id = :id
        ';
        Database::execute($query, [':id' => $post->id]);
    }

    /**
     * Delete a post
     */
    public static function deletePost(Post $post) {
        $query = '
            DELETE FROM Posts
            WHERE id = :id
        ';
        Database::execute($query, [':id' => $post->id]);
    }
}
?>
