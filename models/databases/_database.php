<?php
/**
 * Title: Database Model
 * Purpose: To provide a connection to the database and execute prepared statements
 */
class Database {
    private static $dsn = 'mysql:host=localhost;dbname=forumSite';
    private static $username = 'forumSite';
    private static $password = 'password';
    private static $db;

    // Return the database connection
    public static function getDB() {
        if (isset(self::$db)) return self::$db;

        try {
            self::$db = new PDO(self::$dsn, self::$username, self::$password);
        } catch (PDOException $e) {
            throw new Exception('Database connection error');
        }

        return self::$db;
    }

    // Execute a query with given parameter bindings
    public static function execute(string $query, array $bindings = []) {
        $db = self::getDB();
        $statement = $db->prepare($query);
        foreach ($bindings as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        return $rows;
    }
}
?>
