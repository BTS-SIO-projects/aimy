<?php
class Specialite
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function selectAllSpecialites()
    {
        $requete = "select * from specialite ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        return $select->fetchAll();;
    }

    public function selectWhereSpecialite($idspecialite)
    {
        $requete = "select * from specialite where idspecialite=" . $idspecialite . ";";
        $select = $this->bdd->prepare($requete);
        $select->execute();
        $uneSpecialite = $select->fetch();
        return $uneSpecialite;
    }

    public function insertSpecialite($nom)
    {
        $requete = "insert into specialite values (null, '"
            . $nom . "');";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }

    public function updateSpecialite($tab)
    {
        $requete = "update specialite set nom='"
            . $tab['nom'] . "' "
            . " where idspecialite=" . $tab['idspecialite'] . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }

    public function deleteSpecialite($idspecialite)
    {
        $requete = "delete from specialite where idspecialite=" . $idspecialite . ";";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
    }
}
