<?php

include('model/lieuModel.php');
include('bdd/bdd.php');

$lieu = new Lieu($bdd);
$lesLieux = $lieu->selectAllLieux();
