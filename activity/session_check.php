<?php
/**
 * session_check.php
 *
 * Include this at the very top of every protected page
 * (before any HTML output).
 *
 * It does two things:
 *   1. Confirms the visitor is logged in - otherwise redirect to login.php
 *   2. Enforces a 5-second inactivity timeout - if more than
 *      SESSION_TIMEOUT seconds have passed since the last request,
 *      the session is destroyed and the visitor is sent back to login.
 */

session_start();

define('SESSION_TIMEOUT', 5); // seconds

// 1. Must be logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php?msg=notloggedin");
    exit;
}

// 2. Must not be idle for longer than SESSION_TIMEOUT
if (isset($_SESSION['last_activity'])) {
    $idle_for = time() - $_SESSION['last_activity'];
    if ($idle_for > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header("Location: login.php?msg=timeout");
        exit;
    }
}

// Passed both checks - refresh the activity timestamp
$_SESSION['last_activity'] = time();
