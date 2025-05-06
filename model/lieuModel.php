<?php
class Lieu
{
    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function selectAllLieux()
    {
        $requete = "select * from lieu ;";
        //preparation de la requete 
        $select = $this->bdd->prepare($requete);
        //execution de la requete 
        $select->execute();
        //extraction des données 
        $lesLieux = $select->fetchAll();
        return $lesLieux;
    }

    public function selectWhereLieu($idlieu)
    {
        $requete = "select * from lieu where idlieu=" . $idlieu . ";";
        $select = $this->bdd->prepare($requete);
        $select->execute();
        $unLieu = $select->fetch();
        return $unLieu;
    }
}
