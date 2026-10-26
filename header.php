<!DOCTYPE html>
<html lang="<?= e($lang_code) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(t('app_title')) ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <strong><?= e(t('app_title')) ?></strong>
    <span class="right">
        <a href="?lang=id" class="<?= $lang_code === 'id' ? 'active' : '' ?>">ID</a> |
        <a href="?lang=en" class="<?= $lang_code === 'en' ? 'active' : '' ?>">EN</a>
        <?php if (!empty($_SESSION['user'])): ?>
            &nbsp;&middot;&nbsp; <?= e(t('welcome')) ?>, <?= e($_SESSION['user']) ?>
            &nbsp;<a class="btn small" href="logout.php"><?= e(t('logout')) ?></a>
        <?php endif; ?>
    </span>
</nav>
<main>
