<?php 
require_once '/var/www/html/process/dbConnector.php';

class ville{
    static function getAllVille(){
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idVille,libelle FROM Ville');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    static function addVille($libelle){
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('INSERT INTO Ville (libelle) VALUES (:libelle)');
        $query->execute(['libelle' => $libelle]);
        return $pdo->lastInsertId();
    }


    static function getVilleByLibelle($libelle){
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idVille,libelle FROM Ville WHERE libelle = :libelle');
        $query->execute(['libelle' => $libelle]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}