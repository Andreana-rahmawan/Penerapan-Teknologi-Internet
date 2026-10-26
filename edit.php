<?php
require 'config.php';
require_login();
require 'form_helper.php';

$id = filter_var($_GET['id'] ?? ($_POST['id'] ?? 0), FILTER_VALIDATE_INT);
if (!$id) { header('Location: index.php'); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list($data, $errors) = validate_book($_POST);
    if (empty($errors)) {
        // UPDATE berdasarkan id (identitas unik)
        $stmt = $conn->prepare('UPDATE books SET judul=?, penulis=?, penerbit=?, tahun=?, harga=? WHERE id=?');
        $tahun = (int)$data['tahun'];
        $harga = (int)$data['harga'];
        $stmt->bind_param('sssiii', $data['judul'], $data['penulis'], $data['penerbit'], $tahun, $harga, $id);
        $stmt->execute();
        $_SESSION['flash'] = 'ok_updated';
        header('Location: index.php');
        exit;
    }
} else {
    $stmt = $conn->prepare('SELECT judul, penulis, penerbit, tahun, harga FROM books WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if (!$data) {
        $_SESSION['flash'] = 'not_found';
        header('Location: index.php');
        exit;
    }
}
include 'header.php';
render_book_form($data, $errors, 'edit.php?id=' . $id, 'edit_book');
include 'footer.php';
