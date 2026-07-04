<?php
/**
 * Cookie-based Authentication Helper
 * Works on both localhost and Vercel serverless
 */

define('AUTH_COOKIE_NAME', 'xyun_auth');
define('AUTH_SECRET', 'xyun_studio_2026_secret_key');

function setAuthCookie($username, $isAdmin) {
    $data = json_encode([
        'username' => $username,
        'is_admin' => $isAdmin,
        'logged_in' => true,
        'exp' => time() + (60 * 60 * 24 * 7) // 7 days
    ]);
    $token = base64_encode($data) . '.' . hash_hmac('sha256', $data, AUTH_SECRET);
    setcookie(AUTH_COOKIE_NAME, $token, [
        'expires' => time() + (60 * 60 * 24 * 7),
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

function getAuthUser() {
    if (!isset($_COOKIE[AUTH_COOKIE_NAME])) return null;
    
    $parts = explode('.', $_COOKIE[AUTH_COOKIE_NAME], 2);
    if (count($parts) !== 2) return null;
    
    $data = base64_decode($parts[0]);
    $expectedSig = hash_hmac('sha256', $data, AUTH_SECRET);
    
    if (!hash_equals($expectedSig, $parts[1])) return null;
    
    $user = json_decode($data, true);
    if (!$user || !isset($user['exp']) || $user['exp'] < time()) return null;
    
    return $user;
}

function isLoggedIn() {
    $user = getAuthUser();
    return $user !== null && ($user['logged_in'] ?? false);
}

function isAdmin() {
    $user = getAuthUser();
    return $user !== null && ($user['is_admin'] ?? false);
}

function clearAuthCookie() {
    setcookie(AUTH_COOKIE_NAME, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}
