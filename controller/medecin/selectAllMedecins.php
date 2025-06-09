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
    
    // Vérifier s'il y a un terme de recherche en session
    if (isset($_SESSION['search_term']) && !empty(trim($_SESSION['search_term']))) {
        $searchTerm = trim($_SESSION['search_term']);
        // Utiliser la méthode de filtrage avec le terme de recherche
        $mesPatients = $patient2->selectLikeMesPatients($searchTerm);
    } else {
        // Pas de recherche, afficher tous les patients du médecin
        $mesPatients = $patient2->selectMesPatients();
    }
}
