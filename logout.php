<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login page (index.php in root)
header("Location: /pwa/index.php");
exit();

