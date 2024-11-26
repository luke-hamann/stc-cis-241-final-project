<?php
/**
 * Title: Forum Database
 * Purpose: To view, add, update, and delete forums
 */
class ForumDB {
    private function __construct() {}

    /**
     * Get a list of all forums
     */
    public static function getForums() {
        $db = Database::getDB();
        $query = 'SELECT id, name FROM Forums ORDER BY name';
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

    /**
     * Get a forum with all its posts
     */
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

    /**
     * Get a forum by its name
     */
    public static function getForumByName(string $name) {
        $db = Database::getDB();
        $query = 'SELECT id, name FROM Forums WHERE name = :name';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row === false) return null;

        return new Forum($row['id'], $row['name'], null);
    }

    /**
     * Validate a forum
     */
    public static function isForumValid(Forum $forum) {
        $db = Database::getDB();
        $query = '
            SELECT id, name
            FROM Forums
            WHERE name = :name AND
                id != :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $forum->name);
        $statement->bindValue(':id', $forum->id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        return ($row === false);
    }

    /**
     * Add a forum
     */
    public static function addForum(Forum $forum) {
        $db = Database::getDB();
        $query = '
            INSERT INTO Forums (name)
            VALUES (:name)
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $forum->name);
        $statement->execute();
        $statement->closeCursor();
        return $db->lastInsertId();
    }

    /**
     * Update a forum
     */
    public static function updateForum(Forum $forum) {
        $db = Database::getDB();
        $query = '
            UPDATE Forums
            SET name = :name
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $forum->name);
        $statement->bindValue(':id', $forum->id);
        $statement->execute();
        $statement->closeCursor();
    }

    /**
     * Delete a forum
     */
    public static function deleteForum(Forum $forum) {
        $db = Database::getDB();
        $query = 'DELETE FROM Forums WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $forum->id);
        $statement->execute();
        $statement->closeCursor();
    }
}
?>
