<?php

include('model/medecinModel.php');
include('model/patientModel.php');
include('bdd/bdd.php');

$medecin = new Medecin($bdd);
$lesMedecins = $medecin->selectAllMedecins();

$patient = new Patient($bdd);
$lesPatients = $patient->selectAllPatients();

if (isset($_SESSION['idmedecin'])) {
    $patient2 = new Patient($bdd);
    $mesPatients = $patient2->selectMesPatients();
}
