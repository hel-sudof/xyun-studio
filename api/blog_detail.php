<?php
session_start();
require_once __DIR__ . '/db.php';

$id = $_GET['id'] ?? '';
$blog = null;

try {
    $blog = dbFetchOne("SELECT * FROM blogs WHERE id = :id", [':id' => $id]);
} catch (Exception $e) {
    // Fall through
}

if (!$blog) {
    header('Location: blog.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | <?php echo htmlspecialchars($blog['title']); ?></title>
  <link rel="stylesheet" href="style.css">
  <style>
    html, body {
      overflow-y: auto !important;
      height: auto !important;
    }
    .page-container {
      height: auto !important;
      overflow: visible !important;
      display: block !important;
    }
    a {
      color: inherit;
      text-decoration: none;
    }
    .article-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px 48px 80px 48px;
      position: relative;
      z-index: 10;
      background-color: var(--background);
    }
    
    .article-header {
      text-align: center;
      margin-bottom: 32px;
    }
    
    .article-date {
      font-family: var(--font-nuqun);
      font-size: 12px;
      color: var(--zinc-500);
      letter-spacing: 0.1em;
      margin-bottom: 16px;
    }
    
    .article-title {
      font-family: var(--font-nuqun);
      font-size: 40px;
      color: #ffffff;
      line-height: 1.2;
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }
    
    .article-hero {
      width: 100%;
      height: 500px;
      object-fit: cover;
      margin-bottom: 40px;
    }
    
    .article-content {
      font-family: var(--font-zalando-sans);
      font-size: 16px;
      color: var(--zinc-300);
      line-height: 1.8;
      white-space: pre-wrap;
    }
    
    .article-content p {
      margin-bottom: 24px;
    }
    
    .admin-controls {
      margin-top: 60px;
      padding-top: 24px;
      border-top: 1px solid var(--zinc-900);
      display: flex;
      gap: 16px;
      justify-content: flex-end;
    }
    
    .admin-btn-inline {
      font-family: var(--font-nuqun);
      font-size: 12px;
      color: #fff;
      background: none;
      border: 1px solid var(--zinc-800);
      padding: 8px 16px;
      cursor: pointer;
      letter-spacing: 0.1em;
      transition: all 0.3s;
    }
    
    .admin-btn-inline:hover {
      background: #fff;
      color: #000;
    }
    
    .admin-btn-delete {
      color: #ff4444;
      border-color: #331111;
    }
    
    .admin-btn-delete:hover {
      background: #ff4444;
      color: #fff;
    }
    
    /* Edit Modal */
    .blog-modal {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(12px);
      z-index: 1000;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.4s ease;
    }
    
    .blog-modal.open {
      opacity: 1;
      pointer-events: auto;
    }
    
    .blog-modal-content {
      background-color: var(--zinc-950);
      border: 1px solid var(--zinc-800);
      width: 100%;
      max-width: 600px;
      padding: 32px;
      position: relative;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      font-family: var(--font-nuqun);
      font-size: 10px;
      color: var(--zinc-400);
      margin-bottom: 8px;
      letter-spacing: 0.1em;
    }
    
    .form-group input, .form-group textarea {
      width: 100%;
      background-color: #000;
      border: 1px solid var(--zinc-800);
      color: #fff;
      padding: 12px;
      font-family: var(--font-zalando-sans);
    }
    
    /* Side Banners */
    .side-banner {
      position: fixed;
      top: 0;
      bottom: 0;
      width: calc((100vw - 900px) / 2);
      max-width: 320px;
      z-index: 1;
      overflow: hidden;
      border: 1px solid var(--zinc-900);
      display: none;
      filter: grayscale(100%) blur(3px);
      opacity: 0.4;
    }
    
    @media (min-width: 1200px) {
      .side-banner {
        display: block;
      }
    }
    
    .side-banner.left {
      left: 48px;
    }
    
    .side-banner.right {
      right: 48px;
    }

    .banner-slide {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      background-size: 100% auto;
      background-repeat: repeat-y;
      background-position: top center;
      opacity: 0;
      animation: bannerFade 20s infinite ease-in-out;
    }
    
    @keyframes bannerFade {
      0%   { opacity: 0; }
      10%  { opacity: 1; }
      20%  { opacity: 1; }
      30%  { opacity: 0; }
      100% { opacity: 0; }
    }
    
    .back-link {
      color: var(--zinc-500);
      font-family: var(--font-nuqun);
      font-size: 12px;
      letter-spacing: 0.1em;
      text-decoration: none;
      margin-bottom: 16px;
      display: inline-block;
      transition: all 0.3s ease;
    }
    .back-link:hover {
      color: #ffffff;
      transform: translateX(-4px);
    }
  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="page-container animate-fade-in">
    
    <!-- Left Banner -->
    <div class="side-banner left">
      <div class="banner-slide" style="background-image: url('bg/blogbanner (1).jpg'); animation-delay: 0s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (2).jpg'); animation-delay: 4s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (3).jpg'); animation-delay: 8s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (4).jpg'); animation-delay: 12s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (5).jpg'); animation-delay: 16s;"></div>
    </div>
    
    <!-- Right Banner -->
    <div class="side-banner right">
      <div class="banner-slide" style="background-image: url('bg/blogbanner (6).jpg'); animation-delay: 0s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (7).jpg'); animation-delay: 4s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (8).jpg'); animation-delay: 8s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (9).jpg'); animation-delay: 12s;"></div>
      <div class="banner-slide" style="background-image: url('bg/blogbanner (10).jpg'); animation-delay: 16s;"></div>
    </div>

    <div class="article-container">
      <a href="blog.php" class="back-link">&#10094; BACK TO EDITORIAL</a>
      
      <div class="article-header">
        <div class="article-date"><?php echo date('M d, Y', strtotime($blog['date'])); ?> &mdash; <?php echo htmlspecialchars($blog['author']); ?></div>
        <h1 class="article-title"><?php echo htmlspecialchars($blog['title']); ?></h1>
      </div>
      
      <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="Article hero" class="article-hero">
      
      <div class="article-content"><?php echo htmlspecialchars($blog['content']); ?></div>
      
      <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
      <!-- Admin Controls -->
      <div class="admin-controls">
        <button id="edit-btn" class="admin-btn-inline">EDIT POST</button>
        <form action="blog_action.php" method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to delete this post?');">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
          <button type="submit" class="admin-btn-inline admin-btn-delete">DELETE POST</button>
        </form>
      </div>
      <?php endif; ?>
      
    </div>
  </div>

  <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
  <!-- Edit Blog Modal -->
  <div id="edit-modal" class="blog-modal">
    <div class="blog-modal-content">
      <button id="close-modal-btn" type="button" style="position: absolute; right: 16px; top: 16px; background: none; border: none; color: #fff; font-size: 24px; cursor: pointer;">&times;</button>
      <h2 style="font-family: var(--font-nuqun); color: #fff; margin-bottom: 24px; letter-spacing: 0.1em;">EDIT ARTICLE</h2>
      
      <form action="blog_action.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
        
        <div class="form-group">
          <label>TITLE</label>
          <input type="text" name="title" required value="<?php echo htmlspecialchars($blog['title']); ?>">
        </div>
        
        <div class="form-group">
          <label>IMAGE PATH</label>
          <input type="text" name="image" required value="<?php echo htmlspecialchars($blog['image']); ?>">
        </div>
        
        <div class="form-group">
          <label>CONTENT</label>
          <textarea name="content" rows="8" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
        </div>
        
        <button type="submit" class="luxury-btn" style="width: 100%; border: 1px solid #fff;">SAVE CHANGES</button>
      </form>
    </div>
  </div>

  <script>
    const modal = document.getElementById('edit-modal');
    document.getElementById('edit-btn').addEventListener('click', () => modal.classList.add('open'));
    document.getElementById('close-modal-btn').addEventListener('click', () => modal.classList.remove('open'));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('open');
    });
  </script>
  <?php endif; ?>
</body>
</html>
