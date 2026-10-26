<?php
// Koneksi database + session + bahasa. Di-include oleh semua halaman.
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'katalog_buku';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal. Periksa config.php');
}

// ---------- Dual bahasa (disimpan di $_SESSION) ----------
if (isset($_GET['lang'])) {
    switch ($_GET['lang']) {
        case 'en': $_SESSION['lang'] = 'en'; break;
        default:   $_SESSION['lang'] = 'id';
    }
    // kembali ke halaman asal tanpa parameter lang
    $url = strtok($_SERVER['REQUEST_URI'], '?');
    $qs  = $_GET; unset($qs['lang']);
    header('Location: ' . $url . ($qs ? '?' . http_build_query($qs) : ''));
    exit;
}
$lang_code = $_SESSION['lang'] ?? 'id';
$L = require __DIR__ . "/lang/{$lang_code}.php";

function t($key) {
    global $L;
    return $L[$key] ?? $key;
}

// Sanitasi output / input teks
function e($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
function clean($str) {
    return trim(strip_tags((string)$str));
}

// Proteksi halaman: wajib login
function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}
