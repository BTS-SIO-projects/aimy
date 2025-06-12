<?php
@include('../../bdd/bdd.php');
@include_once('model/medecinModel.php'); // assure-toi que le modèle est bien inclus
$medecin = new Medecin($bdd);
$specialite = isset($_GET['specialite']) ? $_GET['specialite'] : '';
$medecins = $medecin->rechercherParSpecialite($specialite);
