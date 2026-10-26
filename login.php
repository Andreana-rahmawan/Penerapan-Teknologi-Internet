<?php
require 'config.php';

// Jika sudah login, langsung ke halaman utama
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = t('err_required');
    } else {
        $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row && password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit;
        } else {
            $error = t('login_fail');
        }
    }
}
include 'header.php';
?>
<div class="login-box">
    <h2><?= e(t('login')) ?></h2>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="POST" action="login.php">
        <label><?= e(t('username')) ?></label>
        <input type="text" name="username" value="<?= e($_POST['username'] ?? '') ?>" autofocus>
        <label><?= e(t('password')) ?></label>
        <input type="password" name="password">
        <br><br>
        <button class="btn" type="submit"><?= e(t('login')) ?></button>
    </form>
</div>
<?php include 'footer.php'; ?>
