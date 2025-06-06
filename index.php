<?php
session_start();

include('view/commun/header.php');
include('bdd/bdd.php');

//system de routing

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    case 'accueil':
        include('view/commun/accueil.php');
        break;

    case 'patient':
        include('model/patientModel.php');
        include('view/patient/patient.php');
        break;

    case 'medecin':
        include('controller/specialite/specialiteController.php');
        include('controller/lieu/selectAllLieux.php');
        include('view/medecin/medecin.php');
        break;

    case 'rdv':
        require_once('bdd/bdd.php');
        require_once('model/medecinModel.php');
        require_once('model/patientModel.php');
        include('model/specialiteModel.php');
        include('controller/lieu/selectAllLieux.php');
        include('controller/medecin/selectAllMedecins.php');
        include('controller/medecin/medecinController.php');

        include('view/rdv/rdv.php');
        break;

    case 'liste_rdv':
        require_once('bdd/bdd.php');
        require_once('model/patientModel.php');
        require_once('model/medecinModel.php');
        require_once('model/lieuModel.php');
        require_once('model/documentModel.php');
        require_once('model/rdvModel.php');
        include('view/rdv/liste_rdv.php');
        break;

    case 'liste_patients':
        include('bdd/bdd.php');
        include('model/medecinModel.php');
        include('model/patientModel.php');
        include('controller/medecin/selectAllMedecins.php');
        include('view/medecin/liste_patients.php');
        break;

    case 'document':
        include('model/documentModel.php');
        include('model/rdvModel.php');
        include('model/medecinModel.php');
        include('model/patientModel.php');
        include('controller/document/documentController.php');
        include('view/document/document.php');
        break;

    case 'faq':
        include('view/commun/faq.php');
        break;

    case 'profil':
        include('model/rdvModel.php');
        include('model/patientModel.php');
        include('model/medecinModel.php');
        include('model/lieuModel.php');
        include('model/documentModel.php');
        include('model/specialiteModel.php');
        include('controller/rdv/listeRdvController.php');
        include('view/commun/profil.php');
        break;

    case 'deconnexion':
        session_destroy();
        unset($_SESSION['numeroSecu']);
        header('Location: index.php');
        break;
    default:
        include('view/commun/accueil.php');
        break;
}


include('view/commun/footer.php');
