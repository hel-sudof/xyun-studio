<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | COLLECTIONS</title>
  <link rel="stylesheet" href="style.css">
  
  <!-- Preload high-res catalogue images -->
  <link rel="preload" href="bg/fit1.png" as="image">
  <link rel="preload" href="bg/fit2.png" as="image">
  <link rel="preload" href="bg/fit3.png" as="image">
  <link rel="preload" href="bg/fit4.png" as="image">
  <link rel="preload" href="bg/fit5.png" as="image">
  
  <style>
    /* Scroll snap container */
    .snap-container {
      height: 100vh;
      overflow-y: scroll;
      scroll-snap-type: y mandatory;
      scroll-behavior: smooth;
    }
    
    .snap-section {
      min-height: 100vh;
      width: 100%;
      scroll-snap-align: start;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 96px 48px 80px 48px; /* increased bottom padding to avoid footer overlap */
    }
    
    .snap-section .bottom-bar {
      position: absolute;
      bottom: 0;
      left: 0;
    }
    
    @keyframes panBg {
      0%, 100% { background-position: center 0%; }
      50% { background-position: center 30%; }
    }

    /* SECTION 1 - Editorial */
    .section-1-bg {
      position: absolute;
      inset: 0;
      z-index: 0;
      background-image: url('bg/collectionbg.png'); /* REVISION: Use correct background image */
      background-size: cover;
      background-position: center 0%;
      background-repeat: no-repeat;
      filter: brightness(0.9);
      animation: panBg 25s ease-in-out infinite;
    }
    .section-1-overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.15);
      z-index: 1;
    }
    
    .sec-1-content {
      position: relative;
      z-index: 10;
      margin: auto;
      max-width: 340px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-top: 8vh;
    }
    
    .sec-1-title {
      font-family: var(--font-nuqun);
      font-size: 48px;
      font-weight: 700;
      letter-spacing: 0.25em;
      color: #ffffff;
      margin-bottom: 24px;
      text-shadow: 0 10px 20px rgba(0,0,0,0.8);
      text-transform: uppercase;
    }
    
    @media (min-width: 768px) {
      .sec-1-title {
        font-size: 64px;
      }
    }
    
    .sec-1-desc-box {
      background-color: #ffffff;
      color: #000000;
      padding: 32px;
      border: 1px solid #e4e4e7;
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
      text-align: justify;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.05em;
      line-height: 1.6;
      font-weight: 500;
    }
    
    /* SECTION 2 - Catalogue */
    .sec-2-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 24px;
      margin: auto;
      width: 100%;
      max-width: 1200px;
      padding: 24px 0;
    }
    
    @media (min-width: 768px) {
      .sec-2-grid {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
      }
    }
    
    @media (min-width: 1024px) {
      .sec-2-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 48px 32px;
      }
    }
    
    /* POP OUT CARD TRANSITION - Scales up entire card (box and text) */
    .design-card {
      display: flex;
      gap: 20px;
      align-items: flex-start;
      transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
      cursor: pointer;
    }
    
    .design-card:hover {
      transform: scale(1.08) translateY(-4px); /* Entire card pops out slightly */
    }
    
    .design-box-link {
      height: 200px;
      width: auto;
      aspect-ratio: 5 / 7;
      background-color: rgba(9, 9, 11, 0.9);
      border: 1px solid var(--zinc-800);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      position: relative;
      flex-shrink: 0;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      transition: border-color 0.4s ease, background-color 0.4s ease;
      overflow: hidden;
    }
    
    .design-box-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 1;
      opacity: 0.8;
      transition: opacity 0.4s ease, transform 0.4s ease;
    }
    
    .design-card:hover .design-box-img {
      opacity: 1;
      transform: scale(1.05);
    }
    
    /* Fix crop line on fit2 */
    #img-fit2 {
      transform: scale(1.02);
    }
    .design-card:hover #img-fit2 {
      transform: scale(1.07);
    }
    
    .design-card:hover .design-box-link {
      background-color: rgba(24, 24, 27, 0.95);
    }
    
    .design-box-corner {
      position: absolute;
      bottom: 6px;
      right: 6px;
      width: 6px;
      height: 6px;
      border-right: 1px solid var(--zinc-800);
      border-bottom: 1px solid var(--zinc-800);
      transition: border-color 0.3s;
    }
    
    .design-card:hover .design-box-corner {
      border-color: var(--zinc-500);
    }
    
    .design-details {
      font-size: 14px;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      line-height: 1.6;
    }
    
    .design-details-num {
      font-family: var(--font-nuqun);
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 16px;
      display: block;
      color: #ffffff;
      transition: color 0.3s;
    }
    
    .design-card:hover .design-details-num {
      color: #ffffff;
    }
    
    .design-details p {
      margin-bottom: 12px;
    }
    
    .design-details-code {
      font-family: monospace;
      font-size: 12px;
      color: var(--zinc-500);
      display: block;
      margin-top: 4px;
    }
    
    .sec-2-catalogue-info {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 16px 0;
      text-align: right;
    }
    
    @media (max-width: 767px) {
      .sec-2-catalogue-info {
        text-align: left;
      }
    }
    
    .catalogue-title {
      font-family: var(--font-nuqun);
      font-size: 28px;
      font-weight: 700;
      letter-spacing: 0.25em;
      color: #ffffff;
      margin-bottom: 16px;
      text-transform: uppercase;
    }
    
    .catalogue-meta {
      font-family: var(--font-nuqun);
      font-size: 11px;
      letter-spacing: 0.2em;
      color: var(--zinc-500);
      line-height: 1.6;
      text-transform: uppercase;
    }
  </style>
</head>
<body>

  <!-- Scroll container -->
  <div class="snap-container">
    
    <!-- ----------------- SECTION 1 (TOP) ----------------- -->
    <section class="snap-section">
      <?php include 'header.php'; ?>

      <!-- Background images -->
      <div class="section-1-bg"></div>
      <div class="section-1-overlay"></div>

      <!-- Main center block -->
      <div class="sec-1-content animate-fade-in">
        <h2 class="sec-1-title">RAWCODE</h2>
        <div class="sec-1-desc-box">
          PORTRAYS HUMAN CREATION AS A SYSTEM BUILT ON INSTINCT RATHER THAN
          AUTOMATION. THE COLLECTION VIEWS DESIGN AS A TYPE OF "CODING" DONE BY
          HAND, INVOLVING EMOTION, IMPERFECTION, AND INTUITIVE DECISION MAKING.
        </div>
      </div>

      <!-- Fixed bottom bar footer in section 1 -->
      <div class="bottom-bar">
        <a href="index.php">BACK</a>
        <span style="color: var(--zinc-400); font-family: var(--font-zalando-sans); letter-spacing: 0.1em; animation: bounce 2s infinite;">SCROLL DOWN ↓</span>
      </div>
    </section>

    <!-- ----------------- SECTION 2 (BOTTOM) ----------------- -->
    <section id="catalogue" class="snap-section" style="background-color: var(--background);">
      <!-- Spacing -->
      <div></div>

      <!-- Catalogue items grid -->
      <div class="sec-2-grid">
        
        <!-- Design 01 -->
        <div class="design-card" onclick="window.navigateTo('subpage.php?id=01')">
          <div class="design-box-link">
            <img src="bg/fit1.png" class="design-box-img">
          </div>
          <div class="design-details">
            <span class="design-details-num">01</span>
            <p>
              <strong style="color: var(--zinc-200);">HIGH NECK TOP</strong>
              <span class="design-details-code">RC/T-005</span>
            </p>
            <p>
              <strong style="color: var(--zinc-200);">BAGGY JEANS</strong>
              <span class="design-details-code">RC/P-003</span>
            </p>
          </div>
        </div>

        <!-- Design 02 -->
        <div class="design-card" onclick="window.navigateTo('subpage.php?id=02')">
          <div class="design-box-link">
            <img src="bg/fit2.png" class="design-box-img" id="img-fit2">
          </div>
          <div class="design-details">
            <span class="design-details-num">02</span>
            <p>
              <strong style="color: var(--zinc-200);">OFF SHOULDER TOP</strong>
              <span class="design-details-code">RC/T-002</span>
            </p>
            <p>
              <strong style="color: var(--zinc-200);">RUFFLE SKIRT</strong>
              <span class="design-details-code">RC/S-001</span>
            </p>
          </div>
        </div>

        <!-- Design 03 -->
        <div class="design-card" onclick="window.navigateTo('subpage.php?id=03')">
          <div class="design-box-link">
            <img src="bg/fit3.png" class="design-box-img">
          </div>
          <div class="design-details">
            <span class="design-details-num">03</span>
            <p>
              <strong style="color: var(--zinc-200);">HIGH NECK TOP</strong>
              <span class="design-details-code">RC/T-003</span>
            </p>
            <p>
              <strong style="color: var(--zinc-200);">BAGGY JEANS</strong>
              <span class="design-details-code">RC/P-002</span>
            </p>
          </div>
        </div>

        <!-- Design 04 -->
        <div class="design-card" onclick="window.navigateTo('subpage.php?id=04')">
          <div class="design-box-link">
            <img src="bg/fit4.png" class="design-box-img">
          </div>
          <div class="design-details">
            <span class="design-details-num">04</span>
            <p>
              <strong style="color: var(--zinc-200);">HIGH NECK TOP</strong>
              <span class="design-details-code">RC/T-005</span>
            </p>
            <p>
              <strong style="color: var(--zinc-200);">CROPPED OUTER</strong>
              <span class="design-details-code">RC/O-001</span>
            </p>
            <p>
              <strong style="color: var(--zinc-200);">MINI SKIRT</strong>
              <span class="design-details-code">RC/S-002</span>
            </p>
          </div>
        </div>

        <!-- Design 05 -->
        <div class="design-card" onclick="window.navigateTo('subpage.php?id=05')">
          <div class="design-box-link">
            <img src="bg/fit5.png" class="design-box-img">
          </div>
          <div class="design-details">
            <span class="design-details-num">05</span>
            <p>
              <strong style="color: var(--zinc-200);">DOUBLE VEST</strong>
              <span class="design-details-code">RC/T-001</span>
            </p>
            <p>
              <strong style="color: var(--zinc-200);">BAGGY JEANS</strong>
              <span class="design-details-code">RC/P-001</span>
            </p>
          </div>
        </div>

        <!-- Catalogue label column -->
        <div class="sec-2-catalogue-info">
          <h3 class="catalogue-title">CATALOGUE</h3>
          <div class="catalogue-meta">
            <p style="color: var(--zinc-300);">"RAWCODE"</p>
            <p>AUTUMN/WINTER</p>
            <p>2026 COLLECTION</p>
          </div>
        </div>

      </div>

      <!-- Fixed bottom bar footer in section 2 -->
      <div class="bottom-bar">
        <a href="index.php">BACK</a>
        <span class="bottom-bar-decor">XYÚN STUDIO © 2026</span>
      </div>
    </section>

  </div>

  <style>
    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
  </style>

</body>
</html>
