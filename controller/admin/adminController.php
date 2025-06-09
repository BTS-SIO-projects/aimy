<?php
include_once('model/medecinModel.php');

// Initialisation de la connexion à la base de données
include('bdd/bdd.php'); // Assurez-vous que $bdd est défini dans ce fichier
$medecinModel = new Medecin($bdd);

// Mise à jour du statut
if (isset($_GET['action'], $_GET['id'], $_GET['statut']) && $_GET['action'] === 'update') {
    $idmedecin = intval($_GET['id']);
    $statut = $_GET['statut'];

    $statuts_valides = ['en attente', 'valider', 'refuser'];
    if (in_array($statut, $statuts_valides)) {
        $medecinModel->updateStatutMedecin($idmedecin, $statut);
        // Redirection pour éviter la re-soumission du formulaire
        header('Location: index.php?page=admin');
        exit();
    } else {
        echo "Statut invalide.";
    }
}

// Récupération de tous les médecins
$medecins = $medecinModel->getAllMedecins();

// Charge la vue
include('view/admin/admin.php');