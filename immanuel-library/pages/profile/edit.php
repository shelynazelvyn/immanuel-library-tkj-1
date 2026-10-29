<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../repositories/user-repository.php";

// Opsional: Jika fungsi getUser membutuhkan ID dari session, Anda bisa mengubahnya menjadi:
// $userId = $_SESSION['user']['id'] ?? 0;
// $user = getUser($userId);
$user = getUser();
$profile = getProfile();

$pageTitle = "Profil Saya";
$pageSubtitle = "Kelola data akun dan profil Anda";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/profile/edit.css">
</head>
<body>
  <div class="app-shell">
  <?php require_once __DIR__ . "/../../components/admin/sidebar.php" ?>

    <main class="app-main">
    <?php require_once __DIR__ . "/../../components/admin/topbar.php" ?>

      <div class="app-content">
        <form method="POST" action="../../actions/profile/update.php">
          <div class="form-card" style="margin-bottom:20px;">
            <div class="form-section-title">Data Akun</div>
            <div class="form-row">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <!-- Diberikan ?? '' agar aman jika data user null -->
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Role</label>
              <!-- Diperbaiki dengan memastikan string tidak null sebelum masuk ke ucfirst() -->
              <input type="text" value="<?= ucfirst($user['role'] ?? 'member') ?>" disabled>
              <p class="form-help">Role hanya dapat diubah oleh Admin melalui menu Manajemen Pengguna.</p>
            </div>
          </div>

          <div class="form-card">
            <div class="form-section-title">Data Profil</div>
            <div class="form-group">
              <label for="phone">Nomor Telepon</label>
              <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="address">Alamat</label>
              <input type="text" id="address" name="address" value="<?= htmlspecialchars($profile['address'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="bio">Bio Singkat</label>
              <textarea id="bio" name="bio" rows="3"><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
            </div>
            <div class="form-actions">
              <button type="button" class="btn btn-outline">Batal</button>
              <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
