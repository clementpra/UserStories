<?php
require_once '/var/www/html/process/dbConnector.php';

class relation
{
    static function getAllRelation()
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idConnaissance,idPersonne,idPersonne_1 FROM Connaissance');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getAllRelationForShow()
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idConnaissance,
        personne.nom as nom_personne1,
        personne.prenom as prenom_personne1,
        personne_1.nom as nom_personne2,
        personne_1.prenom as prenom_personne2,
        annee,
        Ville.libelle,
        commentaire,
        idLien 
        FROM Connaissance 
        left join Ville ON  Connaissance.idVille = Ville.idVille
        LEFT join personne on Connaissance.idPersonne = personne.idPersonne
        LEFT join personne as personne_1 on Connaissance.idPersonne_1 = personne_1.idPersonne');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getAllRelationForGraph()
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idConnaissance,idPersonne,idPersonne_1,annee,idVille,idLien FROM Connaissance');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static function addRelation($idPersonne1, $idPersonne2, $idAuteur, $annee, $idVille, $commentaire, $idLien)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('INSERT INTO Connaissance (idPersonne, idPersonne_1,idPersonne_Auteur,annee,idVille,commentaire,idLien) VALUES (:idPersonne1, :idPersonne2,:idAuteur, :annee, :idVille,:commentaire, :idLien)');
        $query->execute(['idPersonne1' => $idPersonne1, 'idPersonne2' => $idPersonne2, 'idAuteur' => $idAuteur, 'annee' => $annee, 'idVille' => $idVille, 'idLien' => $idLien, 'commentaire' => $commentaire]);
        return $pdo->lastInsertId();
    }

    static function getAllRelationType()
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idLien, libelle FROM typeLien WHERE 1');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getRelationForUser($idPersonne)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idConnaissance,
        personne.nom as nom_personne1,
        personne.prenom as prenom_personne1,
        personne_1.nom as nom_personne2,
        personne_1.prenom as prenom_personne2,
        annee,
        Ville.libelle,
        commentaire,
        idLien 
        FROM Connaissance 
        left join Ville ON  Connaissance.idVille = Ville.idVille
        LEFT join personne on Connaissance.idPersonne = personne.idPersonne
        LEFT join personne as personne_1 on Connaissance.idPersonne_1 = personne_1.idPersonne
        WHERE Connaissance.idPersonne = :idPersonne OR Connaissance.idPersonne_1 = :idPersonne');
        $query->execute(['idPersonne' => $idPersonne]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    static function getRelationCreatedByUser($idPersonne)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idConnaissance,
        personne.nom as nom_personne1,
        personne.prenom as prenom_personne1,
        personne_1.nom as nom_personne2,
        personne_1.prenom as prenom_personne2,
        annee,
        Ville.libelle,
        commentaire,
        idLien 
        FROM Connaissance 
        left join Ville ON  Connaissance.idVille = Ville.idVille
        LEFT join personne on Connaissance.idPersonne = personne.idPersonne
        LEFT join personne as personne_1 on Connaissance.idPersonne_1 = personne_1.idPersonne
        WHERE Connaissance.idPersonne_Auteur = :idPersonne');
        $query->execute(['idPersonne' => $idPersonne]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
