<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forum Site</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header class="sticky-top bg-info-subtle">
        <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
                <a class="navbar-brand" href="?action=home">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="?action=forums" class="nav-link">Forums</a>
                        </li>
                        <li class="nav-item">
                            <a href="?action=users" class="nav-link">Users</a>
                        </li>
                        <?php if (isset($model->currentUser)) : ?>
                            <li class="nav-item">
                                <a href="?action=user&id=<?php echo $model->currentUser->id; ?>" class="nav-link">Logged in as <?php echo htmlspecialchars($model->currentUser->name); ?></a>
                            </li>
                            <li class="nav-item">
                                <form action="?action=logout" method="post">
                                    <input type="submit" value="Logout" class="btn btn-outline-danger ms-md-2" />
                                </form>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a href="?action=login" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item">
                                <a href="?action=register" class="nav-link">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
