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

public function searchMesPatients($filtre)
{
    // On récupère l'id du médecin connecté
    $idMedecin = $_SESSION['idmedecin'];

    // Requête SQL pour obtenir les patients ayant un rdv avec ce médecin et correspondant au filtre
    $requete = "
        SELECT DISTINCT p.*
        FROM patient p
        INNER JOIN rdv r ON p.idpatient = r.idpatient
        WHERE r.idmedecin = :idmedecin
        AND (p.nom LIKE :filtre OR p.prenom LIKE :filtre)
    ";

    // Préparation de la requête
    $select = $this->bdd->prepare($requete);

    // Exécution avec les paramètres
    $select->execute([
        'idmedecin' => $idMedecin,
        'filtre' => '%' . $filtre . '%'
    ]);

    // Extraction des données
    $mesPatients = $select->fetchAll();

    return $mesPatients;
}
public function getAllMedecins() {
    $requete = "SELECT m.*, s.categorie as specialite, l.nom as lieu 
                FROM medecin m 
                LEFT JOIN specialite s ON m.idspecialite = s.idspecialite 
                LEFT JOIN lieu l ON m.idlieu = l.idlieu";
    $select = $this->bdd->prepare($requete);
    $select->execute();
    return $select->fetchAll();
}

public function updateStatutMedecin($idmedecin, $statut) {
    $requete = "UPDATE medecin SET statut = :statut WHERE idmedecin = :idmedecin";
    $select = $this->bdd->prepare($requete);
    $select->execute([
        ':statut' => $statut,
        ':idmedecin' => $idmedecin
    ]);
}

}