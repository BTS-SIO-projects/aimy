<?php
// MODELE DU RDV, RAJOUTER DES FONCTIONS SI BESOIN

class Rdv
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function selectAllRdvs()
    {
        $requete = "select * from rdv ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesRdvs = $select->fetchAll();
        return $lesRdvs;
    }

    public function selectWhereRdv($idrdv)
    {
        $requete = "select * from rdv where idrdv=" . $idrdv . ";";
        $select = $this->bdd->prepare($requete);
        $select->execute();
        $unRdv = $select->fetch();
        return $unRdv;
    }

    // Chercher tous les rdvs d'un patient avec l'id $idpatient
    public function selectWhereRdvPatient($idpatient)
    {
        $requete = "SELECT * FROM rdv WHERE idpatient = ?;";
        $select = $this->bdd->prepare($requete);
        $select->execute([$idpatient]); // Paramètre sécurisé
        $lesRdvs = $select->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes avec des clés associatives
        return $lesRdvs;
    }

    // Chercher tous les rdvs d'un medecin avec l'id $idmedecin
    public function selectWhereRdvMedecin($idmedecin)
    {
        $requete = "SELECT * FROM rdv WHERE idmedecin = ?;";
        $select = $this->bdd->prepare($requete);
        $select->execute([$idmedecin]); // Paramètre sécurisé
        $lesRdvs = $select->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes avec des clés associatives
        return $lesRdvs;
    }

    public function selectNextWhereRdvPatient($idpatient)
    {
        $requete = "SELECT * FROM rdv WHERE idpatient = ?AND dateRdv BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 14 DAY);";
        $select = $this->bdd->prepare($requete);
        $select->execute([$idpatient]); // Paramètre sécurisé
        $lesRdvs = $select->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes avec des clés associatives
        return $lesRdvs;
    }

    // Chercher tous les rdvs d'un medecin avec l'id $idmedecin
    public function selectNextWhereRdvMedecin($idmedecin)
    {
        $requete = "SELECT * FROM rdv WHERE idmedecin = ? AND dateRdv BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 14 DAY);";
        $select = $this->bdd->prepare($requete);
        $select->execute([$idmedecin]); // Paramètre sécurisé
        $lesRdvs = $select->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes avec des clés associatives
        return $lesRdvs;
    }

    public function selectLikeRdvOne($date, $heure, $idPatient)
    {
        $requete = "SELECT * FROM rdv WHERE daterdv = :date AND heureRdv = :heure AND idpatient = :idPatient";
        // Préparation de la requête
        $select = $this->bdd->prepare($requete);
        // Liaison des paramètres
        $select->bindParam(':date', $date);
        $select->bindParam(':heure', $heure);
        $select->bindParam(':idPatient', $idPatient);
        // Exécution de la requête
        $select->execute();
        // Extraction des données
        $rdv = $select->fetch();
        return $rdv;
    }


    public function selectLikeRdvTwo($date, $heure, $idMedecin)
    {
        $requete = "SELECT * FROM rdv WHERE daterdv = :date AND heureRdv = :heure AND idmedecin = :idMedecin";
        // Préparation de la requête
        $select = $this->bdd->prepare($requete);
        // Liaison des paramètres
        $select->bindParam(':date', $date);
        $select->bindParam(':heure', $heure);
        $select->bindParam(':idMedecin', $idMedecin);
        // Exécution de la requête
        $select->execute();
        // Extraction des données
        $rdv = $select->fetch();
        return $rdv;
    }

    public function ajouterRdv($tab)
    {
        $requete = "INSERT INTO rdv (daterdv, heurerdv, motif, idmedecin, idpatient, idlieu) 
                    VALUES (:daterdv, :heurerdv, :motif, :idmedecin, :idpatient, :idlieu)";
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':daterdv', $tab['daterdv']);
        $select->bindParam(':heurerdv', $tab['heurerdv']);
        $select->bindParam(':motif', $tab['motif']);
        $select->bindParam(':idmedecin', $tab['idmedecin']);
        $select->bindParam(':idpatient', $tab['idpatient']);
        $select->bindParam(':idlieu', $tab['idlieu']);
        //    $select->bindParam(':statut', $tab['statut']);
        $select->execute();
    }

    public function modifierRdv($tab)
    {
        $requete = "update rdv set daterdv='"
            . $tab['daterdv'] . "', heureRdv='"
            . $tab['heurerdv'] . "', motif='"
            . $tab['motif'] . "', idmedecin='"
            . $tab['medecin'] . "', idpatient='"
            . $tab['idpatient'] . "', idlieu ='"
            . $tab['lieu'] . "' "
            . " where idrdv=" . $tab['idrdv'] . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }


    /*
    public function validerRdv($idRdv)
    {
        $sql = "UPDATE rdv SET statut = 'valider' WHERE idrdv = :idrdv";
        $stmt = $this->bdd->prepare($sql);
        $stmt->bindParam(':idrdv', $idRdv, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function refuserRdv($idRdv)
    {
        $sql = "UPDATE rdv SET statut = 'refuser' WHERE idrdv = :idrdv";
        $stmt = $this->bdd->prepare($sql);
        $stmt->bindParam(':idrdv', $idRdv, PDO::PARAM_INT);
        $stmt->execute();
    }

*/
    public function supprimerRdv($idrdv)
    {
        $requete = "delete from rdv where idrdv=" . $idrdv . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }
}
