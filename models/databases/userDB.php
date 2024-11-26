<?php
/**
 * Title: User Database
 * Purpose: To list, add, update, and delete users
 */
class UserDB {

    /**
     * Get a user based on their id
     */
    public static function getUser(int $id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Users WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if ($row === false) return null;
        return new User($row['id'], $row['name'], '', $row['admin']);
    }

    /**
     * Get a user based on their name
     */
    public static function getUserByName(string $name) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Users WHERE name = :name';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if ($row === false) return null;
        return new User($row['id'], $row['name'], '', $row['admin']);
    }

    /**
     * Attempt to authenticate given credentials
     */
    public static function loginUser(string $name, string $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $db = Database::getDB();
        $query = 'SELECT *
                  FROM Users
                  WHERE name = :name';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if ($row === false || !password_verify($password, $row['password'])) {
            return null;
        }

        return new User($row['id'], $row['name'], '', $row['admin']);
    }

    /**
     * Add a user
     */
    public static function addUser(User $user) {
        $db = Database::getDB();
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        $query = '
            INSERT INTO Users (name, password, admin)
            VALUES (:name, :password, FALSE)
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $user->name);
        $statement->bindValue(':password', $user->password);
        $statement->execute();
        $statement->closeCursor();
        return $db->lastInsertId();
    }

    /**
     * Update a user
     */
    public static function updateUser(User $user) {

    }
}
?>
