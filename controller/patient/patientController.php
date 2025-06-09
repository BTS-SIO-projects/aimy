<?php
session_start();
include('../../model/patientModel.php');
include('../../bdd/bdd.php');

// hashé le mot de passe
function PasswordCache($st)
{
    $st = sha1(md5($st));
    return $st;
}

if (isset($_POST['action'])) {

    $patientController = new PatientController($bdd);

    switch ($_POST['action']) {

        case 'inscription':
            $patientController->create();
            break;
        case 'supprimer':
            $patientController->delete();
            break;
        case 'connexion':
            $patientController->connexion();
            break;
        default:
            # code...
            break;
    }
}

class PatientController
{
    private $patient;

    function __construct($bdd)
    {
        $this->patient = new Patient($bdd);
    }

    public function create()
    {

        //verif 
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $age = isset($_POST['age']) ? intval($_POST['age']) : null;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $secondPassword = $_POST['secondpassword'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];
        $numeroSecu = $_POST['numeroSecu'];

        //on vérifie si le patient et si les infos sont conformes
        $unPatient = $this->patient->connexionPatient($numeroSecu, $password);

        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['email']) && isset($_POST['password'])  && isset($_POST['secondpassword']) && isset($_POST['telephone']) && isset($_POST['adresse']) && isset($_POST['numeroSecu'])) {
            if ($unPatient == null) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Supprimer les espaces éventuels
                    $nir = str_replace(' ', '', $numeroSecu);
                    // Vérifier la longueur
                    if (strlen($nir) == 15) {
                        // Vérifier que les 13 premiers caractères sont des chiffres
                        if (ctype_digit(substr($nir, 0, 13))) {
                            // Calculer la clé de contrôle
                            $cle = 97 - (int)substr($nir, 0, 13) % 97;
                            //if ($cle == (int)substr($nir, 13, 2)) {
                            if ($password == $secondPassword) {
                                $hashedPassword = PasswordCache($password);
                                //insertion du patient
                                $patient = $this->patient->ajouterPatient($_POST, $hashedPassword);
                                //une fois ajouté le patient on recupere les info du patient avec son email
                                $getPatient = $this->patient->selectPatientByEmail($email);
                                $_SESSION['idpatient'] = $getPatient['idpatient'];
                                $_SESSION['numeroSecu'] = $unPatient['numeroSecu'];
                                //creation d'une session
                                $_SESSION['nom'] = $nom;
                                $_SESSION['prenom'] = $prenom;
                                $_SESSION['email'] = $email;
                                $_SESSION['telephone'] = $telephone;
                                $_SESSION['lieu'] = $adresse;

                                header('Location: ../../index.php');
                            } else {
                                echo "Les mots de passes ne correspondent pas.";
                            }
                            //  } else {
                            echo "Le numéro de sécurité sociale est invalide.";
                            // }
                        } else {
                            echo "Le numéro de sécurité sociale doit contenir 13 chiffres.";
                        }
                    } else {
                        echo "Le numéro de sécurité sociale doit contenir 15 caractères.";
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

        $this->patient->supprimerPatient($_POST['ID_Medecin']);

        //redirection 
        header('Location: ../../index.php');
    }

    public function connexion()
    {

        //verif
        $numeroSecu = $_POST['numeroSecu'];
        $password = $_POST['password'];
        if (!empty($numeroSecu) && !empty($password)) {
            $hashedPassword = PasswordCache($password);
            //on récupère le patient dans la base 
            $unPatient = $this->patient->connexionPatient($numeroSecu, $hashedPassword);
            //var_dump($unChauffeur);
            if ($unPatient != null) {
                //creation d'une session
                $_SESSION['idpatient'] = $unPatient['idpatient'];
                $_SESSION['numeroSecu'] = $unPatient['numeroSecu'];
                $_SESSION['nom'] = $unPatient['nom'];
                $_SESSION['prenom'] = $unPatient['prenom'];
                $_SESSION['telephone'] = $unPatient['telephone'];
                $_SESSION['lieu'] = $unPatient['adresse'];
                $_SESSION['email'] = $unPatient['email'];
                //                header("Location: ../../index.php?page=accueil");
                header("Location: ../../index.php?page=accueil");
            } else {
                echo "<br> Veuillez vérifier vos identifiants.";
            }
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }
}
