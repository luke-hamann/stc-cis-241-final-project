<?php
/**
 * Title: User Database
 * Purpose: To list, add, update, and delete users
 */
class UserDB {

    /**
     * Get a list of all users
     */
    public static function getUsers() {
        $db = Database::getDB();
        $query = 'SELECT * FROM Users ORDER BY name';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        $users = [];
        foreach ($rows as $row) {
            if ($row['isGhost']) continue;
            $users[] = new User(
                $row['id'], $row['name'], '', $row['isAdmin'], $row['isGhost']);
        }

        return $users;
    }

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
        return new User($row['id'], $row['name'], '', $row['isAdmin'], $row['isGhost']);
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
        return new User($row['id'], $row['name'], '', $row['isAdmin'], $row['isGhost']);
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
        if ($row === false ||
            !password_verify($password, $row['password']) ||
            $row['isGhost']) {
            return null;
        }

        return new User($row['id'], $row['name'], '', $row['isAdmin'], $row['isGhost']);
    }

    /**
     * Add a user
     */
    public static function addUser(User $user) {
        $db = Database::getDB();
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        $query = '
            INSERT INTO Users (name, password, isAdmin, isGhost)
            VALUES (:name, :password, FALSE, FALSE)
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $user->name);
        $statement->bindValue(':password', $user->password);
        $statement->execute();
        $statement->closeCursor();
        return $db->lastInsertId();
    }

    /**
     * Update a user's password
     */
    public static function updateUserPassword(User $user) {
        $db = Database::getDB();
        $query = '
            UPDATE Users
            SET password = :password
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':password',
            password_hash($user->password, PASSWORD_DEFAULT));
        $statement->bindValue(':id', $user->id);
        $statement->execute();
        $statement->closeCursor();
    }

    /**
     * Reset a user's password
     */
    public static function resetUserPassword(User $user) {
        $user->password = bin2hex(random_bytes(16));
        self::updateUserPassword($user);
        return $user;
    }

    /**
     * Mark a user as a ghost
     */
    public static function markUserAsGhost(User $user) {
        $db = Database::getDB();
        $query = '
            UPDATE Users
            SET isGhost = TRUE
            WHERE id = :id
        ';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $user->id);
        $statement->execute();
        $statement->closeCursor();
    }

    /**
     * Delete a user
     */
    public static function deleteUser(User $user) {
        $db = Database::getDB();
        $query = 'DELETE FROM Users WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $user->id);
        $statement->execute();
        $statement->closeCursor();
    }
}
?>
