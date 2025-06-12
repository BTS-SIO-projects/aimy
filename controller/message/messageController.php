<?php

use Dom\Document;

@include('../../bdd/bdd.php');
@include('../../model/messageModel.php');

$message = new Message($bdd);

if (isset($_SESSION['idpatient'])) {
    $messages = $message->selectWhereMessages($_SESSION['idpatient']);
}

if (isset($_POST['action'])) {

    $messageController = new messageController($bdd);

    switch ($_POST['action']) {

        case 'ajouter':
            $messageController->create();
            break;
    }
}

class MessageController
{
    private $message;

    function __construct($bdd)
    {
        $this->message = new Message($bdd);
    }

    public function create()
    {
        session_start(); // Démarre la session si ce n'est pas déjà fait

        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $idpatient = $_POST['idpatient'];
        $idmedecin = $_POST['idmedecin'];

        $this->message->createMessage($titre, $description, $idmedecin, $idpatient);

        $_SESSION['success_message'] = "Message envoyé avec succès !";

        header('Location: ../../index.php?page=liste_rdv');
        exit();
    }
}
