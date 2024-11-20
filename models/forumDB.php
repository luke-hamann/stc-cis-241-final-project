<?php
class ForumDB {
    private function __construct() {}

    public static function getForums() {
        $db = Database::getDB();
        $query = '
            SELECT id, name
            FROM Forums
            ORDER BY name
        ';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        $forums = array();
        foreach ($rows as $row) {
            $forum = new Forum($row['id'], $row['name'], []);
            $forums[] = $forum;
        }

        return $forums;
    }

    public static function getForum(int $id) {
        $db = Database::getDB();
        $query = 'SELECT id, name FROM Forums WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row === false) return null;

        $posts = PostDB::getForumPosts($id);

        return new Forum($row['id'], $row['name'], $posts);
    }
}
?>
