<?php
require_once __DIR__ . '/auth.php';
setNoCacheHeaders();
clearAuthCookie();
header('Location: index.php');
exit;
?>
