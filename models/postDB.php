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
            $forum = new Forum($row['forumId'], $row['forumName']);
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['content'],
                $row['creationDate'],
                $row['userId'],
                $user,
                $row['forumId'],
                $forum
            );
            $posts[] = $post;
        }

        return $posts;
    }
}

/**
 * Footnotes
 * 
 * [1]: https://stackoverflow.com/questions/49770606/mysql-limit-clause-not-working-alongside-php-bindvalue
 */
?>
