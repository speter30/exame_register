<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Vizsganyilvántartó</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Vizsganyilvántartó</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Főoldal <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add.php">Tárgyfelvétel</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add_feladat.php">Feladatfelvétel</a>
            </li>
            <div class="navbar-nav">
              <?php if ($userStorage->isAuthenticated()): ?>
                <a class="navbar-item" href="logout.php">
                  Kijelentkezés (<?= $userStorage->user["fullname"] ?>)
                </a>
              <?php else : ?>
                <a class="navbar-item" href="login.php">Bejelentkezés</a>
              <?php endif; ?>
            </div>
          </ul>
        </div>
      </nav>

      <div class="container">

