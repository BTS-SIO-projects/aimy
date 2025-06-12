<?php
class Patient
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    /* section 1 : les requetes de selection sur les tables */
    public function selectAllPatients()
    {
        $requete = "select * from patient ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesPatients = $select->fetchAll();
        return $lesPatients;
    }

    public function selectMesPatients()
    {
        // On récupère l'id du médecin connecté
        $idMedecin = $_SESSION['idmedecin'];

        // Requête SQL pour obtenir les patients ayant un rdv avec ce médecin
        $requete = "
            SELECT DISTINCT p.*
            FROM patient p
            INNER JOIN rdv r ON p.idpatient = r.idpatient
            WHERE r.idmedecin = :idmedecin
        ";

        // Préparation de la requête
        $select = $this->bdd->prepare($requete);

        // Exécution avec le paramètre
        $select->execute(['idmedecin' => $idMedecin]);

        // Extraction des données
        $mesPatients = $select->fetchAll();

        return $mesPatients;
    }

    public function selectWherePatient($idpatient)
    {
        $requete = "select * from patient where idpatient=" . $idpatient . ";";
        $select = $this->bdd->prepare($requete);
        $select->execute();
        $unPatient = $select->fetch();
        return $unPatient;
    }

    public function selectPatientByEmail($email)
    {
        $requete = "select * from patient where email='" . $email . "';";
        $select = $this->bdd->prepare($requete);
        var_dump($select);
        $select->execute();
        $unPatient = $select->fetch();
        return $unPatient;
    }



    function ajouterPatient($tab, $hashedPassword)
    {
        $requete = "insert into patient values (null, '"
            . $tab['nom'] . "','"
            . $tab['prenom'] . "','"
            . $tab['age'] . "','"
            . $tab['email'] . "','"
            . $hashedPassword . "','"
            . $tab['telephone'] . "','"
            . $tab['adresse'] . "','"
            . $tab['numeroSecu'] . "') ; ";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $id = $select->execute();
        return $id;
    }

    public function selectLikePatient($filtre)
    {
        $requete = "select * from patient where nom like '%" . $filtre . "%' or prenom like '%" . $filtre . "%' or age like '%" . $filtre . "%';";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesPatients = $select->fetchAll();
        return $lesPatients;
    }

    public function modifierPatient($tab, $hashedPassword)
    {
        $requete = "update patient set nom='"
            . $tab['nom'] . "', prenom='"
            . $tab['prenom'] . "', age='"
            . $tab['age'] . "', email='"
            . $tab['email'] . "', password='"
            . $hashedPassword . "', telephone ='"
            . $tab['telephone'] . "', adresse='"
            . $tab['adresse'] . "', numeroSecu='"
            . $tab['numeroSecu'] . "', role='"
            . $tab['role'] . "' "
            . " where idpatient=" . $tab['idpatient'] . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }

    public function supprimerPatient($idpatient)
    {
        $requete = "delete from patient where idpatient=" . $idpatient . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }

    public function connexionPatient($numeroSecu, $password)
    {
        $requete = "select * from patient where numeroSecu='" . $numeroSecu . "' and password='" . $password . "' ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        return $select->fetch();
    }

    public function existeDeja($nom, $prenom, $email, $numeroSecu)
    {
        $sql = "SELECT COUNT(*) FROM patient WHERE nom = :nom OR prenom = :prenom OR email = :email OR numeroSecu = :numeroSecu";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'numeroSecu' => $numeroSecu
        ]);
        return $stmt->fetchColumn() > 0;
    }
}
