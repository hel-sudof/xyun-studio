<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | MENU</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Force single screen view */
    body {
      height: 100vh;
      overflow: hidden;
    }
    
    .menu-layout {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      flex-grow: 1;
      align-items: center;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      height: calc(100vh - 120px); /* Fill screen space between header and footer */
      padding: 0;
    }
    
    @media (min-width: 1024px) {
      .menu-layout {
        grid-template-columns: 5fr 7fr;
        gap: 60px;
      }
    }
    
    /* Image container matching screen height */
    .menu-image-container {
      width: 100%;
      height: 40vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      margin: 0;
      overflow: hidden;
    }
    
    @media (min-width: 1024px) {
      .menu-image-container {
        height: 100%; /* Takes full container height without scrolling */
      }
    }
    
    .menu-image-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: contain; 
      object-position: center;
      opacity: 0;
      animation: slideshow 12s infinite;
    }
    .slide-1 { animation-delay: 0s; }
    .slide-2 { animation-delay: 4s; }
    .slide-3 { animation-delay: 8s; }

    @keyframes slideshow {
      0% { opacity: 0; }
      10% { opacity: 1; }
      33% { opacity: 1; }
      43% { opacity: 0; }
      100% { opacity: 0; }
    }
    
    .menu-text-container {
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: flex-start; 
      align-items: center;
      text-align: center;
      height: 25vh;
      padding: 20px 0;
    }
    
    @media (min-width: 1024px) {
      .menu-text-container {
        height: 100%;
        padding: 120px 0 40px 40px;
      }
    }
    
    .menu-meta {
      font-family: var(--font-nuqun);
      text-transform: uppercase;
      /* REVISION: Reduced letter spacing and line height */
      letter-spacing: 0.1em;
      color: var(--zinc-500);
      line-height: 1.4;
    }
    
    .menu-meta-title {
      font-size: 16px;
      color: #ffffff;
      margin-bottom: 8px;
      /* REVISION: Removed bold font-weight */
      font-weight: normal; 
    }
    
    /* REVISION: Logo image at the bottom right instead of text */
    .menu-logo-bottom {
      position: absolute;
      bottom: 24px;
      right: 24px;
      width: 450px;
      max-width: 90%;
      opacity: 0.9;
    }
    
    .menu-logo-bottom img {
      width: 100%;
      height: auto;
      object-fit: contain;
    }
    
    @media (max-width: 1023px) {
      .menu-logo-bottom {
        width: 150px;
        bottom: 20px;
      }
    }
  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="page-container" style="padding-left: 48px; padding-right: 48px;">
    <!-- Main content split layout -->
    <div class="menu-layout animate-fade-in">
      
      <!-- Left Column - Image (no crop, no grayscale) -->
      <div class="menu-image-container">
        <div class="menu-image-wrapper">
          <img src="bg/menubg1.jpg" alt="Showcase AW26" class="slide slide-1">
          <img src="bg/menubg2.jpg" alt="Showcase AW26" class="slide slide-2">
          <img src="bg/menubg3.jpg" alt="Showcase AW26" class="slide slide-3">
        </div>
      </div>

      <!-- Right Column - Typography & Logo -->
      <div class="menu-text-container">
        <!-- Centered text -->
        <div class="menu-meta">
          <div class="menu-meta-title">"RAWCODE"</div>
          <div style="font-size: 12px; letter-spacing: 0.15em;">AUTUMN/WINTER</div>
          <div style="font-size: 12px; letter-spacing: 0.15em;">2026 COLLECTION</div>
        </div>

        <!-- Logo menu at bottom right -->
        <div class="menu-logo-bottom">
          <img src="logomenu.png" alt="XYÚN STUDIO Logo">
        </div>
      </div>

    </div>

    <!-- Fixed Bottom Bar Footer -->
    <div class="bottom-bar">
      <a href="collections.php">COLLECTIONS</a>
      <span class="bottom-bar-decor">EST. 2024 SURABAYA</span>
    </div>
  </div>

</body>
</html>
