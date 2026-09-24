<?php
/**
 * session_info.php
 * Displays PHP's current session-ID configuration.
 * Not gated behind login - it's a diagnostic page, not app content.
 */
session_start();

$php_version   = phpversion();
$sid_length    = ini_get('session.sid_length');       // number of characters
$sid_bits      = ini_get('session.sid_bits_per_character'); // bits per character
$generated_id  = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Session ID Configuration</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
  <div class="brand">Session Activity</div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="session_id_demo.php">Session ID Demo</a>
  </nav>
</div>

<div class="container">
  <div class="card">
    <h1>Part 1 - Check PHP Session ID Configuration</h1>
    <p>This page reads PHP's own <code>session.*</code> settings and shows a freshly
    generated Session ID, so you can see exactly what your server is configured to produce.</p>

    <table>
      <tr><th>PHP Version</th><td><?php echo htmlspecialchars($php_version); ?></td></tr>
      <tr><th>Session ID Length</th><td><?php echo htmlspecialchars($sid_length); ?> characters</td></tr>
      <tr><th>Bits Per Character</th><td><?php echo htmlspecialchars($sid_bits); ?></td></tr>
      <tr><th>Generated Session ID</th><td class="mono"><?php echo htmlspecialchars($generated_id); ?></td></tr>
    </table>

    <p class="hint" style="text-align:left;">Bits per character determines the character set:
    4 bits &rarr; <code>0-9a-f</code>, 5 bits &rarr; <code>0-9a-v</code>, 6 bits &rarr; <code>0-9a-zA-Z,-</code>.
    Head to <a href="session_id_demo.php">session_id_demo.php</a> to calculate how many possible
    Session IDs this configuration can produce.</p>
  </div>
</div>
</body>
</html>
