<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$user = $_SESSION['user'] ?? null;
?>

<header class="app-topbar">
    <div class="page-title">
        <h1><?= $pageTitle ?? 'Manajemen Kategori' ?></h1>
        <p><?= $pageSubtitle ?? 'Kelola kategori untuk mengelompokkan buku' ?></p>
    </div>

    <div class="topbar-user">
        <span class="avatar">
            <?= isset($user['name']) ? strtoupper(substr($user['name'], 0, 2)) : 'GS' ?>
        </span>
        <div>
            <?= $user['name'] ?? 'Guest' ?>
            <br>
            <span class="badge badge-member" style="margin-top:2px;">
                <?= (isset($user['role']) && $user['role'] === 'member') ? 'Member' : 'Admin' ?>
            </span>
        </div>
    </div>
</header>
