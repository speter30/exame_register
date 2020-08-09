<?php
include("utils/utils.php");
include("utils/storage.php");

$targyakStorage = new JsonStorage("storage/targyak.json");
$feladatokStorage = new JsonStorage("storage/feladatok.json");
$userStorage = new UserStorage();