<?php
session_start([
    'cookie_lifetime' => 28800,
    'gc_maxlifetime' => 28800,
    'cookie_path' => '/',
    'cookie_secure' => !empty($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);
require_once __DIR__.'/classes/UserManager.php';
$um = new UserManager(__DIR__.'/data/users.json');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $user = $um->findByUsername($username);
    if ($user && password_verify($password, $user['passwordHash'])) {
        session_regenerate_id(true);
        $_SESSION['userid'] = (int)$user['id'];
        header('Location: /pages/dashboard.php'); exit;
    } else {
        $error = 'Felaktigt användarnamn eller lösenord';
    }
}

$pageTitle   = 'Startsida';
$pageHeading = 'Startsida';
require_once __DIR__ . '/includes/header.php';
?>

<div class="login-container">
    <div class="login-box">
        <h1>Logga in</h1>
        <?php if ($error): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
            <label for="username">Användarnamn:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Lösenord:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Logga in</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<?php
// Felsökningshjälp: skriver ut en hash för lösenordet admin123.
// Kopiera den till data/users.json om du behöver återställa admin-kontot.
// echo password_hash('admin123', PASSWORD_DEFAULT);
?>
