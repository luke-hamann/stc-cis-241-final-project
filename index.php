<?php

start_session();
if (!isset($_SESSION['userId'])) {
    $_SESSION['userId'] = 0;
}

$action = FILTER_INPUT(INPUT_POST, 'action') ?? FILTER_INPUT(INPUT_GET, 'action') ?? 'index';


?>
