<?php

use Dom\Document;

include('../../model/rdvModel.php');
include('../../bdd/bdd.php');
include('../medecin/medecinController.php');

if (isset($_POST['action'])) {

    $rdvController = new RdvController($bdd);

    switch ($_POST['action']) {

        case 'ajouter':
            $rdvController->create();
            break;
    }
}

class RdvController
{
    private $rdv;

    function __construct($bdd)
    {
        $this->rdv = new Rdv($bdd);
    }

    public function create()
    {

        //verif
        $date = $_POST['daterdv'];
        $heure = $_POST['heurerdv'];
        $motif = $_POST['motif'];
        $lieu = $_POST['idlieu'];
        $medecin = $_POST['idmedecin'];
        //    $statut = $_POST['statut'];

        $existOne = $this->rdv->selectLikeRdvOne($date, $heure, $_SESSION['idpatient']);
        $existTwo = $this->rdv->selectLikeRdvOne($date, $heure, $medecin);

        if ($existOne || $existTwo) {
            var_dump("rdv existant");
            header('Location: ../../');
        } else {
            $this->rdv->ajouterRdv($_POST);
            header('Location: ../../index.php?page=liste_rdv');
        }
    }
    /*
    public function delete($document)
    {

        //verif
        var_dump($_POST['ID_rdv']);
        die();
        $document->supprimerDocuments($_POST['ID_rdv']);
        $this->rdv->supprimerRdv($_POST['ID_rdv']);

        //redirection 
        header('Location:http://localhost/aimy_new/index.php?page=liste_rdv');
    }
        */
}
