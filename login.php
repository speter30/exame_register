<?php
session_start();

include("utils/utils.php");
include("utils/storage.php");
 
$targyakStorage = new JsonStorage("storage/targyak.json");
$feladatokStorage = new JsonStorage("storage/feladatok.json");
$userStorage = new UserStorage();

$errors = [];

if (verify_post("felhasznalonev", "jelszo")) {
    $felhasznalonev = $_POST["felhasznalonev"];
    $jelszo = $_POST["jelszo"];
  
    $felhasznalo_id = $userStorage->authenticate($felhasznalonev, $jelszo);
    if ($felhasznalo_id === FALSE) {
      $errors[] = "Hibás felhasználónév vagy jelszó!";
    }
  
    if (empty($errors)) {
      $userStorage->login($felhasznalo_id);
      redirect("index.php");
    }
  }

?>

<?php include("partials/header.php"); ?>

<form method="post" action="login.php">
  <h1>Bejelentkezés</h1>
  <div class="form-group">
    <label for="felhasznalonev">Felhasználónév</label>
    <input type="text" class="form-control" id="felhasznalonev" name="felhasznalonev" value="<?= $felhasznalonev ?? "" ?>">
  </div>
  <div class="form-group">
    <label for="jelszo">Jelszó</label>
    <input type="password" class="form-control" id="jelszo" name="jelszo">
  </div>
  <button type="submit" class="btn btn-primary">Bejelentkezés</button>
  <a href="signup.php">Új fiók létrehozása</a>
</form>

<?php include("partials/footer.php"); ?>