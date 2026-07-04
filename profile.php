<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | PROFILE</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Force single screen view */
    body {
      height: 100vh;
      overflow: hidden;
      background-color: #000000;
    }
    
    .profile-layout {
      position: relative;
      z-index: 10;
      display: grid;
      grid-template-columns: 1fr;
      gap: 32px;
      flex-grow: 1;
      align-items: center;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      height: calc(100vh - 120px); /* Fit layout inside viewport */
      padding: 0;
    }
    
    @media (min-width: 1024px) {
      .profile-layout {
        grid-template-columns: 6.5fr 5.5fr;
        gap: 64px;
      }
    }
    
    .profile-story {
      font-size: 11px;
      line-height: 1.7;
      letter-spacing: 0.05em;
      color: var(--zinc-300);
      text-transform: uppercase;
      text-align: justify;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    @media (min-width: 768px) {
      .profile-story {
        font-size: 13px;
      }
    }
    
    @media (min-width: 1024px) {
      .profile-story {
        font-size: 13px;
        gap: 24px;
      }
    }
    
    .profile-showcase {
      position: relative;
      width: 100%;
      height: 80%; /* Fit showcase height inside container */
      /* Use absolute positioning inside to scatter images */
    }
    
    .profile-title-front {
      position: absolute;
      top: 50%;
      right: 0;
      transform: translateY(-50%);
      z-index: 20; /* Highest z-index */
      width: 100%;
      text-align: right;
      pointer-events: none;
    }
    
    .profile-title-front h1 {
      font-family: var(--font-nuqun);
      font-size: 48px;
      font-weight: 700;
      letter-spacing: 0.15em;
      color: #ffffff;
      line-height: 1.1;
      text-transform: uppercase;
      text-shadow: 0 5px 25px rgba(0,0,0,0.9);
    }
    
    @media (min-width: 768px) {
      .profile-title-front h1 {
        font-size: 64px;
      }
    }
    
    /* REVISION: Scaled down boxes */
    .staggered-box {
      width: 120px;
      aspect-ratio: 1 / 1;
      background-color: rgba(9, 9, 11, 0.7);
      border: 1px solid var(--zinc-800);
      position: absolute;
      z-index: 10;
      box-shadow: 0 10px 25px rgba(0,0,0,0.8);
      transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      overflow: hidden;
    }
    
    @media (min-width: 768px) {
      .staggered-box {
        width: 150px; /* Slightly larger */
      }
    }
    
    /* REVISION: Fine-tuning positions */
    .box-1 {
      top: 25%;
      left: -5%;
    }
    
    .box-2 {
      top: -15%;
      right: 0;
    }
    
    .box-3 {
      bottom: calc(-15% + 20px);
      left: 40%;
    }
    
    .staggered-box:hover {
      background-color: rgba(24, 24, 27, 0.98);
      z-index: 15;
    }
    
    .staggered-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* Social Links Floating Bar */
    .social-links {
      position: fixed;
      bottom: 64px;
      right: 48px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      z-index: 100;
    }
    
    .social-icon {
      width: 32px;
      height: 32px;
      object-fit: contain;
      opacity: 0.9;
      transition: opacity 0.3s ease, transform 0.3s ease;
      filter: brightness(0) invert(1);
    }
    
    .social-icon:hover {
      opacity: 1;
      transform: scale(1.1);
    }
    
    .profile-slide {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: grayscale(100%);
      opacity: 0;
      animation: profileSlideshow 8s infinite;
      z-index: 1;
    }
    
    .slide-1 { animation-delay: 0s; }
    .slide-2 { animation-delay: 4s; }

    @keyframes profileSlideshow {
      0% { opacity: 0; }
      15% { opacity: 1; }
      50% { opacity: 1; }
      65% { opacity: 0; }
      100% { opacity: 0; }
    }
  </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <div class="page-container" style="padding-left: 48px; padding-right: 48px;">
    
    <!-- Main layout split -->
    <div class="profile-layout animate-fade-in">
      
      <!-- Left Column - Brand story paragraphs -->
      <div class="profile-story">
        <p>
          XYÚN STUDIO IS AN INDEPENDENT FASHION BRAND THAT HAS BEEN ESTABLISHED SINCE
          2024 AND ORIGINATED FROM SURABAYA, EAST JAVA, INDONESIA. WE FOCUS ON CREATING
          STREETWEAR FASHION ITEMS THAT HIGHLIGHT HUMAN CREATIVITY AND INTUITION, WITH PIECES
          RANGING FROM RTW DELUXE TO AVANT GARDE.
        </p>
        <p>
          WE AIM TO PRESERVE HUMAN TOUCH IN OUR PIECES THROUGH DETAILED DESIGNS AND
          INTRICATE FABRIC MANIPULATIONS THAT ARE ONE OF A KIND AND AUTHENTIC IN EACH THEIR
          OWN WAY. HERE, WE APPRECIATE RAWNESS AND IMPERFECTIONS AS A REFLECTION WHERE
          FASHION IS NOT ALWAYS ABOUT BEING PICTURE PERFECT, BUT ALSO AS A MEDIA OF SELF
          EXPRESSION.
        </p>
        <p>
          OUR BRAND CARRIES A NARRATIVE IN EVERY COLLECTION WHICH ARE TARGETED MOSTLY
          TOWARDS YOUNG WOMEN WHO ARE EXPRESSIVE, EXTROVERTED, AND BOLD. XYÚN STUDIO IS NOT
          ONLY BUILT TO CREATE, BUT TO TELL A STORY AND INSPIRE.
        </p>
      </div>

      <!-- Right Column - Title & Scattered boxes -->
      <div class="profile-showcase">
        <!-- Overlay title: front & white -->
        <div class="profile-title-front">
          <h1>ABOUT<br>US</h1>
        </div>

        <!-- Box 01 -->
        <div class="staggered-box box-1">
          <img src="bg/profileimg1-1.jpg" class="profile-slide slide-1">
          <img src="bg/profileimg1-2.jpg" class="profile-slide slide-2">
        </div>

        <!-- Box 02 -->
        <div class="staggered-box box-2">
          <img src="bg/profileimg2-1.jpg" class="profile-slide slide-1">
          <img src="bg/profileimg2-2.jpg" class="profile-slide slide-2">
        </div>

        <!-- Box 03 -->
        <div class="staggered-box box-3">
          <img src="bg/profileimg3-1.jpg" class="profile-slide slide-1">
          <img src="bg/proifleimg3-2.jpg" class="profile-slide slide-2">
        </div>
      </div>

    </div>

    <!-- Fixed Bottom Bar Footer -->
    <div class="bottom-bar">
      <a href="collections.php">COLLECTIONS</a>
      <span class="bottom-bar-decor">RAWCODE A/W 2026</span>
    </div>
    
    <!-- Floating Social Links -->
    <div class="social-links">
      <a href="https://www.instagram.com/xyun.studio?igsh=MWtvdzRpdGJuMXBpdA==" target="_blank"><img src="logoig.png" class="social-icon" alt="Instagram"></a>
      <a href="https://wa.me/62895602782505" target="_blank"><img src="logowa.png" class="social-icon" alt="WhatsApp"></a>
      <a href="https://mail.google.com/mail/?view=cm&fs=1&to=xyunstudio@gmail.com" target="_blank"><img src="logoemail.png" class="social-icon" alt="Email"></a>
    </div>
  </div>

</body>
</html>
