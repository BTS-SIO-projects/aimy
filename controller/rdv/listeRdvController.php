<?php

@include('../../bdd/bdd.php');
@include('../../model/patientModel.php');
@include('../../model/rdvModel.php');
@include('../../model/medecinModel.php');
@include('../../model/lieuModel.php');
@include('../../model/documentModel.php');

$rdv = new Rdv($bdd);
$patient = new Patient($bdd);
$medecin = new Medecin($bdd);
$lieu = new Lieu($bdd);
$document = new Document($bdd);




if (isset($_SESSION['idpatient'])) {
    $lesRdvs = $rdv->selectWhereRdvPatient($_SESSION['idpatient']);
    $lesProchainsRdvs = $rdv->selectNextWhereRdvPatient($_SESSION['idpatient']);
} else if (isset($_SESSION['idmedecin'])) {
    $lesRdvs = $rdv->selectWhereRdvMedecin($_SESSION['idmedecin']);
    $lesProchainsRdvs = $rdv->selectNextWhereRdvMedecin($_SESSION['idmedecin']);
}

if (isset($_POST['action'])) {
    // Debug des données reçues
    // var_dump($_POST); // Supprimez cette ligne en production

    switch ($_POST['action']) {
        case 'supprimer':
            if (isset($_POST['idrdv']) && !empty($_POST['idrdv'])) {
                $document->supprimerDocuments($_POST['idrdv']);
                $rdv->supprimerRdv($_POST['idrdv']);
                header('Location: ../../index.php?page=liste_rdv');
            }
            break;
        case 'valider':
            if (isset($_POST['idrdv']) && !empty($_POST['idrdv'])) {
                $rdv->validerRdv($_POST['idrdv']);
            }
            break;
        case 'refuser':
            if (isset($_POST['idrdv']) && !empty($_POST['idrdv'])) {
                $rdv->refuserRdv($_POST['idrdv']);
            }
            break;
        default:
            echo "Action inconnue : " . htmlspecialchars($_POST['action']);
            break;
    }

    header('Location: ../../index.php?page=liste_rdv');
    exit;
} else {
    //   echo "Aucune action reçue.";
}


?>
</table>