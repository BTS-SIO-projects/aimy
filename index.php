<?php
session_start();

include('view/commun/header.php');

//system de routing

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    case 'accueil':
        include('view/commun/accueil.php');
        break;

    case 'patient':
        include('view/patient/patient.php');
        break;

    case 'medecin':
        include('view/medecin/medecin.php');
        break;

    case 'rdv':
        include('view/rdv/rdv.php');
        break;

    case 'liste_rdv':
        include('view/rdv/liste_rdv.php');
        break;

    case 'liste_patients':
        include('view/medecin/liste_patients.php');
        break;

    case 'document':
        include('view/document/document.php');
        break;

    case 'faq':
        include('view/commun/faq.php');
        break;

    case 'profil':
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
