<?php

include('model/specialiteModel.php');
include('bdd/bdd.php');


$specialite = new Specialite($bdd);
$lesSpecialites = $specialite->selectAllSpecialites();
