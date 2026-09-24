<?php
/**
 * session_id_demo.php
 * Laboratory Activity: Exploring Session IDs
 *
 * Part 1 - Generate and Display a Session ID (+ reload counter)
 * Part 2 - Calculate Possible Combinations (N = C^L)
 * Part 3 - Regenerate the Session ID
 * Part 4 - Modify the Session ID Cookie      (manual browser step, instructions below)
 * Part 5 - Compare Session IDs Across Browsers (manual step, instructions below)
 *
 * Not gated behind login - this is a standalone exploration tool.
 */
session_start();

// --- Part 3: handle the "Regenerate ID" button ---
$just_regenerated = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['regenerate'])) {
    $_SESSION['previous_id'] = session_id();
    session_regenerate_id(true);
    $_SESSION['just_regenerated'] = true;
    header("Location: session_id_demo.php");
    exit;
}

if (!empty($_SESSION['just_regenerated'])) {
    $just_regenerated = true;
    unset($_SESSION['just_regenerated']); // show the banner once
}

// --- Part 1: track reload count for this session ---
if (!isset($_SESSION['reload_count'])) {
    $_SESSION['reload_count'] = 1;
} else {
    $_SESSION['reload_count']++;
}

$current_id  = session_id();
$cookie_name = session_name();

// --- Part 2: calculate possible combinations ---
$L = (int) (ini_get('session.sid_length') ?: strlen($current_id));
$bits = (int) (ini_get('session.sid_bits_per_character') ?: 4);

switch ($bits) {
    case 5:
        $charset_desc = "0-9, a-v (32 characters)";
        $C = 32;
        break;
    case 6:
        $charset_desc = "0-9, a-z, A-Z, \"-\", \",\" (64 characters)";
        $C = 64;
        break;
    case 4:
    default:
        $charset_desc = "0-9, a-f (16 characters)";
        $C = 16;
        break;
}

// N = C^L, computed with bcmath if available so large numbers stay exact
if (function_exists('bcpow')) {
    $N = bcpow((string) $C, (string) $L);
    // add thousands separators to the big integer string
    $N_display = strrev(implode(',', str_split(strrev($N), 3)));
} else {
    $N = pow($C, $L);
    $N_display = number_format($N, 0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Session ID Demo</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
  <div class="brand">Session Activity</div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="session_info.php">Session Info</a>
  </nav>
</div>

<div class="container">

  <?php if ($just_regenerated): ?>
    <div class="card">
      <div class="notice">
        <strong>Session ID regenerated.</strong><br>
        Previous ID: <span class="mono"><?php echo htmlspecialchars($_SESSION['previous_id']); ?></span><br>
        New ID: <span class="mono"><?php echo htmlspecialchars($current_id); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <div class="card">
    <h1>Part 1 - Generate and Display a Session ID</h1>
    <table>
      <tr><th>Current Session ID</th><td class="mono"><?php echo htmlspecialchars($current_id); ?></td></tr>
      <tr><th>Cookie name</th><td class="mono"><?php echo htmlspecialchars($cookie_name); ?></td></tr>
      <tr><th>Times this page has loaded</th><td><?php echo (int) $_SESSION['reload_count']; ?></td></tr>
    </table>
    <p class="hint" style="text-align:left;">Reload this page a few times (without closing the
    browser) and watch the counter go up while the Session ID stays the same - the ID only
    changes when the session is regenerated, expires, or is cleared.</p>
  </div>

  <div class="card">
    <h2>Part 2 - Calculate Possible Combinations</h2>
    <table>
      <tr><th>C (character set)</th><td><?php echo $charset_desc; ?></td></tr>
      <tr><th>L (Session ID length)</th><td><?php echo $L; ?> characters</td></tr>
      <tr><th>Formula</th><td>N = C<sup>L</sup> = <?php echo $C; ?><sup><?php echo $L; ?></sup></td></tr>
      <tr><th>Total possible Session IDs</th><td><strong><?php echo $N_display; ?></strong></td></tr>
    </table>
  </div>

  <div class="card">
    <h2>Part 3 - Regenerate the Session ID</h2>
    <p>Calls PHP's <code>session_regenerate_id(true)</code>, which issues a new Session ID
    while keeping your session data intact.</p>
    <form method="post" action="session_id_demo.php">
      <button type="submit" name="regenerate" value="1">Regenerate ID</button>
    </form>
  </div>

  <div class="card">
    <h2>Part 4 - Modify the Session ID Cookie</h2>
    <p>This step is done manually in your browser, not on this page:</p>
    <ol>
      <li>Open Developer Tools &rarr; <strong>Application</strong> (Chrome/Edge) or
        <strong>Storage</strong> (Firefox) &rarr; <strong>Cookies</strong>.</li>
      <li>Find the cookie named <code><?php echo htmlspecialchars($cookie_name); ?></code>
        and edit its value to a random string.</li>
      <li>Reload this page and observe what happens.</li>
    </ol>
    <p><strong>Question:</strong> Does the server still recognize your session? Why or why not?</p>
  </div>

  <div class="card">
    <h2>Part 5 - Compare Session IDs Across Browsers</h2>
    <ol>
      <li>Open this same page (<code>session_id_demo.php</code>) in a second browser, or in
        an incognito/private window.</li>
      <li>Record and compare the two Session IDs.</li>
    </ol>
    <p><strong>Question:</strong> Why are the two Session IDs different, even though they load
    the same script?</p>
  </div>

</div>
</body>
</html>
