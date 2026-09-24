<?php require 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About Us - Session Activity</title>
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
    <h1>About Us</h1>
    <p>This page is part of the PHP Session Management lab activity. Like the
    Dashboard, it's a <strong>protected page</strong> - it requires an active,
    non-expired session to view.</p>
    <p>Logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.
    Session ID: <span class="mono"><?php echo htmlspecialchars(session_id()); ?></span></p>
    <a class="btn btn-secondary" href="dashboard.php">&larr; Back to Dashboard</a>
  </div>
</div>
</body>
</html>
