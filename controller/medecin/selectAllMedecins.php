<?php

include('model/medecinModel.php');
include('model/patientModel.php');
include('bdd/bdd.php');

$medecin = new Medecin($bdd);
$lesMedecins = $medecin->selectAllMedecins();

$patient = new Patient($bdd);
$lesPatients = $patient->selectAllPatients();
