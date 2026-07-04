<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

// Admin check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || empty($input['id']) || empty($input['action'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
        exit;
    }
    
    $target_id = $input['id'];
    $action = $input['action']; // 'accept', 'decline', or 'undo'
    
    if (!in_array($action, ['accept', 'decline', 'undo'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        exit;
    }
    
    $new_status = 'Pending';
    if ($action === 'accept') $new_status = 'Accepted';
    if ($action === 'decline') $new_status = 'Declined';
    
    try {
        $stmt = getDbConnection()->prepare("UPDATE purchases SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $new_status, ':id' => $target_id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'new_status' => $new_status]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Request ID not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
    
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request method']);
