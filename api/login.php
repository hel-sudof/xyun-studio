<?php
require_once __DIR__ . '/auth.php';

// Prevent Vercel edge caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $isAdmin = false;
        
        if ($email === 'elzhelenajonathan@gmail.com') {
            if ($password === 'admin123') {
                $isAdmin = true;
            } else {
                $error = 'Invalid admin password.';
            }
        }
        
        if (!$error) {
            setAuthCookie($username, $isAdmin);
            header('Location: blog.php');
            exit;
        }
    } else {
        $error = 'Username and password are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>xyún studio | LOGIN</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Background */
    .login-bg-container {
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

    .login-bg {
      width: 100%;
      height: 100%;
      background-image: url('bg/loginbg.jpg');
      background-size: cover;
      background-position: center top;
      background-repeat: no-repeat;
      filter: brightness(0.45);
      animation: panBg 30s ease-in-out infinite;
    }
    
    .login-container {
      position: relative;
      z-index: 10;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 80px 24px 24px 24px;
    }
    
    .login-box {
      background-color: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      width: 100%;
      max-width: 400px;
      padding: 40px;
      position: relative;
    }
    
    .login-title {
      font-family: var(--font-nuqun);
      font-size: 18px;
      letter-spacing: 0.15em;
      color: #ffffff;
      margin-bottom: 8px;
      text-transform: uppercase;
    }
    
    .login-subtitle {
      font-size: 11px;
      color: var(--zinc-500);
      margin-bottom: 32px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
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
    
    .form-group input {
      width: 100%;
      background-color: #000;
      border: 1px solid var(--zinc-800);
      color: #fff;
      padding: 12px;
      font-family: var(--font-zalando-sans);
    }
    
    .error-msg {
      color: #ff4444;
      font-size: 11px;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
  </style>
</head>
<body class="animate-fade-in">

  <?php include 'header.php'; ?>

  <!-- Background -->
  <div class="login-bg-container">
    <div class="login-bg"></div>
  </div>

  <div class="login-container">
    <div class="login-box">
      <h2 class="login-title">LOGIN</h2>
      <p class="login-subtitle">ENTER CREDENTIALS TO CONTINUE</p>
      
      <?php if ($error): ?>
        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      
      <form method="POST" action="login.php">
        <div class="form-group">
          <label>EMAIL ADDRESS (OPTIONAL)</label>
          <input type="email" name="email" placeholder="ENTER EMAIL ADDRESS">
        </div>
        
        <div class="form-group">
          <label>USERNAME</label>
          <input type="text" name="username" required placeholder="ENTER USERNAME">
        </div>
        
        <div class="form-group">
          <label>PASSWORD</label>
          <input type="password" name="password" required placeholder="••••••••">
        </div>
        
        <button type="submit" class="luxury-btn" style="width: 100%; margin-top: 12px;">LOGIN</button>
      </form>
    </div>
  </div>

</body>
</html>
