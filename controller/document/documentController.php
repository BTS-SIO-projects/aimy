<?php

include($_SERVER['DOCUMENT_ROOT'] . '/aimy_new/model/documentModel.php');
include($_SERVER['DOCUMENT_ROOT'] . '/aimy_new/model/rdvModel.php');
include($_SERVER['DOCUMENT_ROOT'] . '/aimy_new/model/medecinModel.php');
include($_SERVER['DOCUMENT_ROOT'] . '/aimy_new/model/patientModel.php');
include($_SERVER['DOCUMENT_ROOT'] . '/aimy_new/bdd/bdd.php');

// créer un objet $rdv grace au rdvModel, stocker les rdv dan $lesRdvs
$rdv = new Rdv($bdd);
if (isset($_SESSION['idpatient'])) {
    $lesRdvs = $rdv->selectWhereRdvPatient($_SESSION['idpatient']);
} else {
    $lesRdvs = $rdv->selectWhereRdvMedecin($_SESSION['idmedecin']);
}
$medecin = new Medecin($bdd);
$patient = new Patient($bdd);

if (isset($_POST['action'])) {

    $documentController = new DocumentController($bdd);

    switch ($_POST['action']) {

        case 'ajouter':
            $documentController->create();
            break;
        case 'supprimer':
            $documentController->delete();
            break;
    }
}

class DocumentController
{
    private $document;

    function __construct($bdd)
    {
        $this->document = new Document($bdd);
    }

    public function create()
    {
        $fileType = $_FILES['url']['type'];
        $tmpFilePath = $_FILES['url']['tmp_name']; // Fichier temporaire
        $originalFileName = $_FILES['url']['name'];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        $newFileName = 'document_' . uniqid() . '.' . $fileExtension;
        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/aimy_new/document/' . $newFileName;

        // Déplacer le fichier vers le dossier cible
        if (move_uploaded_file($tmpFilePath, $destinationPath)) {
            $description = $_POST['description'];
            $idrdv = $_POST['idrdv'];

            $date = new DateTime();
            $datedepot = $date->format('Y-m-d');
            $idmedecin = $_POST['idmedecin'] ?? null;
            $idpatient = $_POST['idpatient'] ?? null;

            // Insérer le document dans la base de données avec le bon chemin
            $this->document->ajouterDocument($idrdv, $description, $fileType, 'document/' . $newFileName, $datedepot, $idmedecin, $idpatient);

            //    header('Location: http://localhost/aimy_new/?success=document_added');
            header("Location: ../../index.php?success=document_added");

            exit();
        } else {
            die("Erreur lors du téléchargement du fichier.");
        }
    }

    public function delete()
    {

        //verif

        $this->document->supprimerDocument($_POST['iddocument']);

        //redirection 
        //   header('Location:http://localhost/aimy_new/');
        header("Location: ../../index.php");
    }
}
