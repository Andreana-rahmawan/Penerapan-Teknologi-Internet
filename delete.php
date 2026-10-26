<?php
require 'config.php';
require_login();

// DELETE hanya lewat POST agar tidak terhapus lewat klik link/crawler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var($_POST['id'] ?? 0, FILTER_VALIDATE_INT);
    if ($id) {
        $stmt = $conn->prepare('DELETE FROM books WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $_SESSION['flash'] = 'ok_deleted';
    }
}
header('Location: index.php');
exit;
