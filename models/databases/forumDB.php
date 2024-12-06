<?php
/**
 * Title: Forum Database
 * Purpose: To view, add, update, and delete forums
 */
class ForumDB {
    private const BASE_QUERY = '
        SELECT id, name
        FROM Forums
    ';

    // Convert a SQL row to a forum object
    private static function convertRowToForum($row) {
        return new Forum($row['id'], $row['name'], []);
    }

    // Get a list of all forums
    public static function getForums() {
        $query = self::BASE_QUERY . 'ORDER BY name';
        $rows = Database::execute($query);
        $forums = [];
        foreach ($rows as $row) {
            $forums[] = self::convertRowToForum($row);
        }
        return $forums;
    }

    // Get a forum with all its posts
    public static function getForum(int $id) {
        $query = self::BASE_QUERY . 'WHERE id = :id';
        $rows = Database::execute($query, [':id' => $id]);
        if (count($rows) == 0) return null;
        $forum = self::convertRowToForum($rows[0]);
        $forum->posts = PostDB::getForumPosts($id);
        return $forum;
    }

    // Get a forum by its name
    public static function getForumByName(string $name) {
        $query = self::BASE_QUERY . 'WHERE name = :name';
        $rows = Database::execute($query, [':name' => $name]);
        if (count($rows) == 0) return null;
        return self::convertRowToForum($rows[0]);
    }

    // Validate a forum
    public static function isForumValid(Forum $forum) {
        $query = self::BASE_QUERY . 'WHERE name = :name AND id != :id';
        $rows = Database::execute($query, [
            ':name' => $forum->name,
            ':id' => $forum->id
        ]);
        return (count($rows) == 0);
    }

    // Add a forum
    public static function addForum(Forum $forum) {
        $query = '
            INSERT INTO Forums (name)
            VALUES (:name)
        ';
        Database::execute($query, [':name' => $forum->name]);
        return Database::getDB()->lastInsertId();
    }

    // Update a forum
    public static function updateForum(Forum $forum) {
        $query = '
            UPDATE Forums
            SET name = :name
            WHERE id = :id
        ';
        Database::execute($query, [
            ':name' => $forum->name,
            ':id' => $forum->id
        ]);
    }

    // Delete a forum
    public static function deleteForum(Forum $forum) {
        $query = 'DELETE FROM Forums WHERE id = :id';
        Database::execute($query, [':id' => $forum->id]);
    }
}
?>
