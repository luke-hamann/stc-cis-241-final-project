<?php
/**
 * Title: Post Database
 * Purpose: To view, add, update, and delete posts
 */
class PostDB {

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
                Users.id userId,
                Users.name userName,
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

        $posts = array();
        foreach ($rows as $row) {
            $user = new User($row['userId'], $row['userName'], '');
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
                []
            );
            $posts[] = $post;
        }

        return $posts;
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
                Users.id userId,
                Users.name userName,
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
        
        $posts = array();
        foreach ($rows as $row) {
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['content'],
                new DateTime($row['creationDate']),
                $row['userId'],
                new User($row['userId'], $row['userName'], ''),
                $row['forumId'],
                new Forum($row['forumId'], $row['forumName'], array()),
                []
            );
            $posts[] = $post;
        }

        return $posts;
    }

    /**
     * Get a single post
     */
    public static function getPost(int $id) {
        $db = Database::getDB();
        $query = '
            SELECT id, title, content, creationDate, userId, forumId
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
            CommentDB::getPostComments($id)
        );
    }

    /**
     * Add a post
     */
    public static function addPost(Post $post) {
        $db = Database::getDB();
        $query = '
            INSERT INTO Posts (title, content, userId, forumId)
            VALUES (:title, :content, :userId, :forumId)
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
            SET title = :title, content = :content, userId = :userId, forumId = :forumId
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $post->title);
        $statement->bindValue(':content', $post->content);
        $statement->bindValue(':userId', $post->userId);
        $statement->bindValue(':forumId', $post->forumId);
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
            UPDATE Posts
            SET title = \'[ Deleted ]\', content = \'[ Deleted ]\'
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
