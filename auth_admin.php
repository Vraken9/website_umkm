<?php
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}
// Auto logout setelah 15 menit tidak aktif
$timeout = 15 * 60; // 15 menit
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
  session_unset();
  session_destroy();
  header('Location: login_admin.php?timeout=1');
  exit;
}
$_SESSION['last_activity'] = time();
