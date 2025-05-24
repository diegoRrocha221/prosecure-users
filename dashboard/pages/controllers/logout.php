<?php
require_once '/var/www/html/controllers/inc.sessions.php';
session_start();
session_unset();
session_destroy();
header('Location: https://prosecurelsp.com/users/intermediate_logout.php');
exit();
?>