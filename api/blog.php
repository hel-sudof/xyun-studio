<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

try {
    $blogs = dbFetchAll("SELECT * FROM blogs ORDER BY date DESC, created_at DESC");
} catch (Exception $e) {
    $blogs = [];
}

// Fallback to JSON if database is empty
if (empty($blogs)) {
    $jsonFile = realpath(__DIR__ . '/../data/blogs.json');
    if ($jsonFile && file_exists($jsonFile)) {
        $jsonData = json_decode(file_get_contents($jsonFile), true);
        if (is_array($jsonData)) {
            $blogs = $jsonData;
        }
    }
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
    
    /* Blog Search Bar */
    .blog-search-wrapper {
      max-width: 1200px;
      margin: 0 auto;
      padding: 24px 48px 0 48px;
      position: relative;
    }
    .blog-search-icon {
      position: absolute;
      left: 60px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 2;
      width: 16px;
      height: 16px;
      opacity: 0.5;
      pointer-events: none;
      color: #fff;
    }
    .blog-search-input {
      width: 100%;
      padding: 16px 20px 16px 48px;
      background-color: rgba(0, 0, 0, 0.8);
      border: 1px solid var(--zinc-600);
      color: #fff;
      font-family: var(--font-zalando-sans);
      font-size: 13px;
      letter-spacing: 0.05em;
      outline: none;
      transition: border-color 0.3s, box-shadow 0.3s;
      box-sizing: border-box;
      backdrop-filter: blur(4px);
    }
    .blog-search-input:focus {
      border-color: #ffffff;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.08);
    }
    .blog-search-input::placeholder {
      color: var(--zinc-500);
      text-transform: uppercase;
      letter-spacing: 0.1em;
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
    
    <!-- Blog Search Bar -->
    <div class="blog-search-wrapper">
      <svg class="blog-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/>
        <path d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" id="blog-search-input" class="blog-search-input" placeholder="SEARCH ARTICLES..." autocomplete="off">
    </div>
    
    <div class="blog-grid" id="blog-grid">
      <?php if(empty($blogs)): ?>
        <p id="blog-empty-msg" style="color: var(--zinc-500); grid-column: 1 / -1; text-align: center;">No articles available at the moment.</p>
      <?php else: ?>
        <?php foreach($blogs as $blog): ?>
          <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="blog-card" data-title="<?php echo htmlspecialchars(strtolower($blog['title'])); ?>" data-content="<?php echo htmlspecialchars(strtolower(strip_tags($blog['content']))); ?>">
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

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('blog-search-input');
    const blogCards = document.querySelectorAll('.blog-card');
    const emptyMsg = document.getElementById('blog-empty-msg');

    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim().toLowerCase();
        let visibleCount = 0;

        blogCards.forEach(card => {
          const title = card.getAttribute('data-title') || '';
          const content = card.getAttribute('data-content') || '';
          if (query === '' || title.includes(query) || content.includes(query)) {
            card.style.display = '';
            visibleCount++;
          } else {
            card.style.display = 'none';
          }
        });

        if (emptyMsg) {
          emptyMsg.style.display = (visibleCount === 0) ? '' : 'none';
          if (visibleCount === 0) emptyMsg.textContent = 'No articles match your search.';
        }
      });
    }
  });
  </script>
  
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

  <!-- Bottom bar -->
  <div class="bottom-bar">
    <span class="bottom-bar-decor">RAWCODE A/W 2026</span>
  </div>

</body>
</html>
