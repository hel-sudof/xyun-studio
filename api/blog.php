<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

try {
    $blogs = dbFetchAll("SELECT * FROM blogs ORDER BY date DESC, created_at DESC");
} catch (Exception $e) {
    $blogs = [];
}

// Sample blog that always appears (plus user-uploaded blogs from DB)
$sampleBlog = [
    'id' => 'sample-1',
    'title' => 'BEHIND THE SCENES: RAWCODE COLLECTION',
    'image' => 'bg/menubg1.jpg',
    'content' => 'Exploring the industrial roots of our Autumn/Winter 2026 collection. The RAWCODE collection was born out of a desire to merge raw, unfinished materials with highly structured silhouettes. From heavy-weight denim to synthetic leather panelling, every piece is designed to tell a story of urban resilience.

Our design process involved hundreds of hours of hand-manipulated fabric distressing, foil coating applications, and testing various metal hardware components to ensure durability and aesthetic perfection.

We believe that clothing is not just fabric, but armor for the modern world. <3',
    'date' => '2026-07-01',
    'author' => 'xyún admin'
];

// Prepend sample blog to the list (user blogs come after)
array_unshift($blogs, $sampleBlog);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | BLOG</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
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
      max-height: 85vh;
      padding: 32px;
      position: relative;
      overflow-y: auto;
      overscroll-behavior: contain;
    }
    /* Crop modal needs more width */
    .blog-modal-content.crop-content {
      max-width: 700px;
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
    .blog-search-field {
      position: relative;
    }
    .blog-search-icon {
      position: absolute;
      left: 16px;
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

  <?php if (isset($_SESSION['flash_msg'])): ?>
    <div style="position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 9999; background: #cc3333; color: #fff; padding: 14px 28px; font-size: 12px; letter-spacing: 0.05em; text-transform: uppercase; font-family: var(--font-zalando-sans);">
      <?php echo htmlspecialchars($_SESSION['flash_msg']); ?>
    </div>
    <?php unset($_SESSION['flash_msg']); ?>
  <?php endif; ?>

  <div class="page-container animate-fade-in">
    <div class="page-header">
      <h1 class="page-title">EDITORIAL</h1>
      <div class="page-subtitle">STORIES, INSPIRATION, AND BEHIND THE SCENES</div>
    </div>
    
    <!-- Blog Search Bar -->
    <div class="blog-search-wrapper">
      <div class="blog-search-field">
        <svg class="blog-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="blog-search-input" class="blog-search-input" placeholder="SEARCH ARTICLES..." autocomplete="off">
      </div>
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
          <input type="file" id="blog-image-input" name="image_file" accept="image/*" style="color: var(--zinc-400);">
          <div id="crop-preview" style="display:none; margin-top:12px; position:relative;">
            <img id="crop-preview-img" style="max-width:100%; max-height:200px; object-fit:contain; border:1px solid var(--zinc-800);">
            <button id="crop-repick-btn" type="button" style="position:absolute; top:4px; right:4px; background:#000; border:1px solid var(--zinc-600); color:#fff; padding:4px 10px; font-size:10px; cursor:pointer; letter-spacing:0.05em;">REPLACE</button>
          </div>
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

  <!-- Crop Modal -->
  <div id="crop-modal" class="blog-modal">
    <div class="blog-modal-content crop-content">
      <button id="crop-modal-close-btn" type="button" style="position: absolute; right: 16px; top: 16px; background: none; border: none; color: #fff; font-size: 24px; cursor: pointer; z-index:10;">&times;</button>
      <h2 style="font-family: var(--font-nuqun); color: #fff; margin-bottom: 16px; letter-spacing: 0.1em;">CROP IMAGE</h2>
      <div style="max-height:55vh; overflow:hidden; background:#111; margin-bottom:16px;">
        <img id="crop-image" src="" style="max-width:100%;">
      </div>
      <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:center; margin-bottom:16px;">
        <button id="crop-zoom-in" type="button" style="background:#000; border:1px solid var(--zinc-600); color:#fff; padding:8px 16px; cursor:pointer; font-size:12px;">ZOOM +</button>
        <button id="crop-zoom-out" type="button" style="background:#000; border:1px solid var(--zinc-600); color:#fff; padding:8px 16px; cursor:pointer; font-size:12px;">ZOOM -</button>
        <button id="crop-rotate" type="button" style="background:#000; border:1px solid var(--zinc-600); color:#fff; padding:8px 16px; cursor:pointer; font-size:12px;">ROTATE</button>
        <button id="crop-flip" type="button" style="background:#000; border:1px solid var(--zinc-600); color:#fff; padding:8px 16px; cursor:pointer; font-size:12px;">FLIP H</button>
        <button id="crop-reset" type="button" style="background:#000; border:1px solid var(--zinc-600); color:#fff; padding:8px 16px; cursor:pointer; font-size:12px;">RESET</button>
      </div>
      <button id="crop-apply-btn" type="button" class="luxury-btn" style="width:100%; border:1px solid #fff;">APPLY CROP</button>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('blog-image-input');
    const cropPreview = document.getElementById('crop-preview');
    const cropPreviewImg = document.getElementById('crop-preview-img');
    const repickBtn = document.getElementById('crop-repick-btn');
    const cropModal = document.getElementById('crop-modal');
    const cropModalClose = document.getElementById('crop-modal-close-btn');
    const cropImage = document.getElementById('crop-image');
    const cropApply = document.getElementById('crop-apply-btn');
    const zoomIn = document.getElementById('crop-zoom-in');
    const zoomOut = document.getElementById('crop-zoom-out');
    const rotateBtn = document.getElementById('crop-rotate');
    const flipBtn = document.getElementById('crop-flip');
    const resetBtn = document.getElementById('crop-reset');

    let cropper = null;
    let currentFile = null;
    let croppedBlob = null;

    function openCropModal(file) {
      currentFile = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        cropImage.src = e.target.result;
        cropModal.classList.add('open');
        setTimeout(() => {
          if (cropper) cropper.destroy();
          cropper = new Cropper(cropImage, {
            aspectRatio: NaN,
            viewMode: 1,
            autoCropArea: 0.9,
            background: false,
          });
        }, 300);
      };
      reader.readAsDataURL(file);
    }

    fileInput.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (!file) return;
      // Reject files > 5MB immediately
      if (file.size > 5 * 1024 * 1024) {
        alert('File too large. Max 5MB.');
        fileInput.value = '';
        return;
      }
      openCropModal(file);
    });

    repickBtn.addEventListener('click', () => {
      fileInput.click();
    });

    cropApply.addEventListener('click', () => {
      if (!cropper) return;
      const canvas = cropper.getCroppedCanvas({ width: 1200 });
      canvas.toBlob((blob) => {
        croppedBlob = blob;
        // Show preview
        const url = URL.createObjectURL(blob);
        cropPreviewImg.src = url;
        cropPreview.style.display = 'block';
        // Close modal
        cropModal.classList.remove('open');
        if (cropper) { cropper.destroy(); cropper = null; }
        // Replace file input with cropped version via DataTransfer
        const newFile = new File([blob], currentFile.name, { type: 'image/png' });
        const dt = new DataTransfer();
        dt.items.add(newFile);
        fileInput.files = dt.files;
      }, 'image/png', 0.92);
    });

    cropModalClose.addEventListener('click', () => {
      cropModal.classList.remove('open');
      if (cropper) { cropper.destroy(); cropper = null; }
      fileInput.value = '';
      cropPreview.style.display = 'none';
    });

    cropModal.addEventListener('click', (e) => {
      if (e.target === cropModal) {
        cropModal.classList.remove('open');
        if (cropper) { cropper.destroy(); cropper = null; }
        fileInput.value = '';
        cropPreview.style.display = 'none';
      }
    });

    zoomIn.addEventListener('click', () => cropper?.zoom(0.1));
    zoomOut.addEventListener('click', () => cropper?.zoom(-0.1));
    rotateBtn.addEventListener('click', () => cropper?.rotate(90));
    flipBtn.addEventListener('click', () => cropper?.scaleX(-(cropper.getData().scaleX || 1)));
    resetBtn.addEventListener('click', () => cropper?.reset());
  });
  </script>
  <?php endif; ?>

  <!-- Bottom bar -->
  <div class="bottom-bar">
    <span class="bottom-bar-decor">RAWCODE A/W 2026</span>
  </div>

</body>
</html>
