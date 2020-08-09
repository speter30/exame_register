<?php
session_start();

include("utils/utils.php");
include("utils/storage.php");

//json storage létrehozása
$targyakStorage = new JsonStorage("storage/targyak.json");
$feladatokStorage = new JsonStorage("storage/feladatok.json");
$userStorage = new UserStorage();

$errors = [];

if (!$userStorage->authorize(["user"])) {
  redirect("login.php");
}

$targyak = $targyakStorage->findAll();
//$feladatok = $feladatokStorage->findAll();
$feladatok = $feladatokStorage->findAll(["user"=> $userStorage->user["username"]]);


$id = $targyakStorage->findById("id");
$feladat_id = $feladatokStorage->findById("id");

//kész gombbal törlés
if (verify_post("delete")) {
    $delete = $_POST["delete"];
    
    if ($feladat_id === $delete) {
      $feladatokStorage->delete($feladat_id);
      redirect("index.php");
    }
}

?>

<?php include("partials/header.php"); ?>
<h1>Számonkéréseim</h1>
  <br>
<!--kártya-->
<div class="container">
<div class="row">
    <?php foreach ($feladatok as $id => $feladat): $targy = $targyakStorage->findOne(["kod" => $feladat["targyneve"]]); ?>
        <div class="card  mt-3 ml-3" style="width: 16rem;">
          <div class="card-body">
            

            <h5 class="card-title">
            <?php if (isset($targy["nev"])): ?>
              <p class="card-text"><?= $targy["nev"] ?></p>
            <?php endif; ?>
            </h5>

            <h6 class="card-title"><?= $feladat["targyneve"] ?></h6>

            <?php if (isset($feladat["szamonkeres"])): ?>
            <p class="card-text">Számonkérés: <?= $feladat["szamonkeres"] ?></p>
            <?php endif; ?>

            <?php if (isset($feladat["feladatnev"])): ?>
            <p class="card-text">Feladat: <?= $feladat["feladatnev"] ?></p>
            <?php endif; ?>

            <?php if (isset($feladat["hatarido"])): ?>
            <p class="card-text">Határidő: <?= $feladat["hatarido"] ?></p>
            <?php endif; ?>

            <?php if (isset($feladat["prioritas"])): ?>
            <p class="card-text">Prioritás: <?= $feladat["prioritas"] ?></p>
            <?php endif; ?>

              <!--kitörli ha kész-->
            <form action="" method="post">
             <input type="hidden" name="delete" id="delete" value="<?= $feladat_id ?>">
             <button action="index.php" type="sumbit" class="btn btn-primary">Kész</button>
            </form>
          </div>
        </div>
    <?php endforeach; ?>
</div>
</div>

<?php include("partials/footer.php"); ?>