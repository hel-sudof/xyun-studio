<?php
/**
 * PostgreSQL Database Connection (NeonDB)
 * 
 * Connection string format:
 * postgresql://neondb_owner:npg_uMO8lxR6qyZI@ep-late-paper-aoj1q31n-pooler.c-2.ap-southeast-1.aws.neon.tech/neondb?sslmode=require
 */

function getDbConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        // Use environment variable on Vercel, fallback to hardcoded for local dev
        $dsn = getenv('DATABASE_URL') ?: 'postgresql://neondb_owner:npg_uMO8lxR6qyZI@ep-late-paper-aoj1q31n-pooler.c-2.ap-southeast-1.aws.neon.tech/neondb?sslmode=require';
        
        // Parse the PostgreSQL connection string
        $parts = parse_url($dsn);
        
        $host = $parts['host'] ?? 'ep-late-paper-aoj1q31n-pooler.c-2.ap-southeast-1.aws.neon.tech';
        $port = $parts['port'] ?? 5432;
        $user = $parts['user'] ?? 'neondb_owner';
        $pass = $parts['pass'] ?? 'npg_uMO8lxR6qyZI';
        $dbname = ltrim($parts['path'] ?? '/neondb', '/');
        
        // Build SSL options from query string
        $query = [];
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }
        $sslmode = $query['sslmode'] ?? 'require';
        
        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $pdo = new PDO($dsn, $user, $pass, $options);
            
            // Set SSL mode if needed
            if ($sslmode === 'require') {
                $pdo->exec("SET sslmode = 'require'");
            }
            
            // Auto-create tables if they don't exist
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS blogs (
                    id          VARCHAR(64) PRIMARY KEY,
                    title       TEXT NOT NULL,
                    image       TEXT DEFAULT '',
                    content     TEXT DEFAULT '',
                    date        DATE DEFAULT CURRENT_DATE,
                    author      VARCHAR(255) DEFAULT 'xyún admin',
                    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
                CREATE TABLE IF NOT EXISTS purchases (
                    id           VARCHAR(64) PRIMARY KEY,
                    timestamp    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    product_id   VARCHAR(64) DEFAULT '',
                    product_name VARCHAR(255) DEFAULT '',
                    items        JSONB DEFAULT '[]'::jsonb,
                    customer     JSONB DEFAULT '{}'::jsonb,
                    status       VARCHAR(32) DEFAULT 'Pending' CHECK (status IN ('Pending', 'Accepted', 'Declined')),
                    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
            ");
        } catch (PDOException $e) {
            // Log error and return null instead of crashing
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please check configuration.");
        }
    }
    
    return $pdo;
}

/**
 * Helper: fetch all rows from a query
 */
function dbFetchAll($sql, $params = []) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Helper: fetch single row
 */
function dbFetchOne($sql, $params = []) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

/**
 * Helper: execute INSERT/UPDATE/DELETE
 */
function dbExecute($sql, $params = []) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

/**
 * Helper: get last inserted ID
 */
function dbLastInsertId($sequenceName = null) {
    $pdo = getDbConnection();
    return $pdo->lastInsertId($sequenceName);
}
