<?php
session_start();

include('../../model/medecinModel.php');
include('../../model/lieuModel.php');
include('../../model/specialiteModel.php');
include('../../bdd/bdd.php');

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

        //verif
        $email = $_POST['email'];
        $password = $_POST['password'];
        $secondPassword = $_POST['secondpassword'];
        $file = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileType = $_FILES['photo']['type'];
        $fileContent = file_get_contents($file);
        //on vérifie si le patient et si les infos sont conformes
        $unMedecin = $this->medecin->connexionMedecin($email, $password);
        //var_dump($unPatient);
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['secondpassword']) && isset($_POST['telephone']) && isset($_POST['specialite'])) {
            if ($unMedecin == null) {
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
            } else {
                echo "l'email est déjà utilisé.";
            }
        } else {
            echo "veuillez remplir tous les champs.";
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
