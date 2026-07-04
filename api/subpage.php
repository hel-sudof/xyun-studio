<?php
require_once __DIR__ . '/auth.php';
$id = isset($_GET['id']) ? $_GET['id'] : '03';

$products = [
  '01' => [
    'name' => '01',
    'collection' => 'RAWCODE',
    'desc' => 'A striking combination of high-collar structuring and loose utility jeans featuring detailed hand-painted metallic coatings.',
    'price' => '3.135.000',
    'items' => [
      ['type' => 'HIGH NECK TOP', 'price' => 'Rp 1.245.000', 'code' => 'RC/T-005', 'color' => 'DARK GRAY', 'material' => 'DENIM'],
      ['type' => 'BAGGY JEANS', 'price' => 'Rp 1.890.000', 'code' => 'RC/P-003', 'color' => 'DARK GRAY', 'material' => 'DENIM & SYNTHETIC LEATHER']
    ]
  ],
  '02' => [
    'name' => '02',
    'collection' => 'RAWCODE',
    'desc' => 'An asymmetric silhouette pairing a soft, structured off-shoulder drape with a heavy-weight raw edge ruffle denim skirt.',
    'price' => '2.190.000',
    'items' => [
      ['type' => 'OFF SHOULDER TOP', 'price' => 'Rp 1.275.000', 'code' => 'RC/T-002', 'color' => 'BLACK', 'material' => 'COTTON'],
      ['type' => 'RUFFLE SKIRT', 'price' => 'Rp 915.000', 'code' => 'RC/S-001', 'color' => 'GRAY & BLACK', 'material' => 'DENIM & CHIFFON']
    ]
  ],
  '03' => [
    'name' => '03',
    'collection' => 'RAWCODE',
    'desc' => 'The core piece of the RAWCODE collection, featuring hand-manipulated foil coatings and metallic distressing across high-neck styling.',
    'price' => '3.300.000',
    'items' => [
      ['type' => 'HIGH NECK TOP', 'price' => 'Rp 1.380.000', 'code' => 'RC/T-003', 'color' => 'BLACK', 'material' => 'DENIM'],
      ['type' => 'BAGGY JEANS', 'price' => 'Rp 1.920.000', 'code' => 'RC/P-002', 'color' => 'BLACK', 'material' => 'DENIM']
    ]
  ],
  '04' => [
    'name' => '04',
    'collection' => 'RAWCODE',
    'desc' => 'A three-piece industrial look combining high-necked layering, premium cropped distressed leather outer, and a raw-hem denim mini skirt.',
    'price' => '3.480.000',
    'items' => [
      ['type' => 'HIGH NECK TOP', 'price' => 'Rp 895.000', 'code' => 'RC/T-004', 'color' => 'GRAY & BLACK', 'material' => 'DENIM & SYNTHETIC LEATHER'],
      ['type' => 'MINI SKIRT', 'price' => 'Rp 1.165.000', 'code' => 'RC/S-002', 'color' => 'BLACK', 'material' => 'COTTON'],
      ['type' => 'CROPPED OUTER', 'price' => 'Rp 1.420.000', 'code' => 'RC/O-001', 'color' => 'BLACK', 'material' => 'COTTON']
    ]
  ],
  '05' => [
    'name' => '05',
    'collection' => 'RAWCODE',
    'desc' => 'A bold double-vest arrangement highlighting experimental material layering, complete with extreme wide-leg jeans.',
    'price' => '2.680.000',
    'items' => [
      ['type' => 'DOUBLE VEST', 'price' => 'Rp 1.010.000', 'code' => 'RC/T-001', 'color' => 'GRAY', 'material' => 'DENIM'],
      ['type' => 'BAGGY JEANS', 'price' => 'Rp 1.670.000', 'code' => 'RC/P-001', 'color' => 'LIGHT GRAY', 'material' => 'DENIM & SYNTHETIC LEATHER']
    ]
  ]
];

if (!isset($products[$id])) {
  $id = '03'; // Fallback
}
$product = $products[$id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | DESIGN <?php echo $product['name']; ?></title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Force single viewport screen fit, no scrolling */
    body {
      height: 100vh;
      overflow: hidden;
    }
    
    .sub-layout {
      display: grid;
      grid-template-columns: 1fr;
      gap: 32px;
      flex-grow: 1;
      align-items: center;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      height: calc(100vh - 120px); /* Fit within viewport */
      padding: 0;
    }
    
    @media (min-width: 1024px) {
      .sub-layout {
        grid-template-columns: 6fr 5fr;
        gap: 80px;
      }
    }
    
    /* Left column dynamic views */
    .view-container {
      width: 100%;
      height: 75vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding-left: 32px;
    }
    
    @media (min-width: 1024px) {
      .view-container {
        height: 100%; /* Fill viewport space entirely */
      }
    }
    
    @media (min-width: 1440px) {
      .sub-layout {
        grid-template-columns: 5fr 5fr;
        gap: 100px;
      }
      .view-container {
        padding-right: 190px;
      }
    }
    
    /* Grid 4 columns (Catalogue 3.1) */
    .catalogue-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: 1fr;
      align-items: stretch;
      gap: 6px;
      width: 100%;
      height: 100%;
      transition: opacity 0.3s ease;
    }
    
    .catalogue-grid .dynamic-box {
      aspect-ratio: 3 / 5;
      overflow: hidden;
    }
    
    .catalogue-grid .dynamic-box img {
      transform: scale(0.88);
      transition: transform 0.5s ease;
    }
    
    /* Grid 3x2 (Details 3.2) */
    .details-grid {
      display: grid;
      grid-template-columns: repeat(3, auto);
      grid-template-rows: repeat(2, minmax(0, 1fr));
      justify-content: center;
      gap: 12px 67px;
      width: 100%;
      height: 100%;
      transition: opacity 0.3s ease;
    }
    
    .dynamic-box {
      background-color: transparent;
      border: none;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      transition: all 0.5s ease;
    }
    
    .details-grid .dynamic-box {
      display: block;
      height: 100%;
      width: auto;
      aspect-ratio: 680 / 1000;
    }
    
    .dynamic-box:hover {
      background-color: transparent;
    }
    
    .dynamic-box-num {
      font-family: var(--font-nuqun);
      font-size: 9px;
      letter-spacing: 0.1em;
      color: var(--zinc-600);
      margin-bottom: 4px;
      transition: color 0.3s;
    }
    
    .dynamic-box:hover .dynamic-box-num {
      color: var(--zinc-350);
    }
    
    .dynamic-box-status {
      font-family: monospace;
      font-size: 6px;
      letter-spacing: 0.05em;
      color: var(--zinc-700);
      text-transform: uppercase;
      text-align: center;
      line-height: 1.3;
    }
    
    .dynamic-box-corner {
      position: absolute;
      bottom: 6px;
      right: 6px;
      width: 6px;
      height: 6px;
      border-right: 1px solid var(--zinc-800);
      border-bottom: 1px solid var(--zinc-800);
      transition: border-color 0.3s;
    }
    
    .dynamic-box:hover .dynamic-box-corner {
      border-color: var(--zinc-500);
    }
    
    /* Right column specs */
    .specs-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: auto;
      padding: 0;
      transition: opacity 0.3s ease;
    }
    
    @media (min-width: 1024px) {
      .specs-container {
        padding: 0;
      }
    }
    
    .specs-header h2 {
      font-family: var(--font-nuqun);
      color: #ffffff;
      text-transform: uppercase;
      transition: opacity 0.3s ease;
      margin: 0;
      text-align: left;
    }
    
    .header-num {
      font-size: 56px;
      line-height: 0.8;
      display: block;
      margin-bottom: -2px;
    }
    
    .header-text {
      font-size: 20px;
      font-family: var(--font-zalando-sans);
      font-weight: 300;
      letter-spacing: 0.3em;
      display: block;
      line-height: 1;
    }
    
    .specs-desc {
      font-size: 11px;
      line-height: 1.6;
      color: var(--zinc-400);
      text-transform: uppercase;
      text-align: justify;
      letter-spacing: 0.05em;
      margin-top: 16px;
      max-width: 420px;
    }
    
    @media (min-width: 768px) {
      .specs-desc {
        font-size: 12px;
      }
    }
    
    .specs-list {
      margin-top: 10px;
      border-top: 1px solid var(--zinc-900);
      padding-top: 10px;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    
    /* Dynamic compact layout for 3+ items to prevent overflow */
    .compact-layout .specs-list {
      gap: 8px;
      padding-top: 8px;
      margin-top: 8px;
    }
    .compact-layout .spec-item-title {
      font-size: 16px;
      margin-bottom: 2px;
    }
    .compact-layout .spec-detail {
      font-size: 12px;
      margin-bottom: 0px;
    }
    .compact-layout .spec-detail-label {
      font-size: 10px;
    }
    .compact-layout .specs-branding {
      font-size: 10px;
      line-height: 1.5;
    }
    .compact-layout .header-num {
      font-size: 48px;
      margin-bottom: -2px;
    }
    .compact-layout .header-text {
      font-size: 16px;
    }
    .compact-layout .specs-bottom {
      margin-top: 16px;
    }
    
    .spec-item {
      font-size: 11px;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }
    
    .spec-item-title {
      font-family: var(--font-zalando-sans);
      font-size: 18px;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 6px;
      letter-spacing: 0.1em;
      display: block;
    }
    
    .spec-detail {
      color: var(--zinc-400);
      margin-bottom: 4px;
      font-size: 15px;
    }
    
    .spec-detail-label {
      font-family: var(--font-nuqun);
      font-size: 11px;
      color: var(--zinc-500);
      font-weight: 700;
      letter-spacing: 0.1em;
      margin-right: 8px;
      display: inline-block;
      width: 90px;
    }
    
    .specs-bottom {
      margin-top: 32px;
    }
    
    .specs-price {
      font-size: 24px;
      font-weight: 550;
      color: #ffffff;
      letter-spacing: 0.05em;
      display: block;
      margin-bottom: 8px;
    }
    
    .specs-branding {
      font-family: var(--font-nuqun);
      font-size: 11px;
      letter-spacing: 0.15em;
      color: var(--zinc-500);
      line-height: 1.5;
      font-weight: 300;
    }
    
    .specs-branding p {
      margin: 2px 0 0 0;
    }
    
    .shop-modal {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      z-index: 1000;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.4s ease;
    }
    
    .shop-modal.open {
      opacity: 1;
      pointer-events: auto;
    }
    
    .shop-modal-content {
      background-color: var(--zinc-950);
      border: 1px solid var(--zinc-800);
      width: 100%;
      max-width: 420px;
      padding: 32px;
      position: relative;
      box-shadow: 0 20px 50px rgba(0,0,0,0.8);
      transform: translateY(20px);
      transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .shop-modal.open .shop-modal-content {
      transform: translateY(0);
    }
    
    .shop-modal-close {
      position: absolute;
      top: 16px;
      right: 16px;
      background: none;
      border: none;
      color: var(--zinc-500);
      font-size: 24px;
      cursor: pointer;
      line-height: 1;
      padding: 4px 8px;
    }
    
    .shop-modal-close:hover {
      color: #ffffff;
    }
    
    .shop-form-group {
      margin-bottom: 16px;
      text-align: left;
    }
    
    .shop-form-group label {
      display: block;
      font-family: var(--font-nuqun);
      font-size: 8px;
      letter-spacing: 0.1em;
      color: var(--zinc-400);
      margin-bottom: 6px;
    }
    
    .shop-form-group input, .shop-form-group select, .shop-form-group textarea {
      width: 100%;
      background-color: #000000;
      border: 1px solid var(--zinc-850);
      color: #ffffff;
      padding: 10px 12px;
      font-family: var(--font-zalando-sans);
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      outline: none;
      transition: border-color 0.3s;
    }
    
    .shop-form-group input[type="checkbox"] {
      width: 14px;
      height: 14px;
      padding: 0;
      margin-right: 10px;
      margin-bottom: 0;
      accent-color: var(--zinc-600);
      cursor: pointer;
    }
    
    .checkbox-label {
      display: flex !important;
      align-items: center;
      font-family: var(--font-zalando-sans) !important;
      font-size: 11px !important;
      letter-spacing: 0.05em !important;
      color: #ffffff !important;
      margin-bottom: 0 !important;
      cursor: pointer;
      text-transform: uppercase;
    }
      font-family: var(--font-zalando-sans);
      font-size: 11px;
      outline: none;
      transition: border-color 0.3s;
    }
    
    .shop-form-group input:focus, .shop-form-group select:focus, .shop-form-group textarea:focus {
      border-color: var(--zinc-500);
    }
    
    .shop-submit-btn {
      width: 100%;
      background-color: #ffffff;
      color: #000000;
      border: none;
      padding: 14px;
      font-family: var(--font-nuqun);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.15em;
      cursor: pointer;
      margin-top: 8px;
      text-transform: uppercase;
      transition: background-color 0.3s, color 0.3s;
    }
    
    .shop-submit-btn:hover {
      background-color: #000000;
      color: #ffffff;
    }

    /* PREVIEW MODAL STYLING */
    .preview-modal {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      z-index: 1050;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    .preview-modal.open {
      opacity: 1;
      pointer-events: auto;
    }
    .preview-content {
      display: flex;
      background-color: transparent;
      border: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: visible;
      cursor: zoom-in;
    }
    .preview-content.zoomed {
      cursor: grab;
      overflow: visible;
    }
    .preview-content.zoomed.dragging {
      cursor: grabbing;
    }
    .preview-inner {
      transition: opacity 0.3s ease, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      display: block;
      transform: scale(1);
      opacity: 1;
    }
    .preview-inner img {
      position: relative !important;
      width: auto !important;
      height: 85vh !important;
      max-width: 90vw !important;
      object-fit: contain !important;
      display: block;
      border-radius: 4px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    .preview-inner.fade-out {
      opacity: 0;
    }
    .preview-content.zoomed .preview-inner {
      /* transform controlled by JS */
    }
    .preview-inner .dynamic-box-num {
      font-size: 18px;
    }
    .preview-inner .dynamic-box-status {
      font-size: 14px;
    }
    
    .preview-nav-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      border: 1px solid var(--zinc-700);
      color: #ffffff;
      font-size: 24px;
      padding: 16px 20px;
      cursor: pointer;
      z-index: 1060;
      transition: all 0.3s ease;
    }
    .preview-nav-btn:hover {
      background: #ffffff;
      color: #000000;
      transform: translateY(-50%) scale(1.1);
    }
    #prev-btn { left: 24px; }
    #next-btn { right: 24px; }
    
    .preview-dots-container {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 12px;
      z-index: 1060;
    }
    
    .preview-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: rgba(255,255,255,0.3);
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .preview-dot.active {
      background-color: #ffffff;
      transform: scale(1.4);
    }
  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="page-container" style="padding-left: 48px; padding-right: 48px;">
    
    <!-- Dynamic subpage content layout -->
    <div class="sub-layout animate-fade-in">
      
      <!-- Left Column - Dynamic Photo Boxes Container (fitted to screen) -->
      <div class="view-container">
        
        <!-- Catalogue View (Default) -->
        <div id="view-catalogue" class="catalogue-grid">
          <?php 
          $idNum = (int)$id;
          $bgDir = realpath(__DIR__ . '/../bg') ?: __DIR__ . '/../bg';
          for($i=1; $i<=4; $i++): 
            $imgFile = "sub{$idNum}cat{$i}.png";
            if (!file_exists($bgDir . '/' . $imgFile)) $imgFile = "sub1cat{$i}.png";
          ?>
            <div class="dynamic-box">
              <img src="bg/<?php echo $imgFile; ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; object-position: bottom center; z-index: 1;">
            </div>
          <?php endfor; ?>
        </div>

        <!-- Details View (Hidden initially) -->
        <div id="view-details" class="details-grid" style="display: none;">
          <?php 
          for($i=1; $i<=6; $i++): 
            $imgFile = "sub{$idNum}det{$i}.png";
            if (!file_exists($bgDir . '/' . $imgFile)) $imgFile = "sub1det{$i}.png";
          ?>
            <div class="dynamic-box">
              <img src="bg/<?php echo $imgFile; ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; object-position: bottom center; z-index: 1;">
            </div>
          <?php endfor; ?>
        </div>

      </div>

      <!-- Right Column - Specifications list (fitted to screen) -->
      <div class="specs-container <?php echo count($product['items']) > 2 ? 'compact-layout' : ''; ?>">
        
        <div class="specs-top-content">
          <div class="specs-header">
            <h2 id="specs-header-title">
              <span class="header-num"><?php echo $product['name']; ?></span>
              <span class="header-text">CATALOGUE</span>
            </h2>
          </div>

          <div class="specs-list">
            <?php foreach($product['items'] as $item): ?>
              <div class="spec-item">
                <span class="spec-item-title"><?php echo $item['type']; ?></span>
                <?php if(isset($item['price'])): ?>
                <div class="spec-detail">
                  <span class="spec-detail-label">PRICE:</span>
                  <?php echo $item['price']; ?>
                </div>
                <?php endif; ?>
                <div class="spec-detail">
                  <span class="spec-detail-label">CODE:</span>
                  <?php echo $item['code']; ?>
                </div>
                <div class="spec-detail">
                  <span class="spec-detail-label">COLOR:</span>
                  <?php echo $item['color']; ?>
                </div>
                <div class="spec-detail">
                  <span class="spec-detail-label">MATERIAL:</span>
                  <?php echo $item['material']; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="specs-bottom">
          <div class="specs-branding">
            <p style="color: var(--zinc-300);">"<?php echo $product['collection']; ?>"</p>
            <p>AUTUMN/WINTER<br>2026 COLLECTION</p>
          </div>
        </div>

      </div>

    </div>

    <!-- Fixed Bottom Bar Footer with high-visibility controls -->
    <div class="bottom-bar">
      <!-- Bottom Left -->
      <a href="collections.php#catalogue" id="control-back" class="luxury-btn">BACK</a>
      
      <!-- Bottom Right: REVISION - Styled as high-visibility luxury bordered button -->
      <button id="control-toggle" class="luxury-btn" type="button">DETAILS</button>
    </div>

  </div>

  <!-- ----------------- SHOP PURCHASE MODAL ----------------- -->
  <div id="shop-modal" class="shop-modal">
    <div class="shop-modal-content">
      <button id="shop-modal-close-btn" class="shop-modal-close" type="button">&times;</button>
      
      <div id="shop-form-screen">
        <h3 style="font-family: var(--font-nuqun); font-size: 14px; letter-spacing: 0.15em; font-weight: 700; color: #ffffff; margin-bottom: 4px; text-transform: uppercase;">PURCHASE REQUEST</h3>
        <p style="font-size: 11px; color: var(--zinc-550); margin-bottom: 24px; text-transform: uppercase;">DESIGN <?php echo $product['name']; ?> — IDR <?php echo $product['price']; ?></p>
        
        <form id="purchase-form">
          
          <div class="shop-form-group" style="margin-bottom: 24px; border-bottom: 1px solid var(--zinc-900); padding-bottom: 20px;">
            <label>SELECT ITEMS TO PURCHASE</label>
            <div style="display: flex; flex-direction: column; gap: 12px;">
              <?php foreach($product['items'] as $index => $item): ?>
                <label class="checkbox-label">
                  <input type="checkbox" name="items[]" value="<?php echo $item['code']; ?>" checked>
                  <?php echo $item['type']; ?> (<?php echo isset($item['price']) ? $item['price'] : 'IDR -'; ?>)
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="shop-form-group">
            <label for="cust-name">NAME</label>
            <input required type="text" id="cust-name" placeholder="YOUR FULL NAME">
          </div>
          
          <div class="shop-form-group">
            <label for="cust-email">EMAIL</label>
            <input required type="email" id="cust-email" placeholder="NAME@EMAIL.COM">
          </div>
          
          <div class="shop-form-group">
            <label for="cust-phone">PHONE / WHATSAPP</label>
            <div style="display: flex; gap: 8px;">
              <select id="cust-country-code" style="width: 100px; flex-shrink: 0; padding-right: 4px; padding-left: 8px;">
                <option value="+62">ID (+62)</option>
                <option value="+65">SG (+65)</option>
                <option value="+60">MY (+60)</option>
                <option value="+66">TH (+66)</option>
                <option value="+63">PH (+63)</option>
                <option value="+84">VN (+84)</option>
                <option value="+86">CN (+86)</option>
                <option value="+852">HK (+852)</option>
                <option value="+886">TW (+886)</option>
                <option value="+81">JP (+81)</option>
                <option value="+82">KR (+82)</option>
                <option value="+91">IN (+91)</option>
                <option value="+971">AE (+971)</option>
                <option value="+61">AU (+61)</option>
                <option value="+64">NZ (+64)</option>
                <option value="+44">UK (+44)</option>
                <option value="+33">FR (+33)</option>
                <option value="+49">DE (+49)</option>
                <option value="+39">IT (+39)</option>
                <option value="+34">ES (+34)</option>
                <option value="+31">NL (+31)</option>
                <option value="+46">SE (+46)</option>
                <option value="+41">CH (+41)</option>
                <option value="+1">US/CA (+1)</option>
                <option value="+52">MX (+52)</option>
                <option value="+55">BR (+55)</option>
                <option value="+27">ZA (+27)</option>
              </select>
              <input required type="tel" id="cust-phone" placeholder="812 3456 7890" style="flex-grow: 1;">
            </div>
          </div>
          
          <div class="shop-form-group">
            <label for="cust-notes">ADDITIONAL NOTES</label>
            <textarea id="cust-notes" placeholder="HEIGHT, WEIGHT, OR SPECIAL REQUESTS..." rows="2" style="resize: none;"></textarea>
          </div>
          
          <button type="submit" class="shop-submit-btn">SUBMIT PURCHASE REQUEST</button>
        </form>
      </div>
      
      <div id="shop-success-screen" style="display: none; text-align: center; padding: 16px 0;">
        <svg class="success-checkmark" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 24px auto;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <h4 style="font-family: var(--font-nuqun); font-size: 14px; letter-spacing: 0.15em; font-weight: 700; color: #ffffff; margin-bottom: 12px; text-transform: uppercase;">REQUEST SUBMITTED</h4>
        <p style="font-size: 11px; color: var(--zinc-450); line-height: 1.6; text-transform: uppercase; margin-bottom: 24px; padding: 0 12px;">Thank you. We have received your purchase request for **Design <?php echo $product['name']; ?>**. Our representative will reach out to you directly via email or WhatsApp shortly.</p>
        <button id="shop-success-btn" class="shop-submit-btn" type="button">CONTINUE BROWSING</button>
      </div>
    </div>
  </div>

  <!-- ----------------- IMAGE PREVIEW MODAL ----------------- -->
  <div id="preview-modal" class="preview-modal">
    <button id="preview-modal-close-btn" class="shop-modal-close" type="button" style="z-index: 1060; font-size: 32px; right: 24px; top: 24px; color: #ffffff;">&times;</button>
    
    <button id="prev-btn" class="preview-nav-btn" type="button">&#10094;</button>
    <button id="next-btn" class="preview-nav-btn" type="button">&#10095;</button>
    
    <div id="preview-dots" class="preview-dots-container"></div>

    <div id="preview-content" class="preview-content">
      <div id="preview-inner" class="preview-inner">
        <!-- Content injected via JS -->
      </div>
    </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const viewCatalogue = document.getElementById('view-catalogue');
    const viewDetails = document.getElementById('view-details');
    const controlBack = document.getElementById('control-back');
    const controlToggle = document.getElementById('control-toggle');
    const specsHeaderTitle = document.getElementById('specs-header-title');
    const specsContainer = document.querySelector('.specs-container');
    
    const shopModal = document.getElementById('shop-modal');
    const shopModalCloseBtn = document.getElementById('shop-modal-close-btn');
    const purchaseForm = document.getElementById('purchase-form');
    const shopFormScreen = document.getElementById('shop-form-screen');
    const shopSuccessScreen = document.getElementById('shop-success-screen');
    const shopSuccessBtn = document.getElementById('shop-success-btn');

    let currentView = 'catalogue'; // catalogue or details

    const toggleView = () => {
      if (currentView === 'catalogue') {
        // Toggle to details view
        viewCatalogue.style.opacity = '0';
        specsContainer.style.opacity = '0';
        controlToggle.style.opacity = '0';
        
        setTimeout(() => {
          currentView = 'details';
          viewCatalogue.style.display = 'none';
          viewDetails.style.display = 'grid';
          
          specsHeaderTitle.innerHTML = `<span class="header-num"><?php echo $product['name']; ?></span><span class="header-text">DETAILS</span>`;
          controlBack.href = '#';
          controlBack.addEventListener('click', handleBackClick);
          controlToggle.innerText = 'PURCHASE';
          
          // Fade in
          setTimeout(() => { 
            viewDetails.style.opacity = '1'; 
            specsContainer.style.opacity = '1';
            controlToggle.style.opacity = '1';
          }, 50);
        }, 300);
      } else {
        // Trigger Shop Modal
        shopModal.classList.add('open');
      }
    };

    const handleBackClick = (e) => {
      if (currentView === 'details') {
        e.preventDefault();
        
        viewDetails.style.opacity = '0';
        specsContainer.style.opacity = '0';
        controlToggle.style.opacity = '0';
        
        setTimeout(() => {
          currentView = 'catalogue';
          viewDetails.style.display = 'none';
          viewCatalogue.style.display = 'grid';
          
          specsHeaderTitle.innerHTML = `<span class="header-num"><?php echo $product['name']; ?></span><span class="header-text">CATALOGUE</span>`;
          controlBack.href = 'collections.php#catalogue';
          controlBack.removeEventListener('click', handleBackClick);
          controlToggle.innerText = 'DETAILS';
          
          // Fade in
          setTimeout(() => { 
            viewCatalogue.style.opacity = '1'; 
            specsContainer.style.opacity = '1';
            controlToggle.style.opacity = '1';
          }, 50);
        }, 300);
      }
    };

    controlToggle.addEventListener('click', toggleView);

    // Modal close controls
    const closeModal = () => {
      shopModal.classList.remove('open');
      setTimeout(() => {
        shopFormScreen.style.display = 'block';
        shopSuccessScreen.style.display = 'none';
        purchaseForm.reset();
      }, 300);
    };

    shopModalCloseBtn.addEventListener('click', closeModal);
    shopSuccessBtn.addEventListener('click', closeModal);

    // Close on overlay click
    shopModal.addEventListener('click', (e) => {
      if (e.target === shopModal) {
        closeModal();
      }
    });

    // Form submission simulation -> Real API call
    purchaseForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      const submitBtn = purchaseForm.querySelector('.shop-submit-btn');
      submitBtn.innerText = 'PROCESSING...';
      submitBtn.disabled = true;
      
      // Collect selected items
      const selectedItems = [];
      const checkboxes = purchaseForm.querySelectorAll('input[name="items[]"]:checked');
      checkboxes.forEach((cb) => {
        selectedItems.push({
          name: cb.value,
          price: cb.parentElement.innerText.trim()
        });
      });
      
      const phone = document.getElementById('cust-country-code').value + ' ' + document.getElementById('cust-phone').value;
      
      const payload = {
        product_id: '<?php echo $id; ?>',
        product_name: '<?php echo $product['name']; ?>',
        items: selectedItems,
        name: document.getElementById('cust-name').value,
        email: document.getElementById('cust-email').value,
        phone: phone,
        notes: document.getElementById('cust-notes').value
      };
      
      fetch('purchase_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        if(data.success) {
          shopFormScreen.style.display = 'none';
          shopSuccessScreen.style.display = 'block';
        } else {
          alert('Error: ' + (data.error || 'Unknown error'));
        }
      })
      .catch(err => {
        alert('Failed to send request. Please try again.');
      })
      .finally(() => {
        submitBtn.innerText = 'SUBMIT PURCHASE REQUEST';
        submitBtn.disabled = false;
      });
    });

    // Image Preview Logic
    const previewModal = document.getElementById('preview-modal');
    const previewContent = document.getElementById('preview-content');
    const previewInner = document.getElementById('preview-inner');
    const previewCloseBtn = document.getElementById('preview-modal-close-btn');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const previewDots = document.getElementById('preview-dots');

    let currentBoxIndex = 0;
    let currentBoxList = [];

    const createDots = () => {
      previewDots.innerHTML = '';
      currentBoxList.forEach((_, i) => {
        const dot = document.createElement('div');
        dot.className = 'preview-dot' + (i === currentBoxIndex ? ' active' : '');
        dot.addEventListener('click', (e) => {
           e.stopPropagation();
           changePreviewImage(i);
        });
        previewDots.appendChild(dot);
      });
    };

    const updateDots = () => {
      Array.from(previewDots.children).forEach((dot, i) => {
        if (i === currentBoxIndex) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    };

    const changePreviewImage = (newIndex) => {
      if (newIndex === currentBoxIndex) return;
      
      // Fade out animation
      previewInner.classList.add('fade-out');
      
      setTimeout(() => {
        currentBoxIndex = newIndex;
        previewInner.innerHTML = currentBoxList[currentBoxIndex].innerHTML;
        updateDots();
        
        // Fade back in
        previewInner.classList.remove('fade-out');
      }, 300); // Wait 300ms for CSS transition
    };

    const openPreview = (index, list) => {
      currentBoxIndex = index;
      currentBoxList = list;
      previewInner.innerHTML = list[index].innerHTML;
      createDots();
      previewModal.classList.add('open');
    };

    document.querySelectorAll('.dynamic-box').forEach(box => {
      box.style.cursor = 'pointer';
      box.addEventListener('click', (e) => {
        const parent = box.closest('.catalogue-grid, .details-grid');
        const list = Array.from(parent.querySelectorAll('.dynamic-box'));
        const index = list.indexOf(box);
        openPreview(index, list);
      });
    });
    
    prevBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (currentBoxList.length > 0) {
        const newIdx = (currentBoxIndex - 1 + currentBoxList.length) % currentBoxList.length;
        changePreviewImage(newIdx);
      }
    });

    nextBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (currentBoxList.length > 0) {
        const newIdx = (currentBoxIndex + 1) % currentBoxList.length;
        changePreviewImage(newIdx);
      }
    });

    const closePreview = () => {
      previewModal.classList.remove('open');
      setTimeout(() => {
        previewContent.classList.remove('zoomed');
        previewInner.style.transform = 'scale(1)';
        translateX = 0;
        translateY = 0;
        previewInner.innerHTML = '';
      }, 300);
    };

    previewCloseBtn.addEventListener('click', closePreview);
    previewModal.addEventListener('click', (e) => {
      if (e.target === previewModal) {
        closePreview();
      }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (!previewModal.classList.contains('open')) return;
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        if (currentBoxList.length > 0) {
          const newIdx = (currentBoxIndex - 1 + currentBoxList.length) % currentBoxList.length;
          changePreviewImage(newIdx);
        }
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        if (currentBoxList.length > 0) {
          const newIdx = (currentBoxIndex + 1) % currentBoxList.length;
          changePreviewImage(newIdx);
        }
      } else if (e.key === 'Escape') {
        closePreview();
      }
    });

    // Zoom & Drag logic
    let isDragging = false;
    let hasDragged = false;
    let dragStartX = 0, dragStartY = 0;
    let translateX = 0, translateY = 0;
    let startTranslateX = 0, startTranslateY = 0;
    const ZOOM_SCALE = 2.5;
    
    const resetDrag = () => {
      translateX = 0;
      translateY = 0;
      previewInner.style.transition = 'opacity 0.3s ease, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
      previewInner.style.transform = 'scale(1)';
    };
    
    previewContent.addEventListener('mousedown', (e) => {
      if (e.target === previewCloseBtn || e.target === prevBtn || e.target === nextBtn) return;
      if (!previewContent.classList.contains('zoomed')) return;
      isDragging = true;
      hasDragged = false;
      dragStartX = e.clientX;
      dragStartY = e.clientY;
      startTranslateX = translateX;
      startTranslateY = translateY;
      previewContent.classList.add('dragging');
      previewInner.style.transition = 'none';
      e.preventDefault();
    });
    
    document.addEventListener('mousemove', (e) => {
      if (!isDragging) return;
      const dx = e.clientX - dragStartX;
      const dy = e.clientY - dragStartY;
      if (Math.abs(dx) > 3 || Math.abs(dy) > 3) hasDragged = true;
      translateX = startTranslateX + dx;
      translateY = startTranslateY + dy;
      previewInner.style.transform = `scale(${ZOOM_SCALE}) translate(${translateX}px, ${translateY}px)`;
    });
    
    document.addEventListener('mouseup', () => {
      if (isDragging) {
        isDragging = false;
        previewContent.classList.remove('dragging');
        previewInner.style.transition = 'opacity 0.3s ease, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
      }
    });
    
    previewContent.addEventListener('click', (e) => {
      if (e.target === previewCloseBtn || e.target === prevBtn || e.target === nextBtn) return;
      e.stopPropagation();
      if (hasDragged) { hasDragged = false; return; }
      
      if (previewContent.classList.contains('zoomed')) {
        previewContent.classList.remove('zoomed');
        resetDrag();
      } else {
        previewContent.classList.add('zoomed');
        previewInner.style.transform = `scale(${ZOOM_SCALE})`;
      }
    });

  });
  </script>

</body>
</html>
