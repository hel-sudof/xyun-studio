<?php
require_once __DIR__ . '/auth.php';
clearAuthCookie();
header('Location: index.php');
exit;
?>
