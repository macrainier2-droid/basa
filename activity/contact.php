<?php require 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us - Session Activity</title>
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
    <h1>Contact Us</h1>
    <p>Another protected page - reachable only while your session is valid.</p>
    <table>
      <tr><th>Email</th><td>support@example.com</td></tr>
      <tr><th>Phone</th><td>+1 (555) 010-0100</td></tr>
    </table>
    <p>Logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.
    Session ID: <span class="mono"><?php echo htmlspecialchars(session_id()); ?></span></p>
    <a class="btn btn-secondary" href="dashboard.php">&larr; Back to Dashboard</a>
  </div>
</div>
</body>
</html>
