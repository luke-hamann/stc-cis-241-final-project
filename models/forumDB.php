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
            $forum = new Forum($row['id'], $row['name']);
            $forums[] = $forum;
        }

        return $forums;
    }
}
?>
