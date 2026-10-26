<?php
require 'config.php';
require_login();

// Pesan notifikasi dari halaman lain
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

// READ (+ pencarian sederhana)
$q = clean($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = $conn->prepare('SELECT * FROM books WHERE judul LIKE ? OR penulis LIKE ? ORDER BY id DESC');
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query('SELECT * FROM books ORDER BY id DESC');
}
include 'header.php';
?>
<div class="toolbar">
    <h2><?= e(t('data_books')) ?></h2>
    <form method="GET" action="index.php">
        <input type="text" name="q" placeholder="<?= e(t('search')) ?>" value="<?= e($q) ?>" style="width:220px;display:inline-block">
    </form>
    <a class="btn" href="create.php">+ <?= e(t('add_book')) ?></a>
</div>

<?php if ($flash): ?><div class="alert ok"><?= e(t($flash)) ?></div><?php endif; ?>

<table>
    <tr>
        <th><?= e(t('no')) ?></th><th><?= e(t('title')) ?></th><th><?= e(t('author')) ?></th>
        <th><?= e(t('publisher')) ?></th><th><?= e(t('year')) ?></th><th><?= e(t('price')) ?></th>
        <th><?= e(t('action')) ?></th>
    </tr>
    <?php if ($result->num_rows === 0): ?>
        <tr><td colspan="7" style="text-align:center"><?= e(t('empty_data')) ?></td></tr>
    <?php else: $no = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= e($row['judul']) ?></td>
            <td><?= e($row['penulis']) ?></td>
            <td><?= e($row['penerbit']) ?></td>
            <td><?= e($row['tahun']) ?></td>
            <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td>
                <a class="btn small" href="edit.php?id=<?= (int)$row['id'] ?>"><?= e(t('edit')) ?></a>
                <form method="POST" action="delete.php" style="display:inline"
                      onsubmit="return confirm('<?= e(t('confirm_del')) ?>')">
                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                    <button class="btn small danger" type="submit"><?= e(t('delete')) ?></button>
                </form>
            </td>
        </tr>
    <?php endwhile; endif; ?>
</table>
<?php include 'footer.php'; ?>
