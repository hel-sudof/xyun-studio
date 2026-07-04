<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Helper: set flash message in session
if (!function_exists('setFlash')) {
    function setFlash($msg) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash_msg'] = $msg;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ---------- CREATE ----------
    if ($action === 'create') {
        $id = uniqid();
        $title = $_POST['title'] ?? '';
        $image = $_POST['image'] ?? '';
        $content = $_POST['content'] ?? '';
        $date = date('Y-m-d');
        $author = 'xyún admin';

        // Handle file upload — use base64 data URL (Vercel is read-only)
        if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $imgData = file_get_contents($_FILES['image_file']['tmp_name']);
            $mime = mime_content_type($_FILES['image_file']['tmp_name']) ?: 'image/jpeg';
            $image = 'data:' . $mime . ';base64,' . base64_encode($imgData);
        }

        try {
            dbExecute(
                "INSERT INTO blogs (id, title, image, content, date, author) VALUES (:id, :title, :image, :content, :date, :author)",
                [':id' => $id, ':title' => $title, ':image' => $image, ':content' => $content, ':date' => $date, ':author' => $author]
            );
        } catch (Exception $e) {
            // DB not available — save to JSON as fallback
            $jsonPath = realpath(__DIR__ . '/../data/blogs.json');
            if ($jsonPath && file_exists($jsonPath)) {
                $blogs = json_decode(file_get_contents($jsonPath), true) ?: [];
                $blogs[] = [
                    'id' => $id,
                    'title' => $title,
                    'image' => $image,
                    'content' => $content,
                    'date' => $date,
                    'author' => $author
                ];
                file_put_contents($jsonPath, json_encode($blogs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            } else {
                setFlash('Blog gagal disimpan: database dan file JSON tidak tersedia.');
                header('Location: blog.php');
                exit;
            }
        }

        header('Location: blog.php');
        exit;
    }
    
    // ---------- UPDATE ----------
    elseif ($action === 'update') {
        $id = $_POST['id'] ?? '';
        $title = $_POST['title'] ?? '';
        $image = $_POST['image'] ?? '';
        $content = $_POST['content'] ?? '';

        // Handle file upload — use base64 data URL (Vercel is read-only)
        if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $imgData = file_get_contents($_FILES['image_file']['tmp_name']);
            $mime = mime_content_type($_FILES['image_file']['tmp_name']) ?: 'image/jpeg';
            $image = 'data:' . $mime . ';base64,' . base64_encode($imgData);
        }

        try {
            dbExecute(
                "UPDATE blogs SET title = :title, image = :image, content = :content WHERE id = :id",
                [':id' => $id, ':title' => $title, ':image' => $image, ':content' => $content]
            );
        } catch (Exception $e) {
            setFlash('Blog gagal diupdate: database tidak tersedia.');
            header('Location: blog_detail.php?id=' . $id);
            exit;
        }

        header('Location: blog_detail.php?id=' . $id);
        exit;
    }
    
    // ---------- DELETE ----------
    elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';

        try {
            dbExecute("DELETE FROM blogs WHERE id = :id", [':id' => $id]);
        } catch (Exception $e) {
            setFlash('Blog gagal dihapus: database tidak tersedia.');
        }

        header('Location: blog.php');
        exit;
    }
}

// Fallback redirect
header('Location: blog.php');
exit;
?>
