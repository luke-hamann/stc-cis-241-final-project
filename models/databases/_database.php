<?php
/**
 * Title: Database Model
 * Purpose: To provide a connection to the database
 */
class Database {
    private static $dsn = 'mysql:host=localhost;dbname=forumSite';
    private static $username = 'forumSite';
    private static $password = 'password';
    private static $db;

    private function __construct() {}

    /**
     * Return the database connection
     */
    public static function getDB() {
        if (isset($db)) return $db;

        try {
            self::$db = new PDO(self::$dsn, self::$username, self::$password);
        } catch (PDOException $e) {
            throw new Exception('Database connection error');
        }

        return self::$db;
    }
}
?>
