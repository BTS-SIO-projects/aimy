<?php
@session_start();

@include('../../bdd/bdd.php');
@include('../../model/patientModel.php');
@include('../../model/lieuModel.php');
@include('../../model/specialiteModel.php');
@include('../../model/medecinModel.php');

$lieu = new Lieu($bdd);
$specialite = new Specialite($bdd);



// hashé le mot de passe
function PasswordCache($st)
{
    $st = sha1(md5($st));
    return $st;
}

if (isset($_POST['action'])) {

    $medecinController = new MedecinController($bdd);

    switch ($_POST['action']) {

        case 'inscription':
            $medecinController->create();
            break;
        case 'supprimer':
            $medecinController->delete();
            break;
        case 'connexion':
            $medecinController->connexion($lieu, $specialite);
            break;
        default:
            # code...
            break;
    }
}

class MedecinController
{
    private $medecin;

    function __construct($bdd)
    {
        $this->medecin = new Medecin($bdd);
    }

    public function create()
    {

        // Récupération des données
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $secondPassword = $_POST['secondpassword'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $specialite = $_POST['specialite'] ?? '';

        $file = $_FILES['photo']['tmp_name'] ?? null;
        $fileContent = $file ? file_get_contents($file) : null;

        if ($nom === '' || $prenom === '' || $email === '' || $password === '' || $secondPassword === '' || $telephone === '' || $specialite === '') {
            echo "Veuillez remplir tous les champs.";
            return;
        }

        if ($this->medecin->existeDeja($nom, $prenom, $email)) {
            echo "Un médecin avec ce nom, prénom ou email existe déjà.";
            return;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($password == $secondPassword) {
                $hashedPassword = PasswordCache($password);
                //insertion du medecin
                $this->medecin->ajouterMedecin($_POST, $hashedPassword, $fileContent);
                echo ("<p> Votre demande d'inscription sera prise en charge sous 48 heures.</p>");
                header('Location: ../../index.php?success=medecin_added');
                exit();
            } else {
                echo "Les mots de passes ne correspondent pas.";
            }
        } else {
            echo "L'adresse email n'est pas valide.";
        }
    }

    public function delete()
    {

        //verif

        $this->medecin->supprimerMedecin($_POST['ID_Medecin']);

        //redirection 
        header('Location: ../../index.php');
    }

    public function connexion($lieu, $specialite)
    {
        //verif
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (!empty($email) && !empty($password)) {
            $hashedPassword = PasswordCache($password);
            //on récupère le patient dans la base 
            $unMedecin = $this->medecin->connexionMedecin($email, $hashedPassword);
            $unLieu = $lieu->selectWhereLieu($unMedecin['idlieu']);
            $uneSpecialite = $specialite->selectWhereSpecialite($unMedecin['idspecialite']);

            //var_dump($unChauffeur);
            if ($unMedecin != null) {
                //creation d'une session
                $_SESSION['idmedecin'] = $unMedecin['idmedecin'];
                $_SESSION['email'] = $unMedecin['email'];
                $_SESSION['nom'] = $unMedecin['nom'];
                $_SESSION['prenom'] = $unMedecin['prenom'];
                $_SESSION['telephone'] = $unMedecin['telephone'];
                $_SESSION['specialite'] = $uneSpecialite['categorie'];
                $_SESSION['photo'] = $unMedecin['photo'];
                $_SESSION['lieu'] = $unLieu['nom'];
                //        header("Location: ../../index.php?page=accueil");
                header("Location: ../../index.php?page=accueil");
            } else {
                echo "<br> Veuillez vérifier vos identifiants.";
            }
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }
}
