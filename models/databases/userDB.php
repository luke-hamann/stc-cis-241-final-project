<?php
/**
 * Title: User Database
 * Purpose: To view, add, update, and delete users
 */
class UserDB {
    private const BASE_QUERY = '
        SELECT id, name, password, isAdmin, isGhost
        FROM Users
    ';

    // Convert a SQL row to a user object
    private static function convertRowToUser($row) {
        return new User(
            $row['id'],
            $row['name'],
            $row['password'],
            $row['isAdmin'],
            $row['isGhost']
        );
    }

    // Convert SQL rows to a list of user objects
    private static function convertRowsToUsers($rows) {
        $users = [];
        foreach ($rows as $row) {
            $users[] = self::convertRowToUser($row);
        }
        return $users;
    }

    // Get a list of all users, excluding ghosts
    public static function getUsers() {
        $query = self::BASE_QUERY . '
            WHERE isGhost = FALSE
            ORDER BY name
        ';
        $rows = Database::execute($query);
        return self::convertRowsToUsers($rows);
    }

    // Get a user based on their id
    public static function getUser(int $id) {
        $query = self::BASE_QUERY . 'WHERE id = :id';
        $rows = Database::execute($query, [':id' => $id]);
        if (count($rows) == 0) return null;
        return self::convertRowToUser($rows[0]);
    }

    // Get a user based on their name
    public static function getUserByName(string $name) {
        $query = self::BASE_QUERY . 'WHERE name = :name';
        $rows = Database::execute($query, [':name' => $name]);
        if (count($rows) == 0) return null;
        return self::convertRowToUser($rows[0]);
    }

    // Attempt to authenticate given credentials
    public static function loginUser(string $name, string $password) {
        $query = self::BASE_QUERY . 'WHERE name = :name';
        $rows = Database::execute($query, [':name' => $name]);
        if (count($rows) == 0) return null;

        $user = self::convertRowToUser($rows[0]);
        if (!password_verify($password, $user->password) || $user->isGhost) {
            return null;
        }

        return $user;
    }

    // Add a user
    public static function addUser(User $user) {
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        $query = '
            INSERT INTO Users (name, password, isAdmin, isGhost)
            VALUES (:name, :password, :isAdmin, :isGhost)
        ';
        Database::execute($query, [
            ':name' => $user->name,
            ':password' => $user->password,
            ':isAdmin' => $user->isAdmin,
            ':isGhost' => $user->isGhost
        ]);
        return Database::getDB()->lastInsertId();
    }

    // Update a user's password
    public static function updateUserPassword(User $user) {
        $password = password_hash($user->password, PASSWORD_DEFAULT);
        $query = '
            UPDATE Users
            SET password = :password
            WHERE id = :id
        ';
        Database::execute($query, [
            ':password' => $password,
            ':id' => $user->id
        ]);
    }

    // Reset a user's password
    public static function resetUserPassword(User $user) {
        $user->password = bin2hex(random_bytes(16));
        self::updateUserPassword($user);
        return $user;
    }

    // Mark a user as a ghost
    public static function markUserAsGhost(User $user) {
        $query = '
            UPDATE Users
            SET isGhost = TRUE
            WHERE id = :id
        ';
        Database::execute($query, [':id' => $user->id]);
    }

    // Delete a user
    public static function deleteUser(User $user) {
        $query = 'DELETE FROM Users WHERE id = :id';
        Database::execute($query, [':id' => $user->id]);
    }
}
?>
