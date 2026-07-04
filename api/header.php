<?php
// Function to check if a menu page is active
if (!function_exists('is_active')) {
  function is_active($page_name) {
    $current_script = basename($_SERVER['SCRIPT_NAME']);
    return ($current_script === $page_name) ? 'active' : '';
  }
}
if (!function_exists('isLoggedIn')) {
  require_once __DIR__ . '/auth.php';
}
?>
<header class="header-nav">
  <nav>
    <a href="index.php" class="<?php echo is_active('index.php'); ?>">HOME</a>
    <a href="menu.php" class="<?php echo is_active('menu.php'); ?>">MENU</a>
    <a href="blog.php" class="<?php echo is_active('blog.php'); ?>">BLOG</a>
    
    <!-- Inline Search Wrapper -->
    <div class="search-inline-wrapper">
      <button id="search-trigger" type="button">SEARCH</button>
      <div id="search-input-container" class="search-input-container">
        <input type="text" id="search-query-input" placeholder="SEARCH STYLE OR CODE..." autocomplete="off">
        <button id="search-close-btn" class="search-close-btn" type="button">&times;</button>
      </div>
      
      <!-- Autocomplete Dropdown -->
      <div id="search-results-dropdown" class="search-dropdown"></div>
    </div>
    
    <a href="profile.php" class="<?php echo is_active('profile.php'); ?>">PROFILE</a>
    
    <?php if (isLoggedIn()): ?>
      <?php if (isAdmin()): ?>
        <a href="purchase_requests.php" class="<?php echo is_active('purchase_requests.php'); ?>">REQUESTS</a>
      <?php endif; ?>
      <a href="logout.php">LOGOUT</a>
    <?php else: ?>
      <a href="login.php" class="<?php echo is_active('login.php'); ?>">LOGIN</a>
    <?php endif; ?>
  </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const searchTrigger = document.getElementById('search-trigger');
  const searchContainer = document.getElementById('search-input-container');
  const searchQueryInput = document.getElementById('search-query-input');
  const searchCloseBtn = document.getElementById('search-close-btn');
  const searchDropdown = document.getElementById('search-results-dropdown');

  const productsData = [
    {
      id: "01",
      name: "DESIGN 01",
      collection: "RAWCODE",
      items: ["HIGH NECK TOP (RC/T-005)", "BAGGY JEANS (RC/P-003)"],
      desc: "A striking combination of high-collar structuring and loose utility jeans featuring detailed hand-painted metallic coatings."
    },
    {
      id: "02",
      name: "DESIGN 02",
      collection: "RAWCODE",
      items: ["OFF SHOULDER TOP (RC/T-002)", "RUFFLE SKIRT (RC/S-001)"],
      desc: "An asymmetric silhouette pairing a soft, structured off-shoulder drape with a heavy-weight raw edge ruffle denim skirt."
    },
    {
      id: "03",
      name: "DESIGN 03",
      collection: "RAWCODE",
      items: ["HIGH NECK TOP (RC/T-003)", "BAGGY JEANS (RC/P-002)"],
      desc: "The core piece of the RAWCODE collection, featuring hand-manipulated foil coatings and metallic distressing across high-neck styling."
    },
    {
      id: "04",
      name: "DESIGN 04",
      collection: "RAWCODE",
      items: ["HIGH NECK TOP (RC/T-005)", "CROPPED OUTER (RC/O-001)", "MINI SKIRT (RC/S-002)"],
      desc: "A three-piece industrial look combining high-necked layering, premium cropped distressed leather outer, and a raw-hem denim mini skirt."
    },
    {
      id: "05",
      name: "DESIGN 05",
      collection: "RAWCODE",
      items: ["DOUBLE VEST (RC/T-001)", "BAGGY JEANS (RC/P-001)"],
      desc: "Structured double-layer vest vestments featuring technical buckle systems paired with relaxed raw-cut denim denim trousers."
    }
  ];

  const popularSearchesHTML = `
    <div style="padding: 12px 12px 8px 12px; font-size: 10px; color: var(--zinc-500); text-align: left; text-transform: uppercase; font-family: var(--font-nuqun); border-bottom: 1px solid var(--zinc-900);">
      Popular Searches
    </div>
    <a href="subpage.php?id=03" class="search-dropdown-item">
      <div class="search-dropdown-item-meta">DESIGN 03 / RAWCODE</div>
      <div class="search-dropdown-item-title">DESIGN 03</div>
      <div class="search-dropdown-item-desc">The core piece of the RAWCODE collection, featuring hand-manipulated foil coatings...</div>
    </a>
    <a href="subpage.php?id=05" class="search-dropdown-item">
      <div class="search-dropdown-item-meta">DESIGN 05 / RAWCODE</div>
      <div class="search-dropdown-item-title">DESIGN 05</div>
      <div class="search-dropdown-item-desc">Structured double-layer vest vestments featuring technical buckle systems...</div>
    </a>
  `;

  const showPopularSearches = () => {
    searchDropdown.innerHTML = popularSearchesHTML;
    searchDropdown.style.display = 'block';
  };

  // Toggle Search Input
  searchTrigger.addEventListener('click', (e) => {
    e.preventDefault();
    if (!searchContainer.classList.contains('active')) {
      searchContainer.classList.add('active');
      searchTrigger.style.display = 'none';
      if (searchQueryInput.value.trim() === '') {
        showPopularSearches();
      }
      setTimeout(() => searchQueryInput.focus(), 150);
    }
  });

  const closeSearch = () => {
    searchContainer.classList.remove('active');
    searchTrigger.style.display = 'inline-block';
    searchQueryInput.value = '';
    searchDropdown.style.display = 'none';
    searchDropdown.innerHTML = '';
  };

  searchCloseBtn.addEventListener('click', closeSearch);

  // Close search if clicking outside
  document.addEventListener('click', (e) => {
    const isClickInside = searchContainer.contains(e.target) || 
                          searchTrigger.contains(e.target) || 
                          searchDropdown.contains(e.target);
    if (!isClickInside && searchContainer.classList.contains('active')) {
      closeSearch();
    }
  });

  // Handle ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && searchContainer.classList.contains('active')) {
      closeSearch();
    }
  });

  // Autocomplete Filtering
  searchQueryInput.addEventListener('input', (e) => {
    const query = e.target.value.trim().toLowerCase();
    
    if (query === '') {
      showPopularSearches();
      return;
    }

    const filtered = productsData.filter(p => {
      const matchName = p.name.toLowerCase().includes(query);
      const matchDesc = p.desc.toLowerCase().includes(query);
      const matchId = p.id.includes(query);
      const matchItem = p.items.some(item => item.toLowerCase().includes(query));
      return matchName || matchDesc || matchId || matchItem;
    });

    if (filtered.length === 0) {
      searchDropdown.innerHTML = `
        <div style="padding: 12px; font-size: 10px; color: var(--zinc-600); text-align: center; text-transform: uppercase;">
          No matches found
        </div>
      `;
      searchDropdown.style.display = 'block';
      return;
    }

    searchDropdown.innerHTML = filtered.map(p => `
      <a href="subpage.php?id=${p.id}" class="search-dropdown-item">
        <div class="search-dropdown-item-meta">DESIGN ${p.id} / ${p.collection}</div>
        <div class="search-dropdown-item-title">${p.name}</div>
        <div class="search-dropdown-item-desc">${p.desc}</div>
      </a>
    `).join('');
    
    searchDropdown.style.display = 'block';
  });

  // Global Page Transitions
  document.body.style.opacity = '1';
  document.body.style.transition = 'opacity 0.4s ease';

  window.navigateTo = function(url) {
    document.body.style.opacity = '0';
    setTimeout(() => {
      window.location.href = url;
    }, 400);
  };

  document.querySelectorAll('a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href && href !== '#' && !href.startsWith('javascript:') && this.target !== '_blank' && !this.hasAttribute('download') && this.hostname === window.location.hostname) {
        e.preventDefault();
        window.navigateTo(this.href);
      }
    });
  });
});
</script>
