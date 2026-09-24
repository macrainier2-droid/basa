<?php require 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - Session Activity</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
  <div class="brand">Session Activity</div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="logout.php">Logout</a>
  </nav>
</div>

<div class="container">
  <div class="card">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <p>You are viewing a protected page. This page (and About Us / Contact Us) will
    automatically log you out if you don't visit any protected page for more than
    5 seconds.</p>

    <h2>Session Information</h2>
    <table>
      <tr><th>Username</th><td><?php echo htmlspecialchars($_SESSION['username']); ?></td></tr>
      <tr><th>Session ID</th><td class="mono"><?php echo htmlspecialchars(session_id()); ?></td></tr>
      <tr><th>Logged in at</th><td><?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></td></tr>
      <tr><th>Last activity</th><td><?php echo date('Y-m-d H:i:s', $_SESSION['last_activity']); ?></td></tr>
    </table>
  </div>

  <div class="card">
    <h2>Session ID Lab Tools</h2>
    <p>Extra pages for exploring how Session IDs work under the hood:</p>
    <ul>
      <li><a href="session_info.php">session_info.php</a> - check PHP's session ID configuration</li>
      <li><a href="session_id_demo.php">session_id_demo.php</a> - generate, calculate, regenerate, and compare Session IDs</li>
    </ul>
  </div>
</div>
</body>
</html>
