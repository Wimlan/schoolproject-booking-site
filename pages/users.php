<?php
    $pageTitle   = 'Användare';
    $pageHeading = 'Användare';

    require_once __DIR__.'/../includes/auth_guard.php';
    require_once __DIR__.'/../classes/UserManager.php';
    require_once __DIR__.'/../classes/User.php';

$um = new UserManager(__DIR__.'/../data/users.json');

// Lägg till ny användare
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password && !$um->findByUsername($username)) {
        $user = new User($um->nextId(), $username, password_hash($password, PASSWORD_DEFAULT));
        $um->add($user);
    }
    header('Location: users.php'); exit;
}

// Byt lösenord
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'pwd') {
    $id = (int)($_POST['id'] ?? 0);
    $password = $_POST['password'] ?? '';
    if ($id > 0 && $password) { $um->updatePassword($id, $password); }
    header('Location: users.php'); exit;
}

// Ta bort användare
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'del') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) { $um->delete($id); }
    header('Location: users.php'); exit;
}

$users = $um->all();

// Sidhuvudet skrivs ut först här, efter att formulären har hanterats.
require_once __DIR__.'/../includes/header.php';
?>


<table border="1" cellpadding="6">
  <tr><th>ID</th><th>Användarnamn</th><th>Byt lösenord</th><th>Ta bort</th></tr>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td>
        <form method="post" style="display:inline-flex; gap:6px;">
          <input type="hidden" name="action" value="pwd">
          <input type="hidden" name="id" value="<?= $u['id'] ?>">
          <input type="password" name="password" placeholder="Nytt lösenord" required>
          <button type="submit">Uppdatera</button>
        </form>
      </td>
      <td>
        <form method="post" onsubmit="return confirm('Ta bort användare?');">
          <input type="hidden" name="action" value="del">
          <input type="hidden" name="id" value="<?= $u['id'] ?>">
          <button type="submit">Ta bort</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<div class="new-todo-form ">

    <h2>Lägg till användare</h2>
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label for="title">Användarnamn:</label>
        <input type="text" id="username" name="username" required>
        <label for="title">Lösenord:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Skapa</button>
    </form>

</div>


<?php require_once __DIR__.'/../includes/footer.php'; ?>
