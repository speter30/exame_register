<?php
session_start();

include("utils/utils.php");
include("utils/storage.php");

$targyakStorage = new JsonStorage("storage/targyak.json");
$feladatokStorage = new JsonStorage("storage/feladatok.json");
$userStorage = new UserStorage();

$targyak = $targyakStorage->findAll(["user" => $userStorage->user["username"]]);

if (!$userStorage->authorize(["user"])) {
    redirect("login.php");
  }

$errors = [];

if (verify_post("targyneve", "szamonkeres", "feladatnev", "prioritas", "hatarido")) {
    $targyneve = trim($_POST["targyneve"]);
    $szamonkeres = trim($_POST["szamonkeres"]);
    $feladatnev = trim($_POST["feladatnev"]);
    $prioritas = trim($_POST["prioritas"]);
    $hatarido = trim($_POST["hatarido"]);

    if ($targyneve == "Tárgynév") {
        $errors[] = "Tárgynév megadása kötelező!";
      }
    if ($szamonkeres == "Számonkérés formája") {
        $errors[] = "Számonkérés formájának megadása kötelező!";
      }
    if (empty($feladatnev)) {
        $errors[] = "Feladat megadása kötelező!";
      }
    if (!preg_match("/^[1-5]$/", $prioritas)) {
        $errors[] = "Hibás prioritási érték!";
      }
    if (!preg_match("/^(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1])\s(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])$/", $hatarido)) {
        $errors[] = "Hibás dátumformátum!";
      }
        // ha ezek után üres az error tömb akkor hozzáadom
    if (empty($errors)) {
        $uj_feladat = [
            "targyneve" => $targyneve,
            "szamonkeres" => $szamonkeres,
            "feladatnev" => $feladatnev,
            "prioritas" => $prioritas,
            "hatarido" => $hatarido,
            "user" => $userStorage->user["username"]
            ];
            $feladatokStorage->add($uj_feladat);
        }
}

?>

<?php include("partials/header.php"); ?>
<div class ="container">
<form method="post" action="add_feladat.php">
<h1>Feladat hozzáadása</h1>
  <br>
    <div class="dropdown">
            <select name="targyneve" id="targyneve">
            <option value="Tárgynév">Tárgynév</option>
                <?php foreach($targyak as $targy){ 
                echo "<option value= \"".$targy["kod"]."\">".$targy["nev"]."</option>";
            }?>  
  </select>
    </div>
    <div class="dropdown">
        <br>
            <select name="szamonkeres">
                <option value="Számonkérés formája" > Számonkérés formája </option>
                <option value="ZH" <?= ($szamonkeres ?? "") === "ZH" ? " selected" : "" ?>> ZH </option>
                <option value="Beadandó" <?= ($szamonkeres ?? "") === "Beadandó" ? " selected" : "" ?>> Beadandó</option>
                <option value="Beszámoló" <?= ($szamonkeres ?? "") === "Beszámoló" ? " selected" : "" ?>> Beszámoló</option>
                <option value="Vizsga" <?= ($szamonkeres ?? "") === "Vizsga" ? " selected" : "" ?>> Vizsga</option>
                <option value="Egyéb" <?= ($szamonkeres ?? "") === "Egyéb" ? " selected" : "" ?>> Egyéb</option>
            </select>
            </div>
    <br>
    <div class="form-group">
        <label for="title">Feladat neve</label>
        <input type="text" name="feladatnev" id="feladatnev" class="form-control" value="<?= $feladatnev ?? "" ?>">
    </div>
    <div class="form-group">
        <label for="title">Prioritás</label>
        <input type="text" name="prioritas" id="prioritás" class="form-control" value="<?= $prioritas ?? "" ?>">
        <small class="text-muted">Értékek: <code>1-5</code></small> 
    </div>
    <div class="form-group">
        <label for="title">Határidő</label>
        <input type="text" name="hatarido" id="hatarido" class="form-control" value="<?= $hatarido ?? "" ?>">
        <small class="text-muted">Formátum: <code>hh.nn óó:pp</code></small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Feladat felvétele</button>
</form>


<?php include("partials/footer.php"); ?>