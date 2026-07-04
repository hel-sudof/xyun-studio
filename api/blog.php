<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

try {
    $blogs = dbFetchAll("SELECT * FROM blogs ORDER BY date DESC, created_at DESC");
} catch (Exception $e) {
    $blogs = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | BLOG</title>
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
    .page-header {
      text-align: center;
      padding: 80px 0 60px 0;
      background-image: url('bg/blogbg.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
    }
    .page-header::before {
      content: "";
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }
    .page-header > * {
      position: relative;
      z-index: 2;
    }
    
    .page-title {
      font-family: var(--font-nuqun);
      font-size: 48px;
      letter-spacing: 0.15em;
      color: #ffffff;
      margin-bottom: 12px;
    }
    
    .page-subtitle {
      font-size: 12px;
      color: #ffffff;
      letter-spacing: 0.1em;
    }
    
    .blog-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 40px;
      padding: 60px 48px 120px 48px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    @media (min-width: 768px) {
      .blog-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    
    @media (min-width: 1024px) {
      .blog-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    
    .blog-card {
      text-decoration: none;
      display: flex;
      flex-direction: column;
      background-color: var(--zinc-900);
      border: 1px solid var(--zinc-700);
      box-shadow: 0 4px 20px rgba(0,0,0, 0.5);
      transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
    }
    
    .blog-card:hover {
      border-color: var(--zinc-400);
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0,0,0, 0.8);
    }
    
    .blog-img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-bottom: 1px solid var(--zinc-700);
    }
    
    .blog-content-preview {
      padding: 24px;
    }
    
    .blog-date {
      font-family: var(--font-nuqun);
      font-size: 10px;
      color: var(--zinc-500);
      letter-spacing: 0.1em;
      margin-bottom: 12px;
    }
    
    .blog-title {
      font-size: 18px;
      color: #ffffff;
      margin-bottom: 16px;
      line-height: 1.4;
      text-transform: uppercase;
    }
    
    .blog-excerpt {
      font-size: 12px;
      color: var(--zinc-400);
      line-height: 1.6;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    /* New Blog Modal */
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
    
    .admin-btn {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #fff;
      color: #000;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      cursor: pointer;
      z-index: 900;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
      border: none;
    }
  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="page-container animate-fade-in">
    <div class="page-header">
      <h1 class="page-title">EDITORIAL</h1>
      <div class="page-subtitle">STORIES, INSPIRATION, AND BEHIND THE SCENES</div>
    </div>
    
    <div class="blog-grid">
      <?php if(empty($blogs)): ?>
        <p style="color: var(--zinc-500); grid-column: 1 / -1; text-align: center;">No articles available at the moment.</p>
      <?php else: ?>
        <?php foreach($blogs as $blog): ?>
          <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="blog-card">
            <img src="<?php echo htmlspecialchars($blog['image']); ?>" class="blog-img" alt="Blog image">
            <div class="blog-content-preview">
              <div class="blog-date"><?php echo date('M d, Y', strtotime($blog['date'])); ?> &mdash; <?php echo htmlspecialchars($blog['author']); ?></div>
              <div class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></div>
              <div class="blog-excerpt"><?php echo htmlspecialchars(strip_tags($blog['content'])); ?></div>
            </div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  
  <?php if (isAdmin()): ?>
    <!-- Floating Action Button for Admin -->
    <button id="add-blog-btn" class="admin-btn">+</button>
    
    <!-- Create Blog Modal -->
    <div id="blog-modal" class="blog-modal">
    <div class="blog-modal-content">
      <button id="close-modal-btn" type="button" style="position: absolute; right: 16px; top: 16px; background: none; border: none; color: #fff; font-size: 24px; cursor: pointer;">&times;</button>
      <h2 style="font-family: var(--font-nuqun); color: #fff; margin-bottom: 24px; letter-spacing: 0.1em;">NEW ARTICLE</h2>
      
      <form action="blog_action.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        
        <div class="form-group">
          <label>TITLE</label>
          <input type="text" name="title" required>
        </div>
        
        <div class="form-group">
          <label>UPLOAD IMAGE</label>
          <input type="file" name="image_file" accept="image/*" style="color: var(--zinc-400);">
        </div>
        
        <div class="form-group">
          <label>OR IMAGE PATH (e.g. bg/menubg1.jpg)</label>
          <input type="text" name="image" value="">
        </div>
        
        <div class="form-group">
          <label>CONTENT</label>
          <textarea name="content" rows="8" required></textarea>
        </div>
        
        <button type="submit" class="luxury-btn" style="width: 100%; border: 1px solid #fff;">PUBLISH</button>
      </form>
    </div>
  </div>

  <script>
    const modal = document.getElementById('blog-modal');
    document.getElementById('add-blog-btn').addEventListener('click', () => modal.classList.add('open'));
    document.getElementById('close-modal-btn').addEventListener('click', () => modal.classList.remove('open'));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('open');
    });
  </script>
  <?php endif; ?>

  <!-- Collections bottom bar -->
  <div class="bottom-bar">
    <a href="collections.php">COLLECTIONS</a>
    <span class="bottom-bar-decor">RAWCODE A/W 2026</span>
  </div>

</body>
</html>
