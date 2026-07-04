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
    <a href="collections.php" class="<?php echo is_active('collections.php'); ?>">COLLECTIONS</a>
    <a href="blog.php" class="<?php echo is_active('blog.php'); ?>">BLOG</a>
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
</script>
