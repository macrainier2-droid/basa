<?php
session_start();

// Already logged in? Skip straight to the dashboard.
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// Handle redirect messages first (timeout / not logged in)
$msg = $_GET['msg'] ?? '';
if ($msg === 'timeout') {
    $error = "Your session expired after 5 seconds of inactivity. Please log in again.";
} elseif ($msg === 'notloggedin') {
    $error = "Please log in to continue.";
}

// Handle the actual login attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'admin' && $password === '12345') {
        // Regenerate the Session ID right after authentication.
        // This prevents session fixation - an attacker who knew the
        // pre-login ID cannot hijack the now-authenticated session.
        session_regenerate_id(true);

        $_SESSION['username']      = $username;
        $_SESSION['login_time']    = time();
        $_SESSION['last_activity'] = time();

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Session Activity</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <h1>Session Activity</h1>
    <p class="hint">Username: <strong>admin</strong> &nbsp;|&nbsp; Password: <strong>12345</strong></p>

    <?php if ($error): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" autocomplete="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password" required>

      <button type="submit" style="width:100%;">Log In</button>
    </form>
  </div>
</div>
</body>
</html>
