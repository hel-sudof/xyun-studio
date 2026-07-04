<?php
/**
 * Cookie-based Authentication Helper
 * Works on both localhost and Vercel serverless
 */

// Prevent Vercel from caching pages dynamically rendered based on user auth state
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

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
    $cookieStr = AUTH_COOKIE_NAME . "=" . urlencode($token) . "; Path=/; Max-Age=604800; HttpOnly; SameSite=Lax";
    header("Set-Cookie: " . $cookieStr, false);
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
    $cookieStr = AUTH_COOKIE_NAME . "=; Path=/; Max-Age=0; HttpOnly; SameSite=Lax";
    header("Set-Cookie: " . $cookieStr, false);
}
