<?php
// Validasi input buku. Mengembalikan [data_bersih, daftar_error]
function validate_book($post) {
    $data = [
        'judul'    => clean($post['judul'] ?? ''),
        'penulis'  => clean($post['penulis'] ?? ''),
        'penerbit' => clean($post['penerbit'] ?? ''),
        'tahun'    => clean($post['tahun'] ?? ''),
        'harga'    => clean($post['harga'] ?? ''),
    ];
    $errors = [];

    // Percabangan if-else untuk validasi kelengkapan
    if ($data['judul'] === '' || $data['penulis'] === '' || $data['penerbit'] === ''
        || $data['tahun'] === '' || $data['harga'] === '') {
        $errors[] = t('err_required');
    } else {
        // filter_var untuk validasi tipe & rentang
        $tahun = filter_var($data['tahun'], FILTER_VALIDATE_INT,
                 ['options' => ['min_range' => 1900, 'max_range' => (int)date('Y')]]);
        if ($tahun === false) {
            $errors[] = t('err_year');
        }
        $harga = filter_var($data['harga'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        if ($harga === false) {
            $errors[] = t('err_price');
        }
    }
    return [$data, $errors];
}

function render_book_form($data, $errors, $action, $title_key) {
    ?>
    <h2><?= e(t($title_key)) ?></h2>
    <?php foreach ($errors as $err): ?><div class="alert error"><?= e($err) ?></div><?php endforeach; ?>
    <form method="POST" action="<?= e($action) ?>">
        <label><?= e(t('title')) ?></label>
        <input type="text" name="judul" value="<?= e($data['judul']) ?>">
        <label><?= e(t('author')) ?></label>
        <input type="text" name="penulis" value="<?= e($data['penulis']) ?>">
        <label><?= e(t('publisher')) ?></label>
        <input type="text" name="penerbit" value="<?= e($data['penerbit']) ?>">
        <label><?= e(t('year')) ?></label>
        <input type="number" name="tahun" value="<?= e($data['tahun']) ?>">
        <label><?= e(t('price')) ?></label>
        <input type="number" name="harga" value="<?= e($data['harga']) ?>">
        <br><br>
        <button class="btn" type="submit"><?= e(t('save')) ?></button>
        <a class="btn gray" href="index.php"><?= e(t('cancel')) ?></a>
    </form>
    <?php
}
