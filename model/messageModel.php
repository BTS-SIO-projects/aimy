<?php
class Message
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function createMessage($titre, $description, $idmedecin, $idpatient)
    {
        $date = date('Y-m-d H:i:s');
        $requete = "INSERT INTO message (date, titre, description, idmedecin, idpatient) 
                    VALUES (:date, :titre, :description, :idmedecin, :idpatient)";
        $insert = $this->bdd->prepare($requete);
        $insert->execute([
            'date' => $date,
            'titre' => $titre,
            'description' => $description,
            'idmedecin' => $idmedecin,
            'idpatient' => $idpatient
        ]);
    }

    public function selectWhereMessages($idpatient)
    {
        $requete = "
            SELECT m.*, med.nom AS nomMedecin, med.prenom AS prenomMedecin
            FROM message m
            JOIN medecin med ON m.idmedecin = med.idmedecin
            WHERE m.idpatient = :idpatient
            ORDER BY m.date DESC;
        ";

        $select = $this->bdd->prepare($requete);
        $select->execute(['idpatient' => $idpatient]);
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }
}
