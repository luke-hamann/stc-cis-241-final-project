<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="?action=home">
                        Home
                    </a>
                </li>
                <li>
                    <a href="?action=forums">
                        Forums
                    </a>
                </li>
                <?php if (!isset($currentUser)) : ?>
                    <li>
                        <a href="?action=login">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="?action=register">
                            Register
                        </a>
                    </li>
                <?php else : ?>
                    <li>
                        Logged in as <?php echo htmlspecialchars($currentUser->name); ?>
                    </li>
                    <li>
                        <form action="?action=logout" method="post">
                            <input type="submit" value="Logout" />
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>