<!doctype html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title><?= $pageTitle ?? 'Saknar rubrik' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
  </head>

  <body>
    <div class="container">

      <header class="app-header" role="banner">
        <div class="app-header__bar">

          <div class="app-header__logo" aria-hidden="true">✓</div>
          <div class="app-header__title">Mötesbokning</div>

          <nav class="app-header__nav" aria-label="Huvudnavigation">
            <a class="app-header__link" href="/pages/dashboard.php">Startsida</a>
            <a class="app-header__link" href="/pages/allrooms.php">Boka rum</a>
            <a class="app-header__link" href="/pages/users.php">Användare</a>
            <a class="app-header__link app-header__link--logout" href="/logout.php">Logga ut</a>
          </nav>

        </div>
      </header>

      <main>
        <h1><?= $pageHeading ?? 'Saknar rubrik' ?></h1>
