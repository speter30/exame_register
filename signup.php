<?php
session_start();

include("utils/utils.php");
include("utils/storage.php");
 
$targyakStorage = new JsonStorage("storage/targyak.json");
$feladatokStorage = new JsonStorage("storage/feladatok.json");
$userStorage = new UserStorage();

$errors = [];

if (verify_post("username", "jelszo", "jelszo_ismet", "teljes_nev")) {
    $username = $_POST["username"];
    $jelszo = $_POST["jelszo"];
    $jelszo_ismet = $_POST["jelszo_ismet"];
    $teljes_nev = $_POST["teljes_nev"];
  
    if (empty($username)) {
      $errors[] = "A felhasználónév kitöltése kötelező!";
    }
  
    if ($userStorage->findOne([ "username" => $username ])) {
      $errors[] = "A megadott felhasználónév már létezik!";
    }
  
    if (strlen($jelszo) < 8) {
      $errors[] = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";
    }
  
    if ($jelszo !== $jelszo_ismet) {
      $errors[] = "Hibás jelszó megerősítés!";
    }
  
    if (empty($teljes_nev)) {
      $errors[] = "A név megadás kötelező!";
    } 
    
    if ($teljes_nev == trim($teljes_nev) && strpos($teljes_nev, ' ') == FALSE) {
      $errors[] = "Vezeték- és keresztnév megadása kötelező!";
    }
  
    if (!verify_post("tac")) {
      $errors[] = "A felhasználási feltételek és az adatkezelési szabályzat elfogadása kötelező!";
    }
  
    if (empty($errors)) {
      $felhasznalo_id = $userStorage->register($username, $jelszo, $teljes_nev);
      $userStorage->login($felhasznalo_id);
      redirect("index.php");
    }
  }
  
  ?>
  <?php include("partials/header.php"); ?>
  
  <form method="post" action="signup.php">
    <h1>Regisztráció</h1>
    <div class="form-group">
      <label for="username">Felhasználónév</label>
      <input type="text" class="form-control" id="username" name="username" value="<?= $username ?? "" ?>">
    </div>
    <div class="form-group">
      <label for="jelszo">Jelszó</label>
      <input type="password" class="form-control" id="jelszo" name="jelszo">
    </div>
    <div class="form-group">
      <label for="jelszo_ismet">Jelszó ismét</label>
      <input type="password" class="form-control" id="jelszo_ismet" name="jelszo_ismet">
      <small class="text-muted">A jelszónak legalább 8 karakter hosszúnak kell lennie</small>
    </div>
    <div class="form-group">
      <label for="teljes_nev">Teljes név</label>
      <input type="text" class="form-control" id="teljes_nev" name="teljes_nev" value="<?= $teljes_nev ?? "" ?>">
      <small class="text-muted">Vezeték- és keresztnév megadása is kötelező.</small>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" id="tac" name="tac">
      <label class="form-check-label" for="tac">Elfogadom a felhasználási feltételeket és az adatkezelési szabályzatot.</label>
    </div>
    <button type="submit" class="btn btn-primary">Regisztráció</button>
    <a href="login.php">Már regisztrált? Jelentkezzen be itt!</a>
  </form>
  
  
  <?php include("partials/footer.php"); ?>