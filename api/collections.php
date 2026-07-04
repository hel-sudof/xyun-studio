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

      <!-- Search Bar -->
      <div class="col-search-wrapper">
        <div class="col-search-inner">
          <div class="col-search-field">
            <svg class="col-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"/>
              <path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" id="col-search-input" class="col-search-input" placeholder="SEARCH STYLE OR CODE..." autocomplete="off">
          </div>
          <div id="col-search-results-dropdown" class="col-search-dropdown"></div>
        </div>
      </div>

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
    
    /* Collections Search Bar - matching blog search style */
    .col-search-wrapper {
      max-width: 1200px;
      margin: 0 auto 24px auto;
      padding: 0 24px;
      position: relative;
      z-index: 10;
    }
    .col-search-inner {
      position: relative;
      width: 100%;
    }
    .col-search-field {
      position: relative;
    }
    .col-search-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      opacity: 0.5;
      pointer-events: none;
      color: #fff;
      z-index: 2;
    }
    .col-search-input {
      width: 100%;
      padding: 16px 20px 16px 48px;
      background-color: rgba(0, 0, 0, 0.8);
      border: 1px solid var(--zinc-600);
      color: #fff;
      font-family: var(--font-zalando-sans);
      font-size: 13px;
      letter-spacing: 0.05em;
      outline: none;
      box-sizing: border-box;
      transition: border-color 0.3s, box-shadow 0.3s;
      backdrop-filter: blur(4px);
    }
    .col-search-input:focus {
      border-color: #ffffff;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.08);
    }
    .col-search-input::placeholder {
      color: var(--zinc-500);
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    .col-search-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background-color: #000;
      border: 1px solid var(--zinc-800);
      border-top: none;
      z-index: 30;
      max-height: 400px;
      overflow-y: auto;
    }
  </style>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('col-search-input');
    const searchDropdown = document.getElementById('col-search-results-dropdown');

    const productsData = [
      { id: "01", name: "DESIGN 01", collection: "RAWCODE", items: ["HIGH NECK TOP (RC/T-005)", "BAGGY JEANS (RC/P-003)"], desc: "A striking combination of high-collar structuring and loose utility jeans featuring detailed hand-painted metallic coatings." },
      { id: "02", name: "DESIGN 02", collection: "RAWCODE", items: ["OFF SHOULDER TOP (RC/T-002)", "RUFFLE SKIRT (RC/S-001)"], desc: "An asymmetric silhouette pairing a soft, structured off-shoulder drape with a heavy-weight raw edge ruffle denim skirt." },
      { id: "03", name: "DESIGN 03", collection: "RAWCODE", items: ["HIGH NECK TOP (RC/T-003)", "BAGGY JEANS (RC/P-002)"], desc: "The core piece of the RAWCODE collection, featuring hand-manipulated foil coatings and metallic distressing across high-neck styling." },
      { id: "04", name: "DESIGN 04", collection: "RAWCODE", items: ["HIGH NECK TOP (RC/T-005)", "CROPPED OUTER (RC/O-001)", "MINI SKIRT (RC/S-002)"], desc: "A three-piece industrial look combining high-necked layering, premium cropped distressed leather outer, and a raw-hem denim mini skirt." },
      { id: "05", name: "DESIGN 05", collection: "RAWCODE", items: ["DOUBLE VEST (RC/T-001)", "BAGGY JEANS (RC/P-001)"], desc: "Structured double-layer vest vestments featuring technical buckle systems paired with relaxed raw-cut denim denim trousers." }
    ];

    const popularSearchesHTML = `
      <div style="padding: 12px 12px 8px 12px; font-size: 10px; color: var(--zinc-500); text-align: left; text-transform: uppercase; font-family: var(--font-nuqun); border-bottom: 1px solid var(--zinc-900);">Popular Searches</div>
      <a href="subpage.php?id=03" style="display: block; padding: 12px; text-decoration: none; border-bottom: 1px solid var(--zinc-900); color: inherit;">
        <div style="font-size: 9px; color: var(--zinc-500); margin-bottom: 4px;">DESIGN 03 / RAWCODE</div>
        <div style="font-size: 14px; color: #fff; margin-bottom: 4px;">DESIGN 03</div>
        <div style="font-size: 10px; color: var(--zinc-400);">The core piece of the RAWCODE collection...</div>
      </a>
      <a href="subpage.php?id=05" style="display: block; padding: 12px; text-decoration: none; border-bottom: 1px solid var(--zinc-900); color: inherit;">
        <div style="font-size: 9px; color: var(--zinc-500); margin-bottom: 4px;">DESIGN 05 / RAWCODE</div>
        <div style="font-size: 14px; color: #fff; margin-bottom: 4px;">DESIGN 05</div>
        <div style="font-size: 10px; color: var(--zinc-400);">Structured double-layer vest vestments...</div>
      </a>
    `;

    const showPopularSearches = () => {
      searchDropdown.innerHTML = popularSearchesHTML;
      searchDropdown.style.display = 'block';
    };

    // Show popular searches on focus
    searchInput.addEventListener('focus', () => {
      if (searchInput.value.trim() === '') showPopularSearches();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      const wrapper = document.querySelector('.col-search-wrapper');
      if (!wrapper.contains(e.target)) {
        searchDropdown.style.display = 'none';
      }
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') searchDropdown.style.display = 'none';
    });

    // Show popular when clicking the input
    searchInput.addEventListener('click', (e) => {
      e.stopPropagation();
      if (searchInput.value.trim() === '') showPopularSearches();
    });

    // Filter on input
    searchInput.addEventListener('input', (e) => {
      const query = e.target.value.trim().toLowerCase();
      if (query === '') { showPopularSearches(); return; }
      const filtered = productsData.filter(p => {
        return p.name.toLowerCase().includes(query) || p.desc.toLowerCase().includes(query) || p.id.includes(query) || p.items.some(item => item.toLowerCase().includes(query));
      });
      if (filtered.length === 0) {
        searchDropdown.innerHTML = '<div style="padding: 12px; font-size: 10px; color: var(--zinc-600); text-align: center; text-transform: uppercase;">No matches found</div>';
        searchDropdown.style.display = 'block'; return;
      }
      searchDropdown.innerHTML = filtered.map(p => `
        <a href="subpage.php?id=${p.id}" style="display: block; padding: 12px; text-decoration: none; border-bottom: 1px solid var(--zinc-900); color: inherit;">
          <div style="font-size: 9px; color: var(--zinc-500); margin-bottom: 4px;">DESIGN ${p.id} / ${p.collection}</div>
          <div style="font-size: 14px; color: #fff; margin-bottom: 4px;">${p.name}</div>
          <div style="font-size: 10px; color: var(--zinc-400);">${p.desc}</div>
        </a>
      `).join('');
      searchDropdown.style.display = 'block';
    });
  });
  </script>

</body>
</html>
