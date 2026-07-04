<?php
// Debug endpoint - check database connection and environment
echo "=== PHP Version ===\n";
echo phpversion() . "\n\n";

echo "=== Extensions ===\n";
$exts = ['pdo', 'pdo_pgsql', 'pgsql', 'json', 'fileinfo', 'mbstring'];
foreach ($exts as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? '✅' : '❌') . "\n";
}

echo "\n=== PDO Drivers ===\n";
print_r(PDO::getAvailableDrivers());

echo "\n=== DATABASE_URL env ===\n";
$env = getenv('DATABASE_URL');
echo $env ? substr($env, 0, 50) . '...' : '❌ NOT SET';
echo "\n\n";

echo "=== Testing DB Connection ===\n";
try {
    require_once __DIR__ . '/db.php';
    $pdo = getDbConnection();
    echo "✅ Connection OK\n";
    
    // Test query
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(', ', $tables) . "\n";
    
    // Test blog count
    $count = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    echo "Blog count: $count\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Current Time ===\n";
echo date('Y-m-d H:i:s') . "\n";
