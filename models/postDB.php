<?php
class PostDB {
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
}

/**
 * Footnotes
 * 
 * [1]: https://stackoverflow.com/questions/49770606/mysql-limit-clause-not-working-alongside-php-bindvalue
 */
?>
