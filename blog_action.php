<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $id = uniqid();
        $title = $_POST['title'] ?? '';
        $image = $_POST['image'] ?? '';
        $content = $_POST['content'] ?? '';
        $date = date('Y-m-d');
        $author = 'xyún admin';

        dbExecute(
            "INSERT INTO blogs (id, title, image, content, date, author) VALUES (:id, :title, :image, :content, :date, :author)",
            [':id' => $id, ':title' => $title, ':image' => $image, ':content' => $content, ':date' => $date, ':author' => $author]
        );

        header('Location: blog.php');
        exit;
    }
    
    elseif ($action === 'update') {
        $id = $_POST['id'] ?? '';
        $title = $_POST['title'] ?? '';
        $image = $_POST['image'] ?? '';
        $content = $_POST['content'] ?? '';

        dbExecute(
            "UPDATE blogs SET title = :title, image = :image, content = :content WHERE id = :id",
            [':id' => $id, ':title' => $title, ':image' => $image, ':content' => $content]
        );

        header('Location: blog_detail.php?id=' . $id);
        exit;
    }
    
    elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';

        dbExecute("DELETE FROM blogs WHERE id = :id", [':id' => $id]);

        header('Location: blog.php');
        exit;
    }
}

// Fallback redirect
header('Location: blog.php');
exit;
?>
