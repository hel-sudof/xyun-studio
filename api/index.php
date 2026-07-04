<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | HOME</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Fullscreen non-stretched background */
    .home-bg-container {
      position: absolute;
      inset: 0;
      z-index: 0;
      overflow: hidden;
      background-color: #000000;
    }
    @keyframes panBg {
      0%, 100% { background-position: center top; }
      50% { background-position: center bottom; }
    }

    .home-bg {
      width: 100%;
      height: 100%;
      background-image: url('bg/homebg.png');
      background-size: cover;
      background-position: center top;
      background-repeat: no-repeat;
      filter: brightness(0.55);
      animation: panBg 30s ease-in-out infinite;
    }
    
    .home-overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.3);
      z-index: 1;
    }
    
    /* Absolute center using Flexbox */
    .home-center-wrapper {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10;
      pointer-events: none;
      padding: 0 24px;
    }
    
    @keyframes logoBreathe {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.04); }
    }
    
    .home-center-wrapper img {
      width: 100%;
      max-width: 640px;
      height: auto;
      object-fit: contain;
      filter: drop-shadow(0 15px 30px rgba(0,0,0,0.8));
    }
  </style>
</head>
<body>
  
  <?php include 'header.php'; ?>

  <!-- Guaranteed Absolute Centered Logo -->
  <div class="home-center-wrapper animate-fade-in">
    <img src="logo.png" alt="XYÚN STUDIO Logo">
  </div>

  <div class="page-container">
    <!-- Darkened, non-stretching background -->
    <div class="home-bg-container">
      <div class="home-bg"></div>
      <div class="home-overlay"></div>
    </div>

    <!-- Fixed bottom bar footer -->
    <div class="bottom-bar">
      <span class="bottom-bar-decor">RAWCODE A/W 2026</span>
    </div>
  </div>

</body>
</html>
