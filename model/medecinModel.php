<?php
class Medecin
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function selectAllMedecins()
    {
        $requete = "select * from medecin ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesMedecins = $select->fetchAll();
        return $lesMedecins;
    }

    public function selectWhereMedecin($idmedecin)
    {
        $requete = "select * from medecin where idmedecin=" . $idmedecin . ";";
        $select = $this->bdd->prepare($requete);
        $select->execute();
        $unMedecin = $select->fetch();
        return $unMedecin;
    }

    // enregistre les données du nouveau médecin dans la table temporaire medecinListe, 
    // l'administrateur va ensuite récupérer les données de cette table et valider ou non l'inscription
    public function ajouterMedecin($tab, $hashedPassword, $photo)
    {
        $requete = "INSERT INTO medecin (nom, prenom, email, password, telephone, photo, idspecialite, idlieu) 
                    VALUES (:nom, :prenom, :email, :password, :telephone, :photo, :specialite, :lieu)";

        // Préparation de la requête
        $select = $this->bdd->prepare($requete);

        // Exécution avec les valeurs associées
        $select->execute([
            ':nom'        => $tab['nom'],
            ':prenom'     => $tab['prenom'],
            ':email'      => $tab['email'],
            ':password'   => $hashedPassword,
            ':telephone'  => $tab['telephone'],
            ':photo'      => $photo,
            ':specialite' => $tab['specialite'],
            ':lieu'       => $tab['lieu']
        ]);
    }


    public function selectLikeMedecin($filtre)
    {
        $requete = "select * from medecin where nom like '%" . $filtre . "%' or prenom like '%" . $filtre . "%';";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesMedecins = $select->fetchAll();
        return $lesMedecins;
    }

    public function modifier($tab, $hashedPassword, $photo)
    {
        $requete = "update medecin set nom='"
            . $tab['nom'] . "', prenom='"
            . $tab['prenom'] . "',email='"
            . $tab['email'] . "', password='"
            . $hashedPassword . "', telephone ='"
            . $tab['telephone'] . "', photo ='"
            . $photo . "', idspecialite='"
            . $tab['specialite'] . "' "
            . " where idmedecin=" . $tab['idmedecin'] . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }

    public function supprimerMedecin($idmedecin)
    {
        $requete = "delete from medecin where idmedecin=" . $idmedecin . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }

    /***** Requete de vérification de connexion ****/
    public function connexionMedecin($email, $password)
    {
        $requete = "select * from medecin where email='" . $email . "' and password='" . $password . "' and statut = 'valider' ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        return $select->fetch();
    }

    public function existeDeja($nom, $prenom, $email)
    {
        $sql = "SELECT COUNT(*) FROM medecin WHERE nom = :nom OR prenom = :prenom OR email = :email";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email
        ]);
        return $stmt->fetchColumn() > 0;
    }
}
