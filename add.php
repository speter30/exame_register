<?php
session_start();

include("utils/utils.php");
include("utils/storage.php");

$userStorage = new UserStorage();
$targyakStorage = new JsonStorage("storage/targyak.json");

if (!$userStorage->authorize(["user"])) {
  redirect("login.php");
}

$errors = [];

//if ($nev === "") {
//    $errors[] = "Tárgynév megadása kötelező!";
//}
//
//if ($kod === "") {
//    $errors[] = "Tárgykód megadása kötelező!";
//}
// beolvasás
if (verify_post("nev", "kod")) {
    $nev = trim($_POST["nev"]);
    $kod = trim($_POST["kod"]);
    
    // ha üres a mező...
    if (empty($nev)) {
        $errors[] = "Tárgynév megadása kötelező!";
      }
    if (empty($kod)) {
        $errors[] = "Tárgykód megadása kötelező!";
      }
    // ha már van ilyen tárgy...
    if ($targyakStorage->findOne(["nev" => $nev, "user" => $userStorage->user["username"]]))  {
      $errors[] = "Ez a tantárgy már korábban fel lett véve";
    }
    // ha ezek után üres az error tömb, beszúrom
    if (empty($errors)) {
        $uj_targy = [
        "nev" => $nev,
        "kod" => $kod,
        "user" => $userStorage->user["username"]
        ];
        $targyakStorage->add($uj_targy);
      }
    

}

?>

<?php include("partials/header.php"); ?>

<h1>Tárgyfelvétel</h1>

<form method="post" action="add.php">
    <div class="form-group">
        <label for="title">Tárgy neve</label>
        <input type="text" name="nev" id="nev" class="form-control" value="<?= $nev ?? "" ?>">
    </div>
    <div class="form-group">
        <label for="title">Kód/rövidítés</label>
        <input type="text" name="kod" id="kod" class="form-control" value="<?= $kod ?? "" ?>">
    </div>

    <!-- számonkérés választása -->

    <br>
    <button type="submit" class="btn btn-primary">Tárgy felvétele</button>
    
</form>

<?php include("partials/footer.php"); ?>