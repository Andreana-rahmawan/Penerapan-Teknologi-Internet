<?php
require 'config.php';
require_login();
require 'form_helper.php';

$data = ['judul'=>'','penulis'=>'','penerbit'=>'','tahun'=>'','harga'=>''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list($data, $errors) = validate_book($_POST);
    if (empty($errors)) {
        // CREATE
        $stmt = $conn->prepare('INSERT INTO books (judul, penulis, penerbit, tahun, harga) VALUES (?,?,?,?,?)');
        $tahun = (int)$data['tahun'];
        $harga = (int)$data['harga'];
        $stmt->bind_param('sssii', $data['judul'], $data['penulis'], $data['penerbit'], $tahun, $harga);
        $stmt->execute();
        $_SESSION['flash'] = 'ok_added';
        header('Location: index.php');
        exit;
    }
}
include 'header.php';
render_book_form($data, $errors, 'create.php', 'add_book');
include 'footer.php';
