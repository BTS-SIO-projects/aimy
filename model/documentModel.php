<?php

// MODELE DU DOCUMENTS, RAJOUTER DES FONCTIONS SI BESOIN
class Document
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function selectAllDocuments()
    {
        $requete = "select * from document ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesDocuments = $select->fetchAll();
        return $lesDocuments;
    }

    function selectDocumentsByRdv($idrdv)
    {
        global $bdd;
        $query = $bdd->prepare("SELECT * FROM document WHERE idrdv = ?");
        $query->execute([$idrdv]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterDocument($idrdv, $description, $fileType, $filePath, $datedepot, $idmedecin, $idpatient)
    {
        $requete = "INSERT INTO document (typeDoc, url, datedepot, description, idmedecin, idpatient, idrdv) 
                    VALUES (:fileType, :filePath, :datedepot, :description, :idmedecin, :idpatient, :idrdv)";

        // Préparation de la requête
        $select = $this->bdd->prepare($requete);

        // Liaison des paramètres
        $select->bindParam(':fileType', $fileType);
        $select->bindParam(':filePath', $filePath);
        $select->bindParam(':datedepot', $datedepot);
        $select->bindParam(':description', $description);
        $select->bindParam(':idrdv', $idrdv);

        // Gestion des valeurs NULL correctement
        if ($idmedecin !== null) {
            $select->bindParam(':idmedecin', $idmedecin);
        } else {
            $select->bindValue(':idmedecin', null, PDO::PARAM_NULL);
        }

        if ($idpatient !== null) {
            $select->bindParam(':idpatient', $idpatient);
        } else {
            $select->bindValue(':idpatient', null, PDO::PARAM_NULL);
        }

        // Exécution de la requête
        $select->execute();
    }

    public function supprimerDocument($iddocument)
    {
        $requete = "delete from document where iddocument=" . $iddocument . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }
    public function supprimerDocuments($idrdv)
    {
        $requete = "DELETE FROM document WHERE idrdv = :idrdv";
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':idrdv', $idrdv, PDO::PARAM_INT);
        $select->execute();
    }
}
